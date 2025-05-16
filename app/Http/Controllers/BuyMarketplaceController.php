<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buy;
use App\Models\BuyResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
                        ->paginate(15); // Changed from 12 to 15
                        
        return view('buy.marketplace', compact('buyRequests'));
    }

    /**
     * Store a seller's response to a buy request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function notifyBuyer(Request $request)
    {
        try {
            Log::info('Notify buyer request received', $request->all());
            
            // Validate inputs
            $validator = Validator::make($request->all(), [
                'request_id' => 'required|exists:buys,id',
                'message' => 'required|string|max:1000',
                'contact_method' => 'required|string|in:email,phone',
                'contact_email' => 'required_if:contact_method,email|email|nullable',
                'contact_phone' => 'required_if:contact_method,phone|string|nullable',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed: ' . $validator->errors()->first()
                ], 422);
            }
            
            // Make sure the user is authenticated
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You must be logged in to send notifications'
                ], 403);
            }

            // Get the buy request
            $buyRequest = Buy::findOrFail($request->request_id);

            // Check if user is trying to notify their own request
            if ($buyRequest->user_id === Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hey silly, you can\'t notify on your own request!'
                ], 403);
            }

            // Check if seller already responded to this request
            $existingResponse = BuyResponse::where('buy_id', $request->request_id)
                                          ->where('seller_id', Auth::id())
                                          ->first();

            if ($existingResponse) {
                // Update existing response
                $existingResponse->update([
                    'message' => $request->message,
                    'contact_method' => $request->contact_method,
                    'contact_email' => $request->contact_method === 'email' ? $request->contact_email : null,
                    'contact_phone' => $request->contact_method === 'phone' ? $request->contact_phone : null,
                    'status' => 'pending', // Reset to pending as it's a new message
                ]);
                
                Log::info('Response updated', ['response_id' => $existingResponse->id]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Your response has been updated successfully!'
                ]);
            }

            // Create a new response
            $response = BuyResponse::create([
                'buy_id' => $request->request_id,
                'seller_id' => Auth::id(),
                'message' => $request->message,
                'contact_method' => $request->contact_method,
                'contact_email' => $request->contact_method === 'email' ? $request->contact_email : null,
                'contact_phone' => $request->contact_method === 'phone' ? $request->contact_phone : null,
                'status' => 'pending',
            ]);
            
            Log::info('New response created', ['response_id' => $response->id]);

            return response()->json([
                'success' => true,
                'message' => 'Your response has been sent to the buyer!'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error sending buy notification: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error sending notification: ' . $e->getMessage()
            ], 500);
        }
    }
}
