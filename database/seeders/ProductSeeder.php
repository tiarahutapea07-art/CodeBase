<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first(); // admin dari AdminSeeder

        $fashion    = Category::firstOrCreate(['slug' => 'fashion'],    ['name' => 'Fashion']);
        $elektronik = Category::firstOrCreate(['slug' => 'elektronik'], ['name' => 'Elektronik']);

        $products = [
            [
                'user_id'     => $user->id,
                'category_id' => $fashion->id,
                'name'        => 'Jaket Cheongsam',
                'description' => 'Jaket warna hitam dengan model trendy, kondisi sangat baik.',
                'price'       => 150000,
                'condition'   => 'Sangat Baik',
                'image_url'   => 'images/jaket.jpeg',
            ],
            [
                'user_id'     => $user->id,
                'category_id' => $fashion->id,
                'name'        => 'Sepatu Nike',
                'description' => 'Sepatu Nike warna hitam putih bekas, kondisi masih sangat baik.',
                'price'       => 250000,
                'condition'   => 'Sangat Baik',
                'image_url'   => 'images/sepatu.jpeg',
            ],
            [
                'user_id'     => $user->id,
                'category_id' => $elektronik->id,
                'name'        => 'TV LED Samsung 32 Inch',
                'description' => 'TV LED Samsung 32 inch bekas, layar masih jernih dan kondisi sangat baik.',
                'price'       => 1500000,
                'condition'   => 'Sangat Baik',
                'image_url'   => 'images/TV.jpeg',
            ],
        ];

        foreach ($products as $p) {
            Product::create($p);
        }
    }
}