<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['role_name' => 'Admin', 'description' => 'Admin role'],
            ['role_name' => 'Contributor', 'description' => 'Contributor role'],
            ['role_name' => 'Subscriber', 'description' => 'Subscriber role'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }


        $adminRole = Role::where('role_name', 'Admin')->first();
        $user = User::first();

        if ($adminRole && $user)
        {
            $user->roles()->syncWithoutDetaching($adminRole->id);
        }
    }
}
