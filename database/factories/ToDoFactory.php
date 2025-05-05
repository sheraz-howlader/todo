<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ToDoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->text(20),
            'description' => fake()->sentence(100),
        ];
    }
}
