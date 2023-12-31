<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = Product::create([
            'title' => 'Skin',
            'image' => 'theme/home/assets/imgs/lookingimg1.jpg',
            'description' => 'skincare is not one-size-fits-all'
        ]);

        $product = Product::create([
            'title' => 'Hair',
            'image' => 'theme/home/assets/imgs/lookingimg2.jpg',
            'description' => 'skincare is not one-size-fits-all'
        ]);

        $product = Product::create([
            'title' => 'Makeup',
            'image' => 'theme/home/assets/imgs/lookingimg3.jpg',
            'description' => 'skincare is not one-size-fits-all'
        ]);

        $product = Product::create([
            'title' => 'Hair Styling',
            'image' => 'theme/home/assets/imgs/lookingimg4.jpg',
            'description' => 'skincare is not one-size-fits-all'
        ]);
    }
}
