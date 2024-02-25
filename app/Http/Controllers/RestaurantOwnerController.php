<?php

namespace App\Http\Controllers;

use App\Events\MenuItemAdded;
use App\Events\MenuItemDeleted;
use App\Events\MenuItemEdited;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Restaurant;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $operator = Auth::user();

        $owner = $operator->restaurants->first()->owner;

        $subscriptionExpired = optional($owner->subscription_expires_at)->isPast();

        $message = $subscriptionExpired ? "The owner's subscription has ended. Please contact the owner to renew the subscription." : null;

        $userMenus = $owner->menus;
        $menuItems = collect();
        foreach ($userMenus as $menu) {
            $menuItems = $menuItems->merge($menu->menuItems);
        }
        return view('restaurant_owner.operator.menu_items_index', compact('menuItems', 'message', 'subscriptionExpired'));
    }



    public function menuItemsIndex()
    {
        $this->authorize('viewMenuItems', Auth::user());
        $owner = auth()->user();
        $subscriptionExpired = optional($owner->subscription_expires_at)->isPast();
        $userMenus = auth()->user()->menus;

        $menuItems = collect();

        foreach ($userMenus as $menu) {
            $menuItems = $menuItems->merge($menu->menuItems);
        }


        $subscriptionPlan = SubscriptionPlan::first();

        return view('restaurant_owner.menu_items.index', compact('menuItems', 'subscriptionExpired', 'subscriptionPlan'));
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
            'image' => 'required|image|max:2048', // Ensure the uploaded file is an image and not larger than 2MB
        ]);

        // Create new menu item
        $menuItem = MenuItem::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'menu_id' => $validatedData['menu_id'],
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Add the uploaded image to Spatie Media Library
            $menuItem->addMediaFromRequest('image')
                ->toMediaCollection('images');
        }

        // Dispatch event if needed
        event(new MenuItemAdded($menuItem));

        // Redirect with success message
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
            'image' => 'image|max:2048', // Ensure the uploaded file is an image and not larger than 2MB
        ]);

        // Update menu item fields
        $menuItem->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'menu_id' => $validatedData['menu_id'],
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Add the uploaded image to Spatie Media Library
            $menuItem->addMediaFromRequest('image')
                ->toMediaCollection('images');
        }

        // Redirect with success message
        return redirect()->route('restaurant.menu.index')->with('success', 'Menu item updated successfully.');
    }
    public function menuItemsDestroy(Request $request, MenuItem $menuItem)
    {
        $this->authorize('deleteMenuItem', $menuItem);
        event(new MenuItemDeleted($menuItem));
        $menuItem->forceDelete();



        return redirect()->route('restaurant.menu.index')->with('success', 'Menu item deleted successfully.');
    }

    public function menuOperatorIndex()
    {
        $this->authorize('viewMenus', Auth::user());

        $operator = Auth::user();

        $owner = $operator->restaurants->first()->owner;

        $subscriptionExpired = optional($owner->subscription_expires_at)->isPast();

        $message = $subscriptionExpired ? "The owner's subscription has ended. Please contact the owner to renew the subscription." : null;

        $menus = $owner->menus;
        return view('restaurant_owner.operator.menu_index', compact('menus', 'message', 'subscriptionExpired'));

    }
    public function menuIndex()
    {
        $this->authorize('viewMenus', Auth::user());

        $owner = auth()->user();
        $subscriptionExpired = optional($owner->subscription_expires_at)->isPast();
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

        return view('restaurant_owner.restaurant_profile.edit', compact('restaurant'));
    
        
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
        ]);

        // Create a new restaurant instance
        $restaurant = new Restaurant();
        $restaurant->name = $request->name;
        $restaurant->address = $request->address;
        $restaurant->contact_number = $request->contact_number;
        $restaurant->description = $request->description;
        $restaurant->owner_id = $user->id;


        // Save the restaurant
        $user->restaurants()->save($restaurant);

   
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
        ]);

        // Update the restaurant details
        $restaurant->update($validatedData);

        return redirect()->route('restaurant.profile')->with('success', 'Restaurant updated successfully.');
    }


    public function restaurantDestroy(Restaurant $restaurant)
    {
        $restaurant->delete();
        return redirect()->route('restaurant.profile')->with('success', 'Restaurant deleted successfully.');
    }
    public function showMenu($slug)
    {
        $restaurant = Restaurant::where('slug', $slug)->firstOrFail();
        // Retrieve the owner of the restaurant
        $owner = $restaurant->owner;

        // Retrieve all menus associated with the restaurant
        $userMenus = $owner->menus;



        $menuItems = collect();

        foreach ($userMenus as $menu) {
            $menuItems = $menuItems->merge($menu->menuItems);
        }

        return view('menu', compact('restaurant', 'owner', 'menuItems'));
    }


}