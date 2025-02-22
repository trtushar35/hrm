<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'company_id' => null,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'password' => 'password', // Change this to your desired default password
            'role_id' => rand(1, 5), // Assuming roles range from 1 to 5
            'photo' => null,
            'address' => $this->faker->address,
            'status' => $this->faker->randomElement(['Active']),
            'remember_token' => Str::random(10),
        ];
    }
}
