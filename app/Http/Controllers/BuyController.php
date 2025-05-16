<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buy;
use App\Models\BuyResponse;
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
            'location' => 'required|string|max:255',
            'number' => 'required|string|max:20',
        ]);

        Buy::create([
            'user_id' => auth()->id(),
            'category' => $request->category,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'description' => $request->description,
            'location' => $request->location,
            'number' => $request->number,
        ]);

        // Get the previous URL (referrer)
        $previousUrl = url()->previous();
        
        // Check if request is AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Buy request created successfully.'
            ]);
        }

        // Redirect back to the same page the request came from
        return redirect()->back()->with('success', 'Buy request created successfully.');
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
        
        // Get all responses for the user's buy requests
        $responses = BuyResponse::whereIn('buy_id', $buyRequests->pluck('id'))
                              ->with('seller')
                              ->latest()
                              ->get();
                        
        return view('users.view_buy_requests', compact('buyRequests', 'responses'));
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
            'location' => 'required|string|max:255',
            'number' => 'required|string|max:20',
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
            'location' => $request->location,
            'number' => $request->number,
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
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to delete this buy request.'
                ], 403);
            }
            return redirect()->back()->with('error', 'You are not authorized to delete this buy request.');
        }

        $buyRequest->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Buy request deleted successfully.'
            ]);
        }

        return redirect()->route('buy.index')->with('success', 'Buy request deleted successfully.');
    }

    /**
     * Mark a seller response as read.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markResponseAsRead($id)
    {
        $response = BuyResponse::findOrFail($id);
        
        // Check if the user owns the associated buy request
        $buyRequest = Buy::findOrFail($response->buy_id);
        
        if ($buyRequest->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to manage this response.'
            ], 403);
        }
        
        $response->update(['status' => 'read']);
        
        return response()->json([
            'success' => true,
            'message' => 'Response marked as read'
        ]);
    }
}
