@extends('components.layout')

@section('content')
<div class="container mx-auto px-4 py-16">
    <div class="max-w-lg mx-auto bg-white rounded-lg shadow-lg p-8">
        <div class="text-center">
            <img src="{{ asset('images/recyclo-logo.png') }}" alt="Recyclo Logo" class="h-20 mx-auto mb-6">
            <h2 class="text-2xl font-bold text-green-700 mb-4">Verify Your Email Address</h2>
            
            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                <p class="text-green-800 text-lg mb-2">📧 Check your inbox!</p>
                <p class="text-gray-600">
                    We've sent a verification link to <strong>{{ Auth::user()->email }}</strong>
                </p>
            </div>
            
            @if (session('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('message') }}
                </div>
            @endif
            
            <p class="text-gray-600 mb-6">
                Please check your email and click the verification link to complete your registration. 
                If you don't see the email, check your spam folder.
            </p>
            
            <div class="flex flex-col space-y-4">
                <form method="POST" action="{{ route('verification.send') }}" class="mb-2">
                    @csrf
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:shadow-outline transition duration-300">
                        Resend Verification Email
                    </button>
                </form>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full border border-gray-300 text-gray-600 hover:bg-gray-50 font-medium py-2 px-6 rounded-lg transition duration-300">
                        Cancel and Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection