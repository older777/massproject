<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AddAdminSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ElasticIndexSeeder::class);
    }
}
