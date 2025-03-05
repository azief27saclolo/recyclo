<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buy;

class BuyController extends Controller
{
    public function create()
    {
        $buyRequests = Buy::where('user_id', auth()->id())->get();
        return view('users.buy', compact('buyRequests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'unit' => 'required|string|max:10',
            'description' => 'required|string|max:1000',
        ]);

        Buy::create([
            'user_id' => auth()->id(),
            'category' => $request->category,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'description' => $request->description,
        ]);

        return redirect()->route('buy.create')->with('success', 'Buy request created successfully.');
    }

    public function index()
    {
        $buyRequests = Buy::with('user')->get();
        return view('users.view_buy_requests', compact('buyRequests'));
    }
}
