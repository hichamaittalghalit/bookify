<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 6; $i++) {
            $title = $faker->sentence(rand(3, 6));
            $slug = Str::slug($title);
            
            $description = $faker->paragraphs(rand(3, 5), true);
            
            Book::create([
                'title' => $title,
                'slug' => $slug,
                'description' => $description,
                'seo_title' => $faker->optional(0.7)->sentence(rand(4, 8)),
                'seo_description' => $faker->optional(0.7)->text(160),
                'image' => 'https://picsum.photos/seed/' . $slug . '/400/600',
                'path' => 'books/pdfs/' . $slug . '.pdf',
                'price' => $faker->randomFloat(2, 15.00, 49.99),
                'currency' => $faker->randomElement(['USD', 'EUR', 'GBP', 'CAD']),
                'is_active' => $faker->boolean(90),
                'is_featured' => $faker->boolean(40),
                'is_new' => $faker->boolean(30),
                'is_best_seller' => $faker->boolean(30),
            ]);
        }
    }
}

