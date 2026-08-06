<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            ['name' => 'Indian Rupee', 'code' => 'INR', 'symbol' => '₹'],
            ['name' => 'US Dollar', 'code' => 'USD', 'symbol' => '$'],
            ['name' => 'UAE Dirham', 'code' => 'AED', 'symbol' => 'AED'],
        ];

        foreach ($currencies as $currency) {
            \App\Models\Currency::updateOrCreate(['code' => $currency['code']], $currency);
        }
    }
}
