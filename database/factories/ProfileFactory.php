<?php

namespace Kaleidoscope\Factotum\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class ProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
	        'first_name' => $this->faker->firstName(),
	        'last_name'  => $this->faker->lastName(),
	        'phone'      => $this->faker->phoneNumber(),
	        'privacy'    => true,
	        'newsletter' => true,
        ];
    }

}
