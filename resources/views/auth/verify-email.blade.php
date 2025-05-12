@extends('components.layout')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 py-12 flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md">
        <!-- Card Container -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Header with Green Background -->
            <div class="relative bg-gradient-to-r from-[#517A5B] to-[#3c5c44] py-6 px-6 text-white">
                <div class="text-center">
                    <img src="{{ asset('images/recyclo-logo.png') }}" alt="Recyclo Logo" class="h-14 mx-auto mb-3">
                    <h1 class="text-xl font-bold mb-1">Email Verification</h1>
                    <p class="text-green-100 text-sm">One step closer to a greener future</p>
                </div>
            </div>
            
            <div class="p-6">
                <!-- Status Messages -->
                @if (session('message'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-3 mb-4 rounded-r-md" role="alert">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm">{{ session('message') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 mb-4 rounded-r-md" role="alert">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Main Content -->
                <div class="text-center text-gray-600 mb-5">
                    <div class="mb-4 bg-green-50 rounded-lg p-4 border border-green-100">
                        <svg class="w-12 h-12 text-[#517A5B] mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <p class="text-base font-medium text-gray-800">Check Your Email</p>
                        <p class="text-sm mt-1">We've sent a verification link to your email address</p>
                    </div>
                    
                    <p class="text-sm text-gray-700 leading-relaxed mb-4">
                        Thanks for signing up with Recyclo! Before getting started, please verify your email 
                        address by clicking on the link we just emailed to you.
                    </p>
                    
                    <div class="p-3 border border-gray-200 rounded-lg bg-gray-50 mb-4 text-left">
                        <div class="flex items-center mb-1">
                            <svg class="w-5 h-5 text-amber-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm font-medium text-gray-700">Verification link expires in 60 minutes</p>
                        </div>
                        <p class="text-xs text-gray-500 ml-7">
                            If you don't see the email, check your spam folder
                        </p>
                    </div>
                    
                    <!-- Resend Verification Text Link -->
                    <div class="text-center mb-4">
                        <p class="text-sm text-gray-600">
                            Didn't receive the email? 
                            <form action="{{ route('verification.send') }}" method="post" class="inline">
                                @csrf
                                <button type="submit" class="text-[#517A5B] font-medium hover:text-[#3a5941] underline">
                                    Click here to resend
                                </button>
                            </form>
                        </p>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <form action="{{ route('verification.send') }}" method="post">
                        @csrf
                        <button class="w-full bg-[#517A5B] hover:bg-[#3a5941] text-white font-medium py-2.5 px-4 rounded-md transition duration-300 flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Resend Verification
                        </button>
                    </form>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full bg-white hover:bg-gray-50 text-gray-700 font-medium py-2.5 px-4 rounded-md border border-gray-300 transition duration-300 flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Log Out
                        </button>
                    </form>
                </div>
                
                <!-- Help Link -->
                <div class="mt-4 text-center">
                    <a href="#" class="text-xs text-[#517A5B] hover:text-[#3a5941] underline transition duration-150">
                        Need help? Contact support
                    </a>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="bg-gray-50 py-3 px-6 text-center border-t border-gray-100">
                <p class="text-xs text-gray-500">
                    Recyclo — Together for a Greener Tomorrow
                </p>
            </div>
        </div>
    </div>
</div>
@endsection