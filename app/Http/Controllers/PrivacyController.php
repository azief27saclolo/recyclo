<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrivacySetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class PrivacyController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $settings = PrivacySetting::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'public_profile' => true,
                'show_email' => true,
                'show_location' => true,
                'email_notifications' => true,
                'order_notifications' => true,
                'marketing_emails' => false,
                'show_activity' => true,
                'search_visibility' => true,
            ]
        );

        return view('privacy.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = PrivacySetting::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'public_profile' => true,
                'show_email' => true,
                'show_location' => true,
                'email_notifications' => true,
                'order_notifications' => true,
                'marketing_emails' => false,
                'show_activity' => true,
                'search_visibility' => true,
            ]
        );

        $settings->update([
            'public_profile' => $request->has('public_profile'),
            'show_email' => $request->has('show_email'),
            'show_location' => $request->has('show_location'),
            'email_notifications' => $request->has('email_notifications'),
            'order_notifications' => $request->has('order_notifications'),
            'marketing_emails' => $request->has('marketing_emails'),
            'show_activity' => $request->has('show_activity'),
            'search_visibility' => $request->has('search_visibility'),
        ]);

        return redirect()->route('privacy.settings')->with('success', 'Privacy settings updated successfully.');
    }
} 