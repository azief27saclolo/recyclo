<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    /**
     * Show the shop registration form
     */
    public function create()
    {
        // Check if the user already has an application
        $application = Shop::where('user_id', Auth::id())->first();
        return view('shops.register', compact('application'));
    }

    /**
     * Store the shop registration
     */
    public function store(Request $request)
    {
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'shop_address' => 'required|string',
            'valid_id' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        // Upload files
        $validIdPath = $request->file('valid_id')->store('shop_documents', 'public');

        // Create shop application
        Shop::create([
            'user_id' => Auth::id(),
            'shop_name' => $request->shop_name,
            'shop_address' => $request->shop_address,
            'valid_id_path' => $validIdPath,
            'status' => 'pending'
        ]);

        return redirect()->route('shop.register')->with('success', 'Your shop application has been submitted successfully.');
    }

    /**
     * Dashboard for approved sellers
     */
    public function dashboard()
    {
        // Check if the user has an approved shop
        $shop = Shop::where('user_id', Auth::id())
                    ->where('status', 'approved')
                    ->first();
        
        if (!$shop) {
            return redirect()->route('shop.register')
                ->with('error', 'You need an approved shop to access this page.');
        }
        
        return view('shops.dashboard', compact('shop'));
    }

    /**
     * Update shop details
     */
    public function update(Request $request)
    {
        $shop = Shop::where('user_id', Auth::id())
                    ->where('status', 'approved')
                    ->firstOrFail();
        
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'shop_address' => 'required|string',
            'shop_image' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
        ]);
        
        // Update shop details
        $shop->shop_name = $request->shop_name;
        $shop->shop_address = $request->shop_address;
        
        // Update shop image if provided
        if ($request->hasFile('shop_image')) {
            // Delete old image if exists
            if ($shop->image) {
                Storage::disk('public')->delete($shop->image);
            }
            
            // Upload new image
            $imagePath = $request->file('shop_image')->store('shop_images', 'public');
            $shop->image = $imagePath;
        }
        
        $shop->save();
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Shop settings updated successfully!'
            ]);
        }
        
        return redirect()->route('shop.dashboard')->with('success', 'Shop settings updated successfully!');
    }
}
