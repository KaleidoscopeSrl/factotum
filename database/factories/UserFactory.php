<?php

namespace Kaleidoscope\Factotum\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Kaleidoscope\Factotum\Models\Media;
use Kaleidoscope\Factotum\Models\User;
use Kaleidoscope\Factotum\Models\Role;


class UserFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = User::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
	    $role = Role::factory()->make();
	    $role->save();

	    $media = Media::factory()->make();
		$media->save();

		return [
			'email'             => $this->faker->unique()->safeEmail(),
			'email_verified_at' => now(),
			'password'          => Hash::make('12345678'),
			'editable'          => true,
			'role_id'           => $role->id,
			'avatar'            => $media->id,
		];
	}

	/**
	 * Indicate that the model's email address should be unverified.
	 *
	 * @return \Illuminate\Database\Eloquent\Factories\Factory
	 */
	public function unverified()
	{
		return $this->state(function (array $attributes) {
			return [
				'email_verified_at' => null,
			];
		});
	}

}
