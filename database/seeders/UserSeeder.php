<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* Admin */
        User::create([
            'id' => 1,
            'name' => 'Super',
            'surname' => 'Admin',
            'username' => 'SuperAdmin',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'avatar' => '/assets/avatars/admin.jpg',
            'password' => Hash::make('12345678')
        ]);

        /* User 1 */
        User::create([
            'id' => 2,
            'name' => 'Test1',
            'surname' => 'User',
            'username' => 'TestUser1',
            'email' => 'test1@test.com',
            'role' => 'user',
            'avatar' => '/assets/avatars/Testuser1.avif',
            'password' => Hash::make('12345678')
        ]);

        /* User 2 */
        User::create([
            'id' => 3,
            'name' => 'Test2',
            'surname' => 'User',
            'username' => 'TestUser2',
            'email' => 'test2@test.com',
            'role' => 'user',
            'avatar' => '/assets/avatars/Testuser2.avif',
            'password' => Hash::make('12345678')
        ]);

        /* User 3 */
        User::create([
            'id' => 4,
            'name' => 'Test3',
            'surname' => 'User',
            'username' => 'TestUser3',
            'email' => 'test3@test.com',
            'role' => 'user',
            'avatar' => '/assets/avatars/default.avif',
            'password' => Hash::make('12345678')
        ]);
    }
}
