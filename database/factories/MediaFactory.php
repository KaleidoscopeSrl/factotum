<?php

namespace Kaleidoscope\Factotum\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use Kaleidoscope\Factotum\Models\User;
use Kaleidoscope\Factotum\Models\Media;


class MediaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Media::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
	    $user = User::first();

        return [
	        'user_id'        => $user->id,
	        'filename'       => $this->faker->word() . rand(0, 1000) . '.jpg',
	        'filename_webp'  => $this->faker->word() . rand(0, 1000) . '.webp',

	        'thumb'          => $this->faker->word() . rand(0, 1000) . '_thumb.jpg',
	        'thumb_webp'     => $this->faker->word() . rand(0, 1000) . '_thumb.webp',

	        'url'            => $this->faker->imageUrl(),
	        'url_webp'       => $this->faker->imageUrl() . '.webp',

	        'mime_type'      => $this->faker->mimeType(),

	        'width'          => $this->faker->numberBetween(100, 500),
	        'height'         => $this->faker->numberBetween(100, 500),
	        'size'           => $this->faker->numberBetween(100, 500),

	        'caption'        => $this->faker->sentence(),
	        'alt_text'       => $this->faker->sentence(),
	        'description'    => $this->faker->sentence(),
        ];
    }
}
