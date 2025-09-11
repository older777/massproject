<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AddAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate([
            'name' => 'admin',
        ], [
            'name' => 'admin',
            'email' => 'test@example.com',
            'password' => Hash::make('123'),
            'email_verified_at' => Carbon::now(),
        ]);
    }
}
