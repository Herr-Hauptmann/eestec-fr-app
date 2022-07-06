<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->company(),
            'address' => $this->faker->address(),
            'website' => $this->faker->url(),
            'description' => $this->faker->text(50),
            'comment' => $this->faker->sentence(10),
        ];
    }
}
