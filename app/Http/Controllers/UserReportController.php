<?php

namespace App\Http\Controllers;

use App\Models\UserReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserReportController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'reported_id' => 'required|exists:users,id',
                'order_id' => 'nullable|exists:orders,id',
                'reason' => 'required|string|max:255',
                'description' => 'required|string|min:10'
            ], [
                'reported_id.required' => 'The reported user ID is required.',
                'reported_id.exists' => 'The reported user does not exist.',
                'order_id.exists' => 'The order does not exist.',
                'reason.required' => 'Please select a reason for the report.',
                'reason.max' => 'The reason cannot exceed 255 characters.',
                'description.required' => 'Please provide a description of the issue.',
                'description.min' => 'The description must be at least 10 characters long.'
            ]);

            // Check if user has already reported this user for this order
            $existingReport = UserReport::where('reporter_id', Auth::id())
                ->where('reported_id', $request->reported_id)
                ->where('order_id', $request->order_id)
                ->first();

            if ($existingReport) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You have already reported this user for this order.'
                    ], 422);
                }
                return back()->with('error', 'You have already reported this user for this order.');
            }

            // Create the report
            $report = UserReport::create([
                'reporter_id' => Auth::id(),
                'reported_id' => $validated['reported_id'],
                'order_id' => $validated['order_id'],
                'reason' => $validated['reason'],
                'description' => $validated['description'],
                'status' => 'pending'
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Report submitted successfully.',
                    'report' => $report
                ]);
            }

            return back()->with('success', 'Report submitted successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'reports should be at least 10 characters long',
                    'errors' => $e->errors()
                ], 422);
            }
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating report', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while submitting the report. Please try again.'
                ], 500);
            }

            return back()->with('error', 'An error occurred while submitting the report. Please try again.');
        }
    }
} 