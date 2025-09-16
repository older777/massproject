<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! Product::get()->count()) {
            $sql = file_get_contents('./database/seeders/ProductDump.sql');
            DB::unprepared($sql);

            Product::find(1)->addMedia(storage_path('app/product_init/image1.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(2)->addMedia(storage_path('app/product_init/image2.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(3)->addMedia(storage_path('app/product_init/image3.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(4)->addMedia(storage_path('app/product_init/image4.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(5)->addMedia(storage_path('app/product_init/image5.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(6)->addMedia(storage_path('app/product_init/image1.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(7)->addMedia(storage_path('app/product_init/image2.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(8)->addMedia(storage_path('app/product_init/image3.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(9)->addMedia(storage_path('app/product_init/image4.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(10)->addMedia(storage_path('app/product_init/image5.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(11)->addMedia(storage_path('app/product_init/image1.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(12)->addMedia(storage_path('app/product_init/image2.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(13)->addMedia(storage_path('app/product_init/image3.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(14)->addMedia(storage_path('app/product_init/image4.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(15)->addMedia(storage_path('app/product_init/image5.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(16)->addMedia(storage_path('app/product_init/image1.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(17)->addMedia(storage_path('app/product_init/image2.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(18)->addMedia(storage_path('app/product_init/image3.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(19)->addMedia(storage_path('app/product_init/image4.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(20)->addMedia(storage_path('app/product_init/image5.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(21)->addMedia(storage_path('app/product_init/image1.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(22)->addMedia(storage_path('app/product_init/image2.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(23)->addMedia(storage_path('app/product_init/image3.jpeg'))->preservingOriginal()->toMediaCollection('product');

            Product::find(26)->addMedia(storage_path('app/product_init/image6.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(27)->addMedia(storage_path('app/product_init/image7.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(28)->addMedia(storage_path('app/product_init/image8.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(29)->addMedia(storage_path('app/product_init/image9.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(30)->addMedia(storage_path('app/product_init/image10.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(31)->addMedia(storage_path('app/product_init/image6.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(32)->addMedia(storage_path('app/product_init/image7.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(33)->addMedia(storage_path('app/product_init/image8.jpeg'))->preservingOriginal()->toMediaCollection('product');

            Product::find(36)->addMedia(storage_path('app/product_init/image11.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(37)->addMedia(storage_path('app/product_init/image12.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(38)->addMedia(storage_path('app/product_init/image13.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(39)->addMedia(storage_path('app/product_init/image14.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(40)->addMedia(storage_path('app/product_init/image15.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(41)->addMedia(storage_path('app/product_init/image11.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(42)->addMedia(storage_path('app/product_init/image12.jpeg'))->preservingOriginal()->toMediaCollection('product');
            Product::find(43)->addMedia(storage_path('app/product_init/image13.jpeg'))->preservingOriginal()->toMediaCollection('product');
        }
    }
}
