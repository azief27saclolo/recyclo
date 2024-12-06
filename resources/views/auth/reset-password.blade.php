<x-layout>

    <h1 class="title">Reset your password</h1>
    
    <div class="flex justify-center items-center h-screen px-4">
        
        <form action="{{ route('password.update') }}" method="post">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="w-full max-w-sm p-6 shadow-lg bg-gray-100 rounded-md"> <!-- Changed to max-w-md for better responsiveness -->

    
                <div class="flex justify-center items-center mb-4">
                    <img src="images/recyclo-logo.png" alt="Logo" class="max-w-full h-auto"> <!-- Added responsive image styles -->
                </div>
    
                <hr class="mt-3">

                {{-- Email --}}
                <div class="mt-3">
                    <label for="email">Email:</label>
                    <input type="text" name="email" value="{{ old('email') }}" class="border w-full text-base px-2 py-2 
                    focus:outline-none focus:ring-0 focus:border-gray-600 rounded-2xl @error('title') ring-red-500 @enderror" placeholder="Enter Username..."/>
                    @error('email')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                                
                {{-- Password --}}
                <div class="mt-5"> 
                    <label for="password">Password:</label>
                    <input type="password" name="password" class="border w-full text-base px-2 py-2 focus:outline-none focus:ring-0 
                    focus:border-gray-600 rounded-2xl @error('title') ring-red-500 @enderror" placeholder="Enter Password..."/>
                    @error('password')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Confirm Password --}}
                <div class="mt-5"> 
                    <label for="passowrd_confirmation">Confirm Password:</label>
                    <input type="password" name="password_confirmation" class="border w-full text-base px-2 py-2 focus:outline-none 
                    focus:ring-0 focus:border-gray-600 rounded-2xl @error('title') ring-red-500 @enderror" placeholder="Confirm Password..."/>
                </div>
    
                {{-- Sign Up Button --}}
                <div class="mt-5">
                    <button class="border-2 border-yellow-400 bg-yellow-400 py-2 w-full rounded-md">Reset Password</button>
                </div>
            </div>
        </form>
    </div>

</x-layout>