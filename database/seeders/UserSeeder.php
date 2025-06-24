<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeding Users
        User::factory(10)->create();

        // Create user role entries
        $adminRole = Role::where('role_name', 'Admin')->first();
        $user = User::first(); // Fetch the first user from the database

        if ($adminRole && $user) {
            $user->roles()->attach($adminRole->id);
        }

        /////

        $nonAdminRoles = Role::where('role_name', '!=', 'Admin')->get();
        if ($nonAdminRoles->isEmpty()) {
            echo "No non-admin roles found. Skipping role assignment.\n";
            return;
        }
        $nonAdminUsers = User::whereDoesntHave('roles', function ($query) {
            $query->where('role_name', 'Admin');
        })->get();

        foreach ($nonAdminUsers as $user) {
            $randomRoles = collect($nonAdminRoles->random(rand(1, min(2, $nonAdminRoles->count()))));
            $user->roles()->attach($randomRoles->pluck('id'));
        }
    }
}
