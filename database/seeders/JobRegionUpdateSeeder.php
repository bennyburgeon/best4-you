<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;
use App\Models\Region;

class JobRegionUpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the region named 'India'
        $indiaRegion = Region::where('slug', 'india')->first();

        if ($indiaRegion) {
            // Update all jobs where region_id is null
            $updatedCount = Job::whereNull('region_id')->update([
                'region_id' => $indiaRegion->id
            ]);

            $this->command->info("Successfully updated {$updatedCount} jobs with 'India' region ID.");
        } else {
            $this->command->error("Region 'India' not found in database. Please seed regions first.");
        }
    }
}
