<x-layout>
    
    <div class="flex justify-center items-center h-screen px-4">
        
        <form action="{{ route('register') }}" method="post">
            @csrf

            <div class="w-full max-w-sm p-6 shadow-lg bg-gray-100 rounded-md"> <!-- Changed to max-w-md for better responsiveness -->

    
                <div class="flex justify-center items-center mb-4">
                    <img src="img/recyclo-logo.png" alt="Logo" class="max-w-full h-auto"> <!-- Added responsive image styles -->
                </div>
    
                <hr class="mt-3">
    
                {{-- First Name --}}
                <div class="mt-3">
                    <label for="firstname">First Name:</label>
                    <input type="text" name="firstname" value="{{ old('firstname') }}" class="border w-full text-base px-2 py-2 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-2xl" placeholder="Enter Username..."/>
                    @error('firstname')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
    
                {{-- Last Name --}}
                <div class="mt-3">
                    <label for="lastname">Last Name:</label>
                    <input type="text" name="lastname" value="{{ old('lastname') }}" class="border w-full text-base px-2 py-2 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-2xl" placeholder="Enter Username..."/>
                    @error('lastname')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Username --}}
                <div class="mt-3">
                    <label for="username">Username:</label>
                    <input type="text" name="username" value="{{ old('username') }}" class="border w-full text-base px-2 py-2 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-2xl" placeholder="Enter Username..."/>
                    @error('username')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mt-3">
                    <label for="email">Email:</label>
                    <input type="text" name="email" value="{{ old('email') }}" class="border w-full text-base px-2 py-2 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-2xl" placeholder="Enter Username..."/>
                    @error('email')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Phone Number --}}
                <div class="mt-5"> 
                    <label for="number">Phone Number:</label>
                    <div class="flex items-center">
                        <input type="text" name="number" value="{{ old('number') }}" class="border w-full text-base px-2 py-2 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-2xl pr-24" placeholder="Enter Tel no..."/>
                        <button type="button" class="bg-blue-500 text-white px-3 py-1 text-sm rounded-lg focus:outline-none hover:bg-blue-600 ml-2">Verify</button>
                    </div>
                    @error('number')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Password --}}
                <div class="mt-5"> 
                    <label for="password">Password:</label>
                    <input type="password" name="password" class="border w-full text-base px-2 py-2 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-2xl" placeholder="Enter Password..."/>
                    @error('password')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Confirm Password --}}
                <div class="mt-5"> 
                    <label for="passowrd_confirmation">Confirm Password:</label>
                    <input type="password" name="password_confirmation" class="border w-full text-base px-2 py-2 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-2xl" placeholder="Confirm Password..."/>
                </div>
                
                {{-- Accept Terms & Conditions --}}
                <div class="flex justify-center items-center mt-5">
                    <input type="checkbox" id="terms" class="mr-2">
                    <label for="terms" class="text-sm">Accept Terms & Conditions</label> <!-- Added 'for' attribute for accessibility -->
                </div>
    
                {{-- Sign Up Button --}}
                <div class="mt-5">
                    <button type="submit" class="border-2 border-yellow-400 bg-yellow-400 py-2 w-full rounded-md">Sign up</button> <!-- Increased padding for better touch targets -->
                </div>
    
                {{-- Sign Up With --}}
                <div class="flex justify-center items-center mt-3">
                    <label class="text-sm">or sign in with</label>
                </div>
        
                <div class="flex justify-center items-center mt-2 space-x-4">
                    <a href="#link1" class="block">
                        <img src="img/apple-logo.png" alt="Apple Logo" class="h-8 w-8">
                    </a>
                    <a href="#link2" class="block">
                        <img src="img/google-logo.png" alt="Google Logo" class="h-8 w-8">
                    </a>
                    <a href="#link3" class="block">
                        <img src="img/facebook-logo.png" alt="Facebook Logo" class="h-8 w-8">
                    </a>
                </div>
    
            </div>
        </form>
    </div>

</x-layout>