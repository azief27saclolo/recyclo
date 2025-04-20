<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        
        return view('sell.item');
    }
}
