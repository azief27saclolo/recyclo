<x-layout>
    <section class="section profile" id="profile" aria-label="profile">
        <div class="container">
            <h2 class="h2 section-title">Profile</h2>

            {{-- Basic Information --}}
            <div class="basic-info">
                <h3 class="h3 section-title">Basic Information</h3>
                <div class="profile-picture" style="width: 150px; height: 150px; border: 1px solid #ccc; display: flex; align-items: center; justify-content: center; border-radius: 10px;">
                    @if(auth()->user()->profile_picture)
                        <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile Picture" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">
                    @else
                        <ion-icon name="person" style="font-size: 100px; color: #ccc;"></ion-icon>
                    @endif
                </div>
                <p>Full Name: {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</p>
                <p>Username: {{ auth()->user()->username }}</p>
                <p>Location: {{ auth()->user()->location }}</p>
                <p>Member Since: {{ auth()->user()->created_at->format('d M Y') }}</p>
            </div>

            {{-- Edit Profile --}}
            <div class="edit-profile">
                <h3 class="h3 section-title">Edit Profile</h3>
                <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Profile Picture --}}
                    <div class="mb-4">
                        <label for="profile_picture" class="block text-gray-700 font-bold mb-2">Profile Picture</label>
                        <input type="file" name="profile_picture" class="border w-full text-base px-4 py-2 focus:outline-none 
                        focus:ring-2 focus:ring-blue-500 rounded-lg @error('profile_picture') ring-red-500 @enderror"/>
                        @error('profile_picture')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Username --}}
                    <div class="mb-4">
                        <label for="username" class="block text-gray-700 font-bold mb-2">Username</label>
                        <input type="text" name="username" value="{{ auth()->user()->username }}" class="border w-full text-base px-4 py-2 focus:outline-none 
                        focus:ring-2 focus:ring-blue-500 rounded-lg @error('username') ring-red-500 @enderror"/>
                        @error('username')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 font-bold mb-2">Password</label>
                        <input type="password" name="password" class="border w-full text-base px-4 py-2 focus:outline-none 
                        focus:ring-2 focus:ring-blue-500 rounded-lg @error('password') ring-red-500 @enderror"/>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Location --}}
                    <div class="mb-4">
                        <label for="location" class="block text-gray-700 font-bold mb-2">Location</label>
                        <input type="text" name="location" value="{{ auth()->user()->location }}" class="border w-full text-base px-4 py-2 focus:outline-none 
                        focus:ring-2 focus:ring-blue-500 rounded-lg @error('location') ring-red-500 @enderror"/>
                        @error('location')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 w-full">Update Profile</button>
                </form>
            </div>

            {{-- Activity Overview --}}
            <div class="activity-overview">
                <h3 class="h3 section-title">Activity Overview</h3>
                <p>Number of Listings: {{ auth()->user()->posts()->count() }}</p>
                <p>Overall Sold Items: {{ auth()->user()->soldOrders()->count() }}</p>
            </div>
        </div>
    </section>
</x-layout>
