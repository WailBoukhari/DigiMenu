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
        // Create regular users
        User::factory()->count(3)->create();

        // Retrieve all subscription plans
        $plans = SubscriptionPlan::all();

        // Create restaurant owners
        User::factory()->count(3)->create()->each(function ($owner) use ($plans) {
            // Assign a random subscription plan
            $plan = $plans->random();
            $owner->subscriptionPlan()->associate($plan);

            // Assign the restaurant owner role
            $owner->assignRole('restaurant_owner');

            // Create and associate a restaurant with the owner
            $restaurant = Restaurant::factory()->create(['owner_id' => $owner->id]);
            $owner->restaurants()->save($restaurant);

            // Update owner's email
            $owner->email = str_replace(' ', '', $owner->name) . '@owner.com';
            $owner->save();

            // Create operators associated with this owner's restaurant
            User::factory()->count(1)->create()->each(function ($operator) use ($restaurant) {
                // Assign the operator role
                $operator->assignRole('operator');

                // Associate the operator with the restaurant
                $operator->restaurants()->attach($restaurant);

                // Update operator's email
                $operator->email = str_replace(' ', '', $operator->name) . '@operator.com';
                $operator->save();
            });
        });
    }
}
