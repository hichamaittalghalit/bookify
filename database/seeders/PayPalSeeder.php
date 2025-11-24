<?php

namespace Database\Seeders;

use App\Models\PayPal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PayPalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 1; $i <= 3; $i++) {
            PayPal::create([
                'title' => $faker->company() . ' PayPal Account',
                'email' => $faker->unique()->companyEmail(),
                'test_client_id' => 'test_' . Str::random(32),
                'test_secret_key' => 'test_secret_' . Str::random(40),
                'live_client_id' => 'live_' . Str::random(32),
                'live_secret_key' => 'live_secret_' . Str::random(40),
                'is_active' => $faker->boolean(70),
                'transactions_count' => $faker->numberBetween(0, 1000),
            ]);
        }
    }
}

