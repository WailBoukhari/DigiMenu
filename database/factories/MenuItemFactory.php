<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MenuItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'menu_id' => Menu::factory(),
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 5, 20),
        ];
    }
}
