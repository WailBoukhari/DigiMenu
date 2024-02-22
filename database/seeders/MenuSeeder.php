<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Get all restaurant owners
        $restaurantOwners = User::whereHas('roles', function ($query) {
            $query->where('name', 'restaurant_owner');
        })->get();

        // Create three menus for each restaurant owner
        $restaurantOwners->each(function ($owner) {
            Menu::factory()->count(3)->create(['user_id' => $owner->id])
                ->each(function ($menu) {
                    MenuItem::factory()->count(10)->create(['menu_id' => $menu->id]);
                });
        });
    }
}
