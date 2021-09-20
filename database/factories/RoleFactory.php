<?php

namespace Kaleidoscope\Factotum\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use Kaleidoscope\Factotum\Models\Role;



class RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Role::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
	        'role'                   => $this->faker->name(),
	        'backend_access'         => true,
	        'manage_content_types'   => true,
	        'manage_users'           => true,
	        'manage_media'           => true,
	        'manage_settings'        => true,
	        'manage_categories'      => true,

	        'manage_brands'              => true,
	        'manage_products'            => true,
	        'manage_orders'              => true,
	        'manage_discount_codes'      => true,
	        'manage_product_categories'  => true,
	        'manage_carts'               => true,
	        'manage_taxes'               => true,

	        'manage_newsletters'      => true,

		];
    }

}
