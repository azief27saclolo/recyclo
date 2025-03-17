<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buy;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Display a listing of the user's buy requests.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Filter buy requests to show only those from the authenticated user
        $buyRequests = Buy::where('user_id', Auth::id())
                        ->latest()
                        ->get();
                        
        return view('users.view_buy_requests', compact('buyRequests'));
    }

    /**
     * Search for buy requests.
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Search for buy requests
        $buyRequests = Buy::where('category', 'LIKE', "%{$query}%")
                          ->orWhere('description', 'LIKE', "%{$query}%")
                          ->paginate(10);

        return view('posts.search', [
            'buyRequests' => $buyRequests,
            'query' => $query
        ]);
    }

    /**
     * Update the specified buy request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'unit' => 'required|string|max:10',
            'description' => 'required|string|max:1000',
        ]);

        $buyRequest = Buy::findOrFail($id);
        
        // Check if the user is authorized to update this request
        if ($buyRequest->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to edit this buy request.');
        }

        $buyRequest->update([
            'category' => $request->category,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'description' => $request->description,
        ]);

        return redirect()->route('buy.index')->with('success', 'Buy request updated successfully.');
    }

    /**
     * Remove the specified buy request.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $buyRequest = Buy::findOrFail($id);
        
        // Check if the user is authorized to delete this request
        if ($buyRequest->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to delete this buy request.');
        }

        $buyRequest->delete();

        return redirect()->route('buy.index')->with('success', 'Buy request deleted successfully.');
    }
}
