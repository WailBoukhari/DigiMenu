<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Menu::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function () {
                // Get a random restaurant owner
                $restaurantOwner = User::role('restaurant_owner')->inRandomOrder()->first();
                return $restaurantOwner->id;
            },
            'restaurant_id' => function (array $attributes) {
                // Retrieve the restaurant ID associated with the user
                $restaurantOwner = User::findOrFail($attributes['user_id']);
                return $restaurantOwner->restaurants->first()->id;
            },
            'name' => $this->faker->word,
        ];
    }

}
