<?php

namespace App\Console\Commands;

use App\Models\Fsic;
use App\Mail\FSICExpirationMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class NotifyFsicExpiry extends Command
{
    protected $signature = 'notify:fsic-expiry';
    protected $description = 'Send email notifications to clients if FSIC is near expiration (7 days before, daily)';

    public function handle()
    {
        $today = Carbon::today();
        $expiringFsics = Fsic::whereDate('expiration_date', '>=', $today->copy()->addDays(1))
            ->whereDate('expiration_date', '<=', $today->copy()->addDays(7))
            ->get();

        Log::info('Found ' . $expiringFsics->count() . ' FSICs expiring in the next 7 days.');
        if ($expiringFsics->isEmpty()) {
            $this->info('No FSICs expiring in the next 7 days.');
            return;
        }
        Log::info('Sending FSIC expiry notifications...');
        $this->info('Sending FSIC expiry notifications...');

        foreach ($expiringFsics as $fsic) {
            $application = $fsic->application;
            if (!$application) continue;
            $establishment = $application->establishment;
            if (!$establishment) continue;
            $client = $establishment->client;
            if (!$client || !$client->email) continue;

            Mail::to($client->email)->queue(new FSICExpirationMail($fsic, $client));
        }
        $this->info('FSIC expiry notifications sent.');
    }
}
