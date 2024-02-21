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
        $userIds = User::pluck('id')->toArray(); // Get all user ids

        foreach ($userIds as $userId) {
            Menu::factory()->count(3)->create(['user_id' => $userId])
                ->each(function ($menu) {
                    MenuItem::factory()->count(10)->create(['menu_id' => $menu->id]);
                });
        }
    }
}
