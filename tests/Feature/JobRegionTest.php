<?php

namespace Tests\Feature;

use App\Models\Job;
use App\Models\Region;
use App\Models\User;
use App\Models\JobCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobRegionTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_fetch_regions()
    {
        Region::create(['name' => 'Test Region', 'slug' => 'test-region', 'status' => true]);

        $response = $this->getJson('/api/regions');

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Test Region']);
    }

    public function test_guest_can_filter_jobs_by_region()
    {
        $regionIndia = Region::where('slug', 'india')->first();
        $regionEurope = Region::where('slug', 'europe')->first();
        $category = JobCategory::create(['name' => 'IT', 'symbol' => 'IT']);

        $jobIndia = Job::create([
            'title' => 'Developer India',
            'job_category_id' => $category->id,
            'region_id' => $regionIndia->id
        ]);

        $jobEurope = Job::create([
            'title' => 'Developer Europe',
            'job_category_id' => $category->id,
            'region_id' => $regionEurope->id
        ]);

        // Filter by region slug
        $response = $this->getJson('/api/jobs?region=india');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['title' => 'Developer India']);
        $response->assertJsonMissing(['title' => 'Developer Europe']);
    }

    public function test_admin_can_create_region()
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin, 'sanctum')->postJson('/api/regions', [
            'name' => 'New Region',
            'status' => true
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('regions', ['name' => 'New Region']);
    }
}
