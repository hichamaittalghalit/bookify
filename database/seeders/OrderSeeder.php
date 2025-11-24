<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Order;
use App\Models\PayPal;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        
        $books = Book::all();
        $paypals = PayPal::all();

        if ($books->isEmpty() || $paypals->isEmpty()) {
            $this->command->warn('Books or PayPals not found. Please run BookSeeder and PayPalSeeder first.');
            return;
        }

        for ($i = 1; $i <= 100; $i++) {
            // Create a new user for each order with Faker
            $user = User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'role' => 'user',
            ]);

            // Select a random book and paypal
            $book = $books->random();
            $paypal = $paypals->random();

            // Generate unique order number
            $orderNum = 'ORD-' . strtoupper(Str::random(8)) . '-' . date('Ymd') . '-' . str_pad($i, 6, '0', STR_PAD_LEFT);

            // Create the order with Faker data
            Order::create([
                'num' => $orderNum,
                'paypal_payment_id' => 'PAYID-' . strtoupper(Str::random(17)),
                'paypal_payer_id' => 'PAYER-' . strtoupper(Str::random(17)),
                'paypal_id' => $faker->boolean(80) ? $paypal->id : null,
                'user_id' => $user->id,
                'book_id' => $book->id,
                'price' => $book->price ?? $faker->randomFloat(2, 15.00, 49.99),
            ]);
        }
    }
}

