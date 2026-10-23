<?php

namespace Database\Seeders;

use App\Enum\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Create one example user for each available role.
     */
    public function run(): void
    {
        $users = [
            [
                'firstName' => 'Admin',
                'lastName' => 'User',
                'email' => 'admin@root.com',
                'role' => Role::Admin,
            ],
            [
                'firstName' => 'Editor',
                'lastName' => 'User',
                'email' => 'editor@example.com',
                'role' => Role::Editor,
            ],
            [
                'firstName' => 'Subscriber',
                'lastName' => 'User',
                'email' => 'subscriber@example.com',
                'role' => Role::Subscriber,
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    ...$user,
                    'image' => '',
                    'password' => '12345678',
                ],
            );
        }
    }
}
