<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roles = fake()->randomElement(['A', 'C', 'S']);
        return [
            'role_name' => $roles,
            'description' => match ($roles) {
                        'A' => 'Admin role',
                        'C' => 'Contributor role',
                        default => 'Subscriber role',
        }
        ];
    }
}
