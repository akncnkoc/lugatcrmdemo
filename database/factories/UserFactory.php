<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public function definition()
    {
        return [
      'name' => $this->faker->name,
      'surname' => $this->faker->lastName,
      'username' => 'demo',
      'email' => 'demo@mail.com',
      'password' => bcrypt('demo')
    ];
    }
}
