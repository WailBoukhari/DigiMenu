<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the menu items.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check if the subscription has expired for the current user
        $subscriptionExpired = auth()->user()->subscriptionExpired();

        // Fetch menu items based on the subscription status
        if ($subscriptionExpired) {
            // Subscription expired, no menu items to display
            $menuItems = [];
        } else {
            // Subscription active, fetch all menu items
            $menuItems = MenuItem::all();
        }

        // Pass data to the view
        return view('menu_items.index', compact('menuItems', 'subscriptionExpired'));
    }


    /**
     * Show the form for creating a new menu item.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('menu_items.create');
    }

    /**
     * Store a newly created menu item in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        MenuItem::create($validatedData);

        return redirect()->route('menu-items.index')->with('success', 'Menu item created successfully.');
    }

    /**
     * Show the form for editing the specified menu item.
     *
     * @param  \App\Models\MenuItem  $menuItem
     * @return \Illuminate\Http\Response
     */
    public function edit(MenuItem $menuItem)
    {
        return view('menu_items.edit', compact('menuItem'));
    }

    /**
     * Update the specified menu item in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MenuItem  $menuItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MenuItem $menuItem)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        $menuItem->update($validatedData);

        return redirect()->route('menu-items.index')->with('success', 'Menu item updated successfully.');
    }

    /**
     * Remove the specified menu item from storage.
     *
     * @param  \App\Models\MenuItem  $menuItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();
        return redirect()->route('menu-items.index')->with('success', 'Menu item deleted successfully.');
    }
}
