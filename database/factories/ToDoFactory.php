<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ToDoFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => fake()->word(),
            'description' => fake()->text(),
        ];
    }
}
