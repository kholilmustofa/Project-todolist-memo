<?php

namespace Database\Seeders;

use App\Models\Mylist; // Import the Mylist model
use App\Models\User;   // Import the User model
use Illuminate\Database\Seeder;

class DefaultMylistsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua user yang ada di database
        $users = User::all();

        // Daftar nama-nama list default
        $defaultListNames = [
            'Personal',
            'Work',
            'Grocery List'
        ];

        foreach ($users as $user) {
            foreach ($defaultListNames as $listName) {
                // Periksa apakah list dengan nama ini sudah ada untuk user ini
                $existingList = Mylist::where('user_id', $user->id)
                    ->where('name', $listName)
                    ->first();

                // Jika list belum ada, buat list default untuk user ini
                if (!$existingList) {
                    Mylist::create([
                        'user_id' => $user->id,
                        'name' => $listName,
                    ]);
                }
            }
        }
    }
}
