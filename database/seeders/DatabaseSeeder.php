<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Test User',
            'username' => 'testuser', // <<< TAMBAHKAN BARIS INI
            'email' => 'test@example.com',
        ]);

        // Panggil seeder lain di sini jika ada
        $this->call(DefaultMylistsSeeder::class); 
    }
}
