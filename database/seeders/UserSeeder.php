<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(50)->create();
        User::factory()->count(50)->create()->each(function ($user) {
            $restaurant = Restaurant::factory()->create(); 
            $user->assignRole('operator');
            $user->restaurants()->attach($restaurant->id);
        });

        User::factory()->count(50)->create()->each(function ($user) {
            $restaurant = Restaurant::factory()->create(['owner_id' => $user->id]);
            $user->assignRole('restaurant_owner');
            $user->restaurants()->attach($restaurant->id);
        });
    }


}
