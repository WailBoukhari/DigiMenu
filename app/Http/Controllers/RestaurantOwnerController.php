<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantOwnerController extends Controller
{
    public function dashboard()
    {
        $this->authorize('viewDashboard', Auth::user());

        $user = auth()->user();
        $hasSubscription = $user->subscriptionPlan;
        $subscriptionExpired = $user->subscription_expires_at && now() > $user->subscription_expires_at;

        $remainingTime = null;
        if ($hasSubscription && !$subscriptionExpired) {
            $remainingTime = now()->diff($user->subscription_expires_at)->format('%d days %h hours %i minutes');
        }

        return view('restaurant_owner.dashboard', compact('user', 'hasSubscription', 'remainingTime', 'subscriptionExpired'));
    }

    public function menuItemsIndex()
    {
        $this->authorize('viewMenuItems', Auth::user());

        $subscriptionExpired = auth()->user()->subscriptionExpired();
        $menuItems = $subscriptionExpired ? collect() : MenuItem::all();

        return view('restaurant_owner.menu_items.index', compact('menuItems', 'subscriptionExpired'));
    }

    public function menuItemsCreate()
    {
        $this->authorize('createMenuItem', MenuItem::class);

        $menus = auth()->user()->menus;
        return view('restaurant_owner.menu_items.create', compact('menus'));
    }

    public function menuItemsStore(Request $request)
    {
        $this->authorize('createMenuItem', MenuItem::class);

        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'menu_id' => 'required',
        ]);

        MenuItem::create($validatedData);

        return redirect()->route('restaurant.menus.index')->with('success', 'Menu item created successfully.');
    }

    public function menuItemsEdit(MenuItem $menuItem)
    {
        $this->authorize('editMenuItem', $menuItem);

        return view('restaurant_owner.menu_items.edit', compact('menuItem'));
    }

    public function menuItemsUpdate(Request $request, MenuItem $menuItem)
    {
        $this->authorize('editMenuItem', $menuItem);

        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        $menuItem->update($validatedData);

        return redirect()->route('restaurant.menus.index')->with('success', 'Menu item updated successfully.');
    }

    public function menuItemsDestroy(MenuItem $menuItem)
    {
        $this->authorize('deleteMenuItem', $menuItem);

        $menuItem->forceDelete();
        return redirect()->route('restaurant.menus.index')->with('success', 'Menu item deleted successfully.');
    }

    public function menuIndex()
    {
        $this->authorize('viewMenus', Auth::user());

        $subscriptionExpired = auth()->user()->subscriptionExpired();
        $menus = Auth::user()->menus;

        return view('restaurant_owner.menus.index', compact('menus', 'subscriptionExpired'));
    }

    public function menuCreate()
    {
        $this->authorize('createMenu', Menu::class);
        // $user = Auth::user();
        // $restaurant = $user->restaurants->first();
        // dd($restaurant);
        return view('restaurant_owner.menus.create');
    }

    public function menuStore(Request $request)
    {
        $this->authorize('createMenu', Menu::class);

        $request->validate([
            'name' => 'required',
        ]);

        $user = Auth::user();
        $restaurant = $user->restaurants->first();
       
        $menu = new Menu();
        $menu->name = $request->name;
        $menu->user_id = $user->id;
        $menu->restaurant_id = $restaurant->id;
        $menu->save();

        return redirect()->route('restaurant.menus.index')->with('success', 'Menu created successfully.');
    }


    public function menuEdit(Menu $menu)
    {
        $this->authorize('editMenu', $menu);

        return view('restaurant_owner.menus.edit', compact('menu'));
    }

    public function menuUpdate(Request $request, Menu $menu)
    {
        $this->authorize('editMenu', $menu);

        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $menu->update($validatedData);
        return redirect()->route('restaurant.menus.index')->with('success', 'Menu updated successfully.');
    }


    public function menuDestroy(Menu $menu)
    {
        $this->authorize('deleteMenu', $menu);

        $menu->forceDelete();
        return redirect()->route('restaurant.menus.index')->with('success', 'Menu deleted successfully.');
    }
    public function restaurantProfile()
    {
        $user = Auth::user();
        $restaurant = $user->restaurants->first();
        // dd($restaurant);

        // dd($restaurant);
        if ($restaurant) {
            $imageUrl = $restaurant->getFirstMediaUrl('images');
            $videoUrl = $restaurant->getFirstMediaUrl('videos');
            // $media = $restaurant->getMedia('images');
            // dd($media);
            // dd($imageUrl);

            return view('restaurant_owner.restaurant_profile.edit', compact('restaurant' , 'imageUrl'));
        } else {
            // User is a restaurant owner but doesn't have a restaurant
            return view('restaurant_owner.restaurant_profile.create');
        }
    }
    public function restaurantStore(Request $request)
    {
        $user = Auth::user();

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|file|mimes:mp4,avi,mov,wmv|max:20480',
        ]);

        // Create a new restaurant instance
        $restaurant = new Restaurant();
        $restaurant->name = $request->name;
        $restaurant->address = $request->address;
        $restaurant->contact_number = $request->contact_number;
        $restaurant->description = $request->description;

        // Save the restaurant
        $user->restaurants()->save($restaurant);

        // Handle file uploads for images
        if ($request->hasFile('image')) {
            $restaurant->addMedia($request->file('image'))->toMediaCollection('images');
        }

        // Handle file uploads for videos
        if ($request->hasFile('video')) {
            $restaurant->addMedia($request->file('video'))->toMediaCollection('videos');
        }

        return redirect()->route('restaurant.profile')->with('success', 'Restaurant created successfully.');
    }


    public function restaurantUpdate(Request $request, Restaurant $restaurant)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'video' => 'nullable|file|mimetypes:video/*',
        ]);

        // Update the restaurant details
        $restaurant->update($validatedData);

        // Handle file uploads for images
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Store the image in the 'images' collection
            $restaurant->clearMediaCollection('images');
            $restaurant->addMedia($image)->toMediaCollection('images');
        }

        // Handle file uploads for videos
        if ($request->hasFile('video')) {
            $video = $request->file('video');

            // Store the video in the 'videos' collection
            $restaurant->clearMediaCollection('videos');
            $restaurant->addMedia($video)->toMediaCollection('videos');
        }

        return redirect()->route('restaurant.profile')->with('success', 'Restaurant updated successfully.');
    }


    public function restaurantDestroy(Restaurant $restaurant)
    {
        $restaurant->delete();
        return redirect()->route('restaurant.profile')->with('success', 'Restaurant deleted successfully.');
    }

}
function compute($paris, $newyork, $london)
{
    // Calculate the total minutes difference between Paris and New York
    $paris_minutes = $paris->hours * 60 + $paris->minutes;
    $newyork_minutes = $newyork->hours * 60 + $newyork->minutes;
    $paris_newyork_difference = abs($paris_minutes - $newyork_minutes);

    // Calculate the total minutes difference between Paris and London
    $london_minutes = $london->hours * 60 + $london->minutes;
    $paris_london_difference = abs($paris_minutes - $london_minutes);

    // Calculate the total minutes difference between New York and London
    $newyork_london_difference = abs($newyork_minutes - $london_minutes);

    // Find the maximum difference among the three
    $max_difference = max($paris_newyork_difference, $paris_london_difference, $newyork_london_difference);

    // Return the maximum difference
    return $max_difference;
}