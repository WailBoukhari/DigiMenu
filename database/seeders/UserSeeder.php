<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /** 
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory()->count(10)->create();

        $plans = SubscriptionPlan::all();

        // Create 10 restaurant_owner users with associated restaurants and subscription plans
        User::factory()->count(10)->create()->each(function ($user) use ($plans) {
            // Get a random subscription plan
            $plan = $plans->random();

            // Assign the role of restaurant owner to the user
            $user->assignRole('restaurant_owner');

            // Create a restaurant for the user
            $restaurant = Restaurant::factory()->create(['owner_id' => $user->id]);

            // Associate the restaurant with the user
            $user->restaurants()->save($restaurant);

            // Associate the subscription plan with the user
            $user->subscriptionPlan()->associate($plan);
            $user->save();
        });

        // User::factory()->count(10)->create()->each(function ($user) {
        //     $restaurant = Restaurant::factory()->create(['owner_id' => $user->id]);
        //     $user->assignRole('operator');
        //     $user->restaurants()->save($restaurant);
        // });
    }
}
  
