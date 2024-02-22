<?php

namespace Database\Factories;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RestaurantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Restaurant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Get a user with the role of restaurant owner
        $owner = User::role('restaurant_owner')->inRandomOrder()->first();

        // If no such user exists, create one
        if (!$owner) {
            $owner = User::factory()->create();
            $owner->assignRole('restaurant_owner');
        }


        return [
            'name' => $this->faker->company(),
            'address' => $this->faker->address(),
            'contact_number' => $this->faker->phoneNumber(),
            'description' => $this->faker->paragraph(),
            'image' => null,
            'media' => null,
            'owner_id' => $owner->id,
        ];
    }
}
