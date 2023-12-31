<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductReview;

class ProductReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $review = ProductReview::create([
            'user_id' => '1',
            'product_id' => '6',
            'review' => 'Et Vim Graeco Principes. Cu Dico Nullam Pri Stet Possim Quaerendum.',
            'rating' => '2',
            'status' => 'pending',
        ]);

        $review = ProductReview::create([
            'user_id' => '3',
            'product_id' => '8',
            'review' => 'Et Vim Graeco Principes. Cu Dico Nullam Pri Stet Possim Quaerendum.',
            'rating' => '3',
            'status' => 'pending',
        ]);

        $review = ProductReview::create([
            'user_id' => '1',
            'product_id' => '4',
            'review' => 'Et Vim Graeco Principes. Cu Dico Nullam Pri Stet Possim Quaerendum.',
            'rating' => '4',
            'status' => 'pending',
        ]);
    }
}
