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
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        DB::table('regions')->insert([
            ['name' => 'India', 'slug' => 'india', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Gulf', 'slug' => 'gulf', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Europe', 'slug' => 'europe', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Others', 'slug' => 'others', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regions');
    }
};
