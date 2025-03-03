@extends('components.layout')

@section('content')
<div class="container">
    
    <div class="flex justify-center items-center h-screen px-4 bg-gray-50">
        {{-- Session Messages --}}
        @if (session('status'))
            <x-flashMsg msg="{{ session('status') }}" bg="bg-green-500" />
        @endif

        <form action="{{ route('login') }}" method="post" class=" w-full max-w-md p-6 bg-white shadow-xl rounded-lg">
            @csrf

            {{-- Logo --}}
            <div class="flex justify-center mb-6">
                <img src="images/recyclo-logo.png" alt="Logo" class="h-16">
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full mt-1 p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-400 focus:border-yellow-400 @error('email') border-red-500 @enderror"
                    placeholder="Enter your email"
                />
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
                <input
                    type="password"
                    name="password"
                    class="w-full mt-1 p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-400 focus:border-yellow-400 @error('password') border-red-500 @enderror"
                    placeholder="Enter your password"
                />
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember Me & Forgot Password --}}
            <div class="flex justify-between items-center mb-4">
                <label class="flex items-center text-sm">
                    <input
                        type="checkbox"
                        name="remember"
                        id="remember"
                        class="h-4 w-4 text-yellow-400 focus:ring-yellow-400 border-gray-300 rounded"
                    />
                    <span class="ml-2">Remember Me</span>
                </label>
                <a href="{{ 'forgot-password' }}" class="text-sm text-yellow-400 hover:underline">Forgot your password?</a>
            </div>

            {{-- Login Button --}}
            <div>
                <button
                    class="w-full py-3 bg-yellow-400 text-white font-semibold rounded-md shadow-md hover:bg-yellow-500 transition">
                    Log In
                </button>
            </div>

            {{-- Divider --}}
            <div class="flex items-center mt-6">
                <div class="flex-grow h-px bg-gray-300"></div>
                <span class="px-4 text-sm text-gray-500">or log in with</span>
                <div class="flex-grow h-px bg-gray-300"></div>
            </div>

            {{-- Social Login --}}
            <div class="flex justify-center space-x-6 mt-4">
                <a href="#link1" class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center shadow hover:shadow-lg">
                    <img src="images/apple-logo.png" alt="Apple Logo" class="h-6">
                </a>
                <a href="#link2" class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center shadow hover:shadow-lg">
                    <img src="images/google-logo.png" alt="Google Logo" class="h-6">
                </a>
                <a href="#link3" class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center shadow hover:shadow-lg">
                    <img src="images/facebook-logo.png" alt="Facebook Logo" class="h-6">
                </a>
            </div>
        </form>
    </div>

</div>
@endsection