<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
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

        return redirect()->route('restaurant.menu.index')->with('success', 'Menu item created successfully.');
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

        return redirect()->route('restaurant.menu.index')->with('success', 'Menu item updated successfully.');
    }

    public function menuItemsDestroy(MenuItem $menuItem)
    {
        $this->authorize('deleteMenuItem', $menuItem);

        $menuItem->forceDelete();
        return redirect()->route('restaurant.menu.index')->with('success', 'Menu item deleted successfully.');
    }

    public function menusIndex()
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
            // Add other validation rules as needed
        ]);

        Menu::create($request->all());

        return redirect()->route('restaurant_owner.menus.index')->with('success', 'Menu created successfully.');
    }

    public function menuEdit(Menu $menu)
    {
        $this->authorize('editMenu', $menu);

        return view('restaurant_owner.menus.edit', compact('menu'));
    }

    public function menuUpdate(Request $request, Menu $menu)
    {
        $this->authorize('editMenu', $menu);

        $request->validate([
            'name' => 'required',
            // Add other validation rules as needed
        ]);

        $menu->update($request->all());

        return redirect()->route('restaurant_owner.menus.index')->with('success', 'Menu updated successfully.');
    }

    public function menuDestroy(Menu $menu)
    {
        $this->authorize('deleteMenu', $menu);

        $menu->delete();
        return redirect()->route('restaurant_owner.menus.index')->with('success', 'Menu deleted successfully.');
    }
}
