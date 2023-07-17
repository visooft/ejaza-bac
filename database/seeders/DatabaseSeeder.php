<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => "Ahmed",
            'email' => "ahmed@gmail.com",
            'phone' => "1234567896",
            'password' => Hash::make('12345678'),
            'country_id' => 1,
            'role_id' => 1,
            'device_token' => "w eduhefukafkawgfkagsfjagsfkjas",
            'link' => "https://visooft-code.com"
        ]);
    }
}
