<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DwUserModel;
use Carbon\Carbon;

class BackfillUserIds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:backfill-ids';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate memberid and medical_card_no for users who don\'t have them.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fetch all users who don't have a memberid, ordered by creation date
        $users = DwUserModel::where(function($query) {
            $query->whereNull('memberid')
                  ->orWhere('memberid', '');
        })->orderBy('created_at', 'asc')->get();

        if ($users->isEmpty()) {
            $this->info('No users found needing backfill.');
            return;
        }

        $this->info('Found ' . $users->count() . ' users to backfill.');

        $counters = [];

        foreach ($users as $user) {
            $createdAt = $user->created_at ?: now();
            $year = $createdAt->format('Y');
            $yearShort = $createdAt->format('y');

            // Initialize or increment the counter for the specific year
            if (!isset($counters[$year])) {
                // To avoid collisions, we find the maximum serial used in any ID starting with 'DW-YYYY-'
                $lastMemberId = DwUserModel::where('memberid', 'like', "DW-$year-%")
                    ->orderBy('memberid', 'desc')
                    ->first();
                
                if ($lastMemberId) {
                    // Extract the last 3 digits
                    $parts = explode('-', $lastMemberId->memberid);
                    $counters[$year] = intval(end($parts));
                } else {
                    $counters[$year] = 0;
                }
            }

            $counters[$year]++;
            $serial = $counters[$year];

            // Ensure the generated ID is truly unique by checking in a loop
            $uniqueFound = false;
            while (!$uniqueFound) {
                $paddedSerial = str_pad($serial, 3, '0', STR_PAD_LEFT);
                $memberId     = 'DW-' . $year . '-' . $paddedSerial;

                if (!DwUserModel::where('memberid', $memberId)->exists()) {
                    $uniqueFound = true;
                } else {
                    $serial++;
                    $counters[$year] = $serial;
                }
            }

            // Medical Card Number generation logic (DWYY XXXX XX)
            $last4Mobile   = substr(preg_replace('/\D/', '', $user->user_mobile), -4);
            $cardSerial    = str_pad($serial, 2, '0', STR_PAD_LEFT);
            $medicalCardNo = 'DW' . $yearShort . ' ' . $last4Mobile . ' ' . $cardSerial;

            $user->memberid = $memberId;
            $user->medical_card_no = $medicalCardNo;
            $user->save();

            $this->line("Updated User ID {$user->id}: {$memberId} | {$medicalCardNo}");
        }

        $this->info('Backfill completed successfully.');
    }
}
