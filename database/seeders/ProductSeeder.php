<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Jaket Denim Vintage Levi\'s',
            'description' => 'Jaket denim bekas pemakaian 6 bulan, kondisi 90% masih bagus.',
            'price' => 150000,
            'condition' => 'Sangat Baik',
            'image_url' => 'https://images.unsplash.com/photo-1576995853123-5a10305d93c0?w=500',
        ]);

        Product::create([
            'name' => 'Kamera Analog Canon AE-1',
            'description' => 'Kamera koleksi pribadi, fungsi normal, lensa mulus no jamur.',
            'price' => 850000,
            'condition' => 'Bekas Pemakaian Normal',
            'image_url' => 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=500',
        ]);

        Product::create([
            'name' => 'Sepatu Nike Air Jordan 1 Original',
            'description' => 'Size 42, kelengkapan replacement box. Tapak masih tebal.',
            'price' => 600000,
            'condition' => 'Lecet Pemakaian',
            'image_url' => 'https://images.unsplash.com/photo-1552346154-21d32810aba3?w=500',
        ]);
    }
}