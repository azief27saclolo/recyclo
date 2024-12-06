<x-layout>
    <h1 class="title">Request a password reset email</h1>

    {{-- Session Messages --}}
    @if (session('status'))    
        <x-flashMsg msg="{{ session('status') }}" bg="bg-green-500" />
    @endif
    
    <div class="flex justify-center items-center h-screen px-4">
        
        <form action="{{ route('password.request') }}" method="post" x-data="formSubmit" @submit.prevent="submit">
            @csrf

            <div class="w-full max-w-sm p-6 shadow-lg bg-gray-100 rounded-md"> <!-- Changed to max-w-md for better responsiveness -->

    
                <div class="flex justify-center items-center mb-4">
                    <img src="images/recyclo-logo.png" alt="Logo" class="max-w-full h-auto"> <!-- Added responsive image styles -->
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
    
                {{-- Login Button --}}
                <div class="mt-5">
                    <button x-ref="btn" type="submit" class="border-2 border-yellow-400 bg-yellow-400 py-2 w-full rounded-md">Submit</button> <!-- Increased padding for better touch targets -->
                </div>
    
            </div>
        </form>
    </div>

</x-layout>