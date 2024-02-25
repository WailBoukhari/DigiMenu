<?php

namespace App\Http\Controllers;

use App\Events\MenuItemAdded;
use App\Events\MenuItemDeleted;
use App\Events\MenuItemEdited;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantOwnerController extends Controller
{
    public function dashboardOwner()
    {
        $this->authorize('viewDashboard', Auth::user());

        $user = auth()->user();
        $hasSubscription = $user->subscriptionPlan;
        $subscriptionExpired = $user->subscription_expires_at && now() > $user->subscription_expires_at;

        $remainingTime = null;
        if ($hasSubscription && !$subscriptionExpired) {
            $remainingTime = now()->diff($user->subscription_expires_at)->format('%d days %h hours %i minutes');
        }

        return view('restaurant_owner.restaurant_owner_dashboard', compact('user', 'hasSubscription', 'remainingTime', 'subscriptionExpired'));
    }
    public function dashboardOperator()
    {
        $this->authorize('viewDashboard', Auth::user());

        $user = auth()->user();
        $hasSubscription = $user->subscriptionPlan;
        $subscriptionExpired = $user->subscription_expires_at && now() > $user->subscription_expires_at;

        $remainingTime = null;
        if ($hasSubscription && !$subscriptionExpired) {
            $remainingTime = now()->diff($user->subscription_expires_at)->format('%d days %h hours %i minutes');
        }

        return view('restaurant_owner.operator_dashboard', compact('user', 'hasSubscription', 'remainingTime', 'subscriptionExpired'));
    }

    public function menuItemOperatorIndex()
    {

        $this->authorize('viewMenuItems', Auth::user());

        $subscriptionExpired = auth()->user()->subscriptionExpired();

        $userMenus = auth()->user()->menus;

        $menuItems = collect();

        foreach ($userMenus as $menu) {
            $menuItems = $menuItems->merge($menu->menuItems);
        }

        return view('restaurant_owner.operator.menu_items_index', compact('menuItems', 'subscriptionExpired'));
    }
    public function menuItemsIndex()
    {
        $this->authorize('viewMenuItems', Auth::user());

        $subscriptionExpired = auth()->user()->subscriptionExpired();

        $userMenus = auth()->user()->menus;

        $menuItems = collect();

        foreach ($userMenus as $menu) {
            $menuItems = $menuItems->merge($menu->menuItems);
        }

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

        $menuItem = MenuItem::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'menu_id' => $validatedData['menu_id'],
        ]);

        event(new MenuItemAdded($menuItem));


        return redirect()->route('restaurant.menu.index')->with('success', 'Menu item created successfully.');
    }

    public function menuItemsEdit(MenuItem $menuItem)
    {
        $this->authorize('editMenuItem', $menuItem);
        $menus = auth()->user()->menus;
        return view('restaurant_owner.menu_items.edit', compact('menuItem', 'menus'));
    }

    public function menuItemsUpdate(Request $request, MenuItem $menuItem)
    {
        $this->authorize('editMenuItem', $menuItem);

        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'menu_id' => 'required',

        ]);

        // Update the menu item
        $menuItem->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'menu_id' => $validatedData['menu_id'],

        ]);

        event(new MenuItemEdited($menuItem));

        return redirect()->route('restaurant.menu.index')->with('success', 'Menu item updated successfully.');
    }

    public function menuItemsDestroy(Request $request,MenuItem $menuItem)
    {
        $this->authorize('deleteMenuItem', $menuItem);
        event(new MenuItemDeleted($menuItem));
        $menuItem->forceDelete();

        

        return redirect()->route('restaurant.menu.index')->with('success', 'Menu item deleted successfully.');
    }
    public function menuOperatorIndex()
    {
        // Authorize the action based on the operator's permissions
        $this->authorize('viewMenus', Auth::user());

        // Get the current authenticated user (operator)
        $operator = Auth::user();

        // Retrieve the associated owner (restaurant owner)
        $owner = $operator->owner;

        // Check if the owner exists and has a valid subscription
        $subscriptionExpired = $owner ? $owner->subscriptionExpired() : true;

        // If the owner exists and has a valid subscription, update the operator's subscription expiration
        if ($owner && !$subscriptionExpired) {
            $operator->subscription_expires_at = $owner->subscription_expires_at;
            $operator->save();
        }

        // Retrieve the menus associated with the operator's owned restaurants
        $menus = $operator->menus;

        // Pass the data to the view and render it
        return view('restaurant_owner.operator.menu_index', compact('menus', 'subscriptionExpired'));
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

            return view('restaurant_owner.restaurant_profile.edit', compact('restaurant', 'imageUrl'));
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