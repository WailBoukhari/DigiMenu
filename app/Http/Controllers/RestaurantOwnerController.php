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
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        $categories = ['pizza', 'plates', 'salads', 'drinks', 'desserts'];

        return view('restaurant_owner.menu_items.create', compact('menus', 'categories'));
    }

    public function menuItemsStore(Request $request)
    {
        $this->authorize('createMenuItem', MenuItem::class);

        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'menu_id' => 'required',
            'category' => 'required|in:pizza,plates,salads,drinks,desserts',
        ]);

        MenuItem::create($validatedData);

        return redirect()->route('restaurant.menus.index')->with('success', 'Menu item created successfully.');
    }


    public function menuItemsEdit(MenuItem $menuItem)
    {
        $this->authorize('editMenuItem', $menuItem);

        $categories = ['pizza', 'plates', 'salads', 'drinks', 'desserts'];
        $menus = auth()->user()->menus;
        return view('restaurant_owner.menu_items.edit', compact('menuItem', 'menus', 'categories'));
    }
    public function menuItemsUpdate(Request $request, MenuItem $menuItem)
    {
        $this->authorize('editMenuItem', $menuItem);

        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'menu_id' => 'required',
            'category' => 'required|in:pizza,plates,salads,drinks,desserts',

        ]);

        $menuItem->update($validatedData);

        return redirect()->route('restaurant.menus.index')->with('success', 'Menu item updated successfully.');
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
        $restaurant = $user->restaurants->first(); // Get the first restaurant associated with the user
        if ($restaurant) {
            // User is a restaurant owner and has a restaurant
            return view('restaurant_owner.restaurant_profile.edit', compact('restaurant'));
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
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|file|mimes:mp4,avi,mov,wmv|max:20480',
        ]);

        // Retrieve the user's subscription
        $subscription = $user->subscriptionPlan;
        $maxScanLimit = $subscription->scan_limit;
    
        // Create a new restaurant instance
        $restaurant = new Restaurant();
        $restaurant->name = $request->name;
        $restaurant->address = $request->address;
        $restaurant->contact_number = $request->contact_number;
        $restaurant->description = $request->description;
        $restaurant->owner_id = $user->id;
        $restaurant->slug = Str::slug($request->name);
        $restaurant->max_scan_limit = $maxScanLimit;

        // Generate QR code
        $restaurantUrl = route('menu', ['restaurant' => $restaurant->slug]);
        $qrCode = QrCode::format('png')->size(200)->generate($restaurantUrl);
        // Store QR code image in the storage and save the path in the database
        $qrCodePath = 'qr-codes/' . uniqid() . '.png';
        Storage::disk('public')->put($qrCodePath, $qrCode);
        $restaurant->qr_code_path = $qrCodePath;

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
        $validatedRequest = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|file|mimes:mp4,avi,mov,wmv|max:20480',
        ]);

        // Retrieve the user's subscription
        $subscription = $restaurant->owner->subscription;

        // Check if the user has a subscription and if it has a maximum scan limit
        if ($subscription && $subscription->max_scan_limit) {
            $maxScanLimit = $subscription->max_scan_limit;
        } else {
            // If the subscription or max scan limit is not set, use a default value
            $maxScanLimit = config('app.default_max_scan_limit');
        }

        $restaurant->max_scan_limit = $maxScanLimit; // Assign max scan limit

        // Generate QR code
        $restaurantUrl = route('menu', ['restaurant' => $restaurant->slug]);
        $qrCode = QrCode::format('png')->size(200)->generate($restaurantUrl);
        // Store QR code image in the storage and save the path in the database
        $qrCodePath = 'qr-codes/' . uniqid() . '.png';
        Storage::disk('public')->put($qrCodePath, $qrCode);
        $restaurant->qr_code_path = $qrCodePath;

        $restaurant->update(array_merge($validatedRequest, ['qr_code_path' => $qrCodePath]));

        // Handle file uploads for images
        if ($request->hasFile('image')) {
            $restaurant->clearMediaCollection('images');
            $restaurant->addMedia($request->file('image'))->toMediaCollection('images');
        }

        // Handle file uploads for videos
        if ($request->hasFile('video')) {
            $restaurant->clearMediaCollection('videos');
            $restaurant->addMedia($request->file('video'))->toMediaCollection('videos');
        }

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

        // // Debug: Check the retrieved restaurant
        // dd($restaurant);

        // Retrieve the owner of the restaurant
        $owner = $restaurant->owner;

        // Debug: Check the retrieved owner
        // dd($owner);

        // Construct the URL of the restaurant page
        $restaurantUrl = route('menu', $restaurant->slug);

        // Retrieve all menus associated with the restaurant
        $userMenus = $owner->menus;

        // Debug: Check the retrieved userMenus
        // dd($userMenus);

        $menuItems = collect();

        foreach ($userMenus as $menu) {
            $menuItems = $menuItems->merge($menu->menuItems);
        }

        return view('menu', compact('restaurant', 'owner', 'menuItems', 'restaurantUrl'));
    }



}