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
        $users = User::all();

        // Create a menu for each user
        $users->each(function ($user) {
            $menu = Menu::factory()->create(['user_id' => $user->id]);
            MenuItem::factory()->count(10)->create(['menu_id' => $menu->id]);
        });
    }
}
