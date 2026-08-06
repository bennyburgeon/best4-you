<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Insert default job types
        $types = [
            ['name' => 'Full Time', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Part Time', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Contract', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Freelancer', 'created_at' => now(), 'updated_at' => now()],
        ];
        DB::table('job_types')->insert($types);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_types');
    }
};
