<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use App\Models\SubscriptionPlan;
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
        // User::factory()->count(50)->create();

        // User::factory()->count(50)->create()->each(function ($user) {
        //     $restaursant = Restaurant::factory()->create();
        //     $user->assignRole('operator');
        //     $user->restaurants()->attach($restaurant->id);
        // });

        // Get all subscription plans
        $plans = SubscriptionPlan::all();

        // Create restaurant owners and assign subscription plans
        User::factory()->count(50)->create()->each(function ($user) use ($plans) {
            // Get a random subscription plan
            $plan = $plans->random();

            // Assign the role of restaurant owner to the user
            $user->assignRole('restaurant_owner');

            // Associate the subscription plan with the user
            $user->subscriptionPlan()->associate($plan);
            $user->save();

            // Create a restaurant for the user
            Restaurant::factory()->create(['owner_id' => $user->id]);
        });
    }

}
