<?php

use App\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed test admin
        $seededAdminEmail = 'admin@admin.com';
        $user = User::where('email', '=', $seededAdminEmail)->first();
        if ($user === null) {
            $user = User::create([
                'name'                           => 'Admin',
                'email'                          => $seededAdminEmail,
                'password'                       => Hash::make('password'),
                'remember_token'                 => Str::random(64),
            ]);

            $user->save();
        }

        // Seed test user
        $user = User::where('email', '=', 'user@user.com')->first();
        if ($user === null) {
            $user = User::create([
                'name'                           => 'User',
                'email'                          => 'user@user.com',
                'password'                       => Hash::make('password'),
                'remember_token'                 => Str::random(64),
            ]);

            $user->save();
        }
    }
}
