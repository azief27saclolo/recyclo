<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buy;

class BuyMarketplaceController extends Controller
{
    /**
     * Display a marketplace of buy requests from all users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all buy requests with their users, paginated
        $buyRequests = Buy::with('user')
                        ->latest()
                        ->paginate(12);
                        
        return view('buy.marketplace', compact('buyRequests'));
    }
}
