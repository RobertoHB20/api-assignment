<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class ConsumersModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'id' => 'e9a39381-9bb0-37c1-aba5-117a13fd5d68',
            'secret' => Hash::make('password'),
        ];
    }
}
