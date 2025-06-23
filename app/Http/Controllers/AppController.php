<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use App\Models\Fsic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class AppController extends Controller
{

    public function searchFSIC(Request $request)
    {
        $request->validate(['fsic_no' => 'required|string|exists:fsics,fsic_no']);

        $fsic_no = $request->fsic_no;

        $fsic = Fsic::with('application', 'inspector', 'marshall')
            ->where('fsic_no', $fsic_no)
            ->first();

        if (!$fsic) {
            return response()->json(['message' => 'FSIC No not found'], 404);
        }

        $existingMedia = $fsic->getFirstMedia('fsic_certificates');
        if ($existingMedia) {
            return response()->json([
                'fsic_no' => $fsic->fsic_no,
                'file_url' => $existingMedia->getUrl(),
                'html' => file_get_contents($existingMedia->getPath()) // Include existing HTML content
            ], 200);
        }

        $qrCodeMedia = $fsic->application->getMedia('fsic_requirements')->where('name', 'QR Code')->first();
        if ($qrCodeMedia) {
            $fsic->fsicQrCode = $qrCodeMedia->getUrl();
        }

        // Render HTML from Blade view
        $html = view('pdf.view_certificate', compact('fsic'))->render();

        // Save HTML to file
        $htmlFilePath = public_path('upload/fsic_certificate_' . $fsic->fsic_no . '.html');
        $directory = dirname($htmlFilePath);

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        try {
            file_put_contents($htmlFilePath, $html);

            // Add to media collection
            $media = $fsic->addMedia($htmlFilePath)->toMediaCollection('fsic_certificates');

            // Clean up temporary file
            File::delete($htmlFilePath);

            return response()->json([
                'fsic_no' => $fsic->fsic_no,
                'file_url' => $media->getUrl(),
                'html' => $html
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error saving HTML file', [
                'message' => $e->getMessage(),
                'fsic_no' => $fsic->fsic_no
            ]);
            return response()->json(['message' => 'Error saving HTML certificate'], 500);
        }
    }

    public function mapping()
    {
        $response = [];
        $establishmentsQuery = Establishment::query()->with(['applications.fsics']);

        $establishments = $establishmentsQuery->get();

        foreach ($establishments as $establishment) {
            $application = $establishment->applications->first();
            $inspected = $application && $application->fsics->isNotEmpty();

            if ($application) {
                $response[] = [
                    floatval($establishment->location_latitude),
                    floatval($establishment->location_longitude),
                    $establishment->id,
                    $inspected,
                    $inspected ? 'Inspected' : 'Not Inspected'
                ];
            }
        }

        return view('establishment', compact('response'));
    }
}
