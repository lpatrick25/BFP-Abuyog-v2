<?php

namespace App\Services;

use App\Models\Fsic;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FsicService
{

    public function getFsicList()
    {
        $fsic = Fsic::with(['application.establishment.client']);

        if (auth()->user()->role === 'Client') {
            $clientId = auth()->user()->client->id;

            $fsic = $fsic->whereHas('application.establishment', function ($query) use ($clientId) {
                $query->where('client_id', $clientId);
            });
        }

        return $fsic;
    }

    public function store(array $data)
    {
        try {
            DB::beginTransaction();

            $schedule = Schedule::where('application_id', $data['application_id'])->first();

            $data['fsic_no'] = $this->generateUniqueFsicNo();

            $data['issue_date'] = now()->format('Y-m-d');
            $data['expiration_date'] = now()->addYear()->format('Y-m-d');
            $data['inspector_id'] = $schedule->inspector_id;

            $user = Auth::user();
            $data['marshall_id'] = $user->marshall->id;

            $fsic = Fsic::create($data);

            DB::commit();

            return $fsic;
        } catch (\Exception $e) {
            DB::rollBack();

            return null;
        }
    }

    private function generateUniqueFsicNo(): string
    {
        do {
            $fsic_no = 'R08-' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (Fsic::where('fsic_no', $fsic_no)->exists());

        return $fsic_no;
    }
}
