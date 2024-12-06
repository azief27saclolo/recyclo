<x-layout>
    
    <div class=" flex justify-center items-center h-screen px-4 bg-gray-50">
        <form action="{{ route('register') }}" method="post" x-data="formSubmit" @submit.prevent="submit" class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
            @csrf

            <!-- Logo -->
            <div class="flex justify-center items-center mb-6">
                <img src="images/recyclo-logo.png" alt="Logo" class="h-16 w-auto">
            </div>

            <hr class="mb-6">

            <!-- First Name -->
            <div class="mb-4">
                <label for="firstname" class="block text-gray-700 text-sm font-medium">First Name</label>
                <input type="text" name="firstname" value="{{ old('firstname') }}" 
                    class="border w-full px-3 py-2 mt-1 rounded-lg shadow-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('title') border-red-500 @enderror" 
                    placeholder="Enter your first name">
                @error('firstname')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Last Name -->
            <div class="mb-4">
                <label for="lastname" class="block text-gray-700 text-sm font-medium">Last Name</label>
                <input type="text" name="lastname" value="{{ old('lastname') }}" 
                    class="border w-full px-3 py-2 mt-1 rounded-lg shadow-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('title') border-red-500 @enderror" 
                    placeholder="Enter your last name">
                @error('lastname')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Username -->
            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-medium">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" 
                    class="border w-full px-3 py-2 mt-1 rounded-lg shadow-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('title') border-red-500 @enderror" 
                    placeholder="Enter your username">
                @error('username')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                    class="border w-full px-3 py-2 mt-1 rounded-lg shadow-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('title') border-red-500 @enderror" 
                    placeholder="Enter your email">
                @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone Number -->
            <div class="mb-4">
                <label for="number" class="block text-gray-700 text-sm font-medium">Phone Number</label>
                <div class="flex">
                    <input type="text" name="number" value="{{ old('number') }}" 
                        class="border w-full px-3 py-2 rounded-l-lg shadow-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('title') border-red-500 @enderror" 
                        placeholder="Enter your phone number">
                    <button type="button" class="bg-blue-500 text-white px-3 py-2 text-sm rounded-r-lg hover:bg-blue-600">Verify</button>
                </div>
                @error('number')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-medium">Password</label>
                <input type="password" name="password" 
                    class="border w-full px-3 py-2 mt-1 rounded-lg shadow-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('title') border-red-500 @enderror" 
                    placeholder="Enter your password">
                @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 text-sm font-medium">Confirm Password</label>
                <input type="password" name="password_confirmation" 
                    class="border w-full px-3 py-2 mt-1 rounded-lg shadow-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-yellow-400" 
                    placeholder="Confirm your password">
            </div>

            <!-- Terms & Conditions -->
            <div class="flex items-center mb-6">
                <input type="checkbox" id="terms" class="w-4 h-4 text-yellow-400 focus:ring-yellow-400 border-gray-300 rounded">
                <label for="terms" class="ml-2 text-sm text-gray-600">I accept the <a href="#" class="text-blue-500 hover:underline">terms and conditions</a></label>
            </div>

            <!-- Sign Up Button -->
            <button type="submit" class="bg-yellow-400 text-white w-full py-2 rounded-lg shadow hover:bg-yellow-500 transition">
                Sign Up
            </button>

            <!-- Social Media Login -->
            <div class="text-center mt-4">
                <p class="text-sm text-gray-600">Or sign up with</p>
                <div class="flex justify-center space-x-4 mt-3">
                    <a href="#" class="hover:opacity-80">
                        <img src="images/apple-logo.png" alt="Apple Logo" class="h-8 w-8">
                    </a>
                    <a href="#" class="hover:opacity-80">
                        <img src="images/google-logo.png" alt="Google Logo" class="h-8 w-8">
                    </a>
                    <a href="#" class="hover:opacity-80">
                        <img src="images/facebook-logo.png" alt="Facebook Logo" class="h-8 w-8">
                    </a>
                </div>
            </div>
        </form>
    </div>

</x-layout>