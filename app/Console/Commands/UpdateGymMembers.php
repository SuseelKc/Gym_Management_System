<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Member;
use Illuminate\Console\Command;

class UpdateGymMembers extends Command
{
    protected $signature = 'gym:check-memberships';

    protected $description = 'Check and update gym memberships';

    public function handle()
    {
        $now = Carbon::now();

        $memberships = Member::whereNotNull('pricing_type')
            ->whereNotNull('pricing_date')
            ->get();

        foreach ($memberships as $membership) {
            $pricingDate = Carbon::parse($membership->pricing_date);
            $expiryDate = $pricingDate->copy();

            // Adjust expiry date based on pricing type
            switch ($membership->pricing_type) {
                case 'Year':
                    $expiryDate->addYear();
                    break;
                case 'Month':
                    $expiryDate->addMonth();
                    break;
                case 'Days':
                    $expiryDate->addDay();
                    break;   
                default:
                    // Handle other types if needed
                    break;
            }

            // Check if membership has expired
            if ($now->greaterThanOrEqualTo($expiryDate)) {
                // Membership expired, update fields to null
                $membership->update([
                    'pricing_type' => null,
                    'pricing_date' => null,
                    'pricing_id'=>null
                ]);
            }
        }

        $this->info('Gym memberships updated successfully.');
    }
}
