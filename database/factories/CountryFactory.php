<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>uniqid(),
            'user_id'=>uniqid(),
            'ISO' => chr(rand(65,90)).chr(rand(65,90))
        ];
    }
}
