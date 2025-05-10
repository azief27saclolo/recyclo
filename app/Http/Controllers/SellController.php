<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class SellController extends Controller
{
    /**
     * Display the sell item form.
     *
     * @return \Illuminate\View\View
     */
    public function showItemForm()
    {
        // Make sure the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        // Fetch active categories for the form
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        
        return view('sell.item', compact('categories'));
    }
}
