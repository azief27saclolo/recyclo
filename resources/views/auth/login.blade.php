<x-layout>
    
    <div class="flex justify-center items-center h-screen px-4">

        {{-- Session Messages --}}
        @if (session('status'))    
            <x-flashMsg msg="{{ session('status') }}" bg="bg-green-500" />
        @endif
        
        <form action="{{ route('login') }}" method="post">
            @csrf

            <div class="w-full max-w-sm p-6 shadow-lg bg-gray-100 rounded-md">

    
                <div class="flex justify-center items-center mb-4">
                    <img src="images/recyclo-logo.png" alt="Logo" class="max-w-full h-auto">
                </div>
    
                <hr class="mt-3">

                {{-- Email --}}
                <div class="mt-3">
                    <label for="email">Email:</label>
                    <input type="text" name="email" value="{{ old('email') }}" class="border w-full text-base px-2 py-2 focus:outline-none 
                    focus:ring-0 focus:border-gray-600 rounded-2xl @error('title') ring-red-500 @enderror" placeholder="Enter Username..."/>
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
                
                {{-- Remember Me --}}
                <div class="mb-4 mt-4 flex justify-between items-center">
                    <div>
                        <input type="checkbox" name="remember" id="remember">
                        <span for="remember">Remember Me</span>
                    </div>

                    <a class="text-blue-500" href="{{ 'forgot-password' }}">Forgot your password?</a>
                </div>

                @error('failed')
                    <p class="error">{{ $message }}</p>
                @enderror
    
                {{-- Login Button --}}
                <div class="mt-5">
                    <button type="submit" class="border-2 border-yellow-400 bg-yellow-400 py-2 w-full rounded-md">Log In</button> <!-- Increased padding for better touch targets -->
                </div>
    
                {{-- Log In With --}}
                <div class="flex justify-center items-center mt-3">
                    <label class="text-sm">or log in with</label>
                </div>
        
                <div class="flex justify-center items-center mt-2 space-x-4">
                    <a href="#link1" class="block">
                        <img src="images/apple-logo.png" alt="Apple Logo" class="h-8 w-8">
                    </a>
                    <a href="#link2" class="block">
                        <img src="images/google-logo.png" alt="Google Logo" class="h-8 w-8">
                    </a>
                    <a href="#link3" class="block">
                        <img src="images/facebook-logo.png" alt="Facebook Logo" class="h-8 w-8">
                    </a>
                </div>
    
            </div>
        </form>
    </div>

</x-layout>