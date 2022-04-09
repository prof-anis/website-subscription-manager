<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->words(rand(3, 7), true),
            'description' => $this->faker->words(rand(7, 10), true),
            'body' => $this->faker->sentences(3, true)
        ];
    }
}
