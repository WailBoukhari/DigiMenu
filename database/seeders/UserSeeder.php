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
        User::factory()->count(3)->create();

        $plans = SubscriptionPlan::all();

        User::factory()->count(3)->create()->each(function ($user) use ($plans) {
            $plan = $plans->random();
            $user->subscriptionPlan()->associate($plan);

            $user->assignRole('restaurant_owner');

            $restaurant = Restaurant::factory()->create(['owner_id' => $user->id]);
            $user->restaurants()->save($restaurant);

            $user->email = str_replace(' ', '', $user->name) . '@owner.com';
            $user->save();
        });

        User::factory()->count(3)->create()->each(function ($user) {
            // Assign the operator role
            $user->assignRole('operator');

            // Get a random existing restaurant
            $restaurant = Restaurant::inRandomOrder()->first();

            // If a restaurant exists, associate the operator with it
            if ($restaurant) {
                // Associate the operator with the restaurant
                $user->restaurants()->attach($restaurant);
            }

            // Save the user with updated email
            $user->email = str_replace(' ', '', $user->name) . '@operator.com';
            $user->save();
        });
    }
}
