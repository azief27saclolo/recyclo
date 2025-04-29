<x-layout>
    <section class="bg-green-600 h-[60vh] flex items-center flex-col justify-center gap-5">
        <h1 class="text-3xl text-center text-white font-semibold">Your Trash Has Value – <br> Recycle and Earn!</h1>
        <p class="text-center text-white">Don’t let valuable waste go to waste! Join others turning their trash into cash by recycling responsibly today!</p>
        <a class="text-black font-semibold bg-green-400 py-3 px-5 rounded-sm" href="{{ route('login') }}">Recycle Now!</a>
    </section>

<<<<<<< Updated upstream
    <section class="h-full flex justify-center mt-5">
        <div class="flex justify-center">
            <div class="w-[395px] h-[450px] bg-white drop-shadow-xl rounded-md px-6 py-4">
                <h2 class="font-semibold text-xl mb-3">List yourself as a Buyer or Seller</h2>
                <div class="flex flex-col gap-4 items-start justify-center">
                    <p class="font-light ">Would you like the idea of selling trash online and make extra profits on the side?</p>
                    <p class="font-light ">The idea of reduce, reuse, recycle has been around for a long time, and it seems to be working.</p>
                    <p class="font-light ">Well, that is our main goal. We would like to make a change in the environment while helping individuals like you make extra income online from just selling waste.</p>
                    <p class="font-light ">Wastes like plastic, metal cans, and paper waste will do.</p>
                    <a class="text-black font-semibold bg-green-400 py-3 px-5 rounded-sm" href="{{ route('login') }}">Get Started</a>
                </div>
            </div>
        </div>

    </section>

    <section class="h-full mt-10 flex flex-col items-center gap-6 mb-6">
        <h1 class="text-2xl font-semibold">Kinds of Waste that we accept</h1>
        <div class="w-[395px] h-[230px] rounded-md border border-green-800 flex flex-col justify-center items-center gap-2">
            <img class="w-20" src="images/poly-bag_14523484.png" alt="plastic bag img">
            <h2 class="text-xl text-green-800 font-semibold">Plastic Waste</h2>
            <p class="text-sm text-center w-[350px] font-light">Plastics have been around us all the time. At your house, office, and school. It can be in a form of a straw, bag, bottles, and etc.</p>
        </div>

        <div class="w-[395px] h-[230px] rounded-md border border-green-800 flex flex-col justify-center items-center gap-2">
            <img class="w-20" src="images/metal_7263634.png" alt="plastic bag img">
            <h2 class="text-xl text-green-800 font-semibold">Metal Waste</h2>
            <p class="text-sm text-center w-[350px] font-light">Metal waste has a lot of recycling/reuse potential. It can easily save resources, reduces waste going to landfills, and many more.</p>
        </div>

        <div class="w-[395px] h-[230px] rounded-md border border-green-800 flex flex-col justify-center items-center gap-2">
            <img class="w-20" src="images/paper-recycle_6473463.png" alt="plastic bag img">
            <h2 class="text-xl text-green-800 font-semibold">Paper Waste</h2>
            <p class="text-sm text-center w-[350px] font-light">By just simply recycling paper waste, it can help to reduce greenhouse gas emissions that can contribute to climate change. Recycle now!</p>
        </div>

    </section>
    
    <h1 class="font-semibold text-xl ml-6 mb-6">Take us anywhere you go!</h1>
    
    <section class="bg-green-600 h-[50vh] flex flex-col items-start gap-5">
        <div class="flex flex-col gap-6 mt-10">
            <p class="text-white font-thin px-5">With Recyclo being a mobile web-app, you can easily take us anywhere you go!</p>
            <p class="text-white font-thin px-5">Going to work, office, business trip, school? No problem! Users can gain access to our marketplace with only 1 search away.</p>
        </div>
        <a class="text-black bg-green-400 py-3 px-5 rounded-sm m-5 font-semibold" href="{{ route('register') }}">Register Now</a>
    </section>
    
    {{-- <script>
        const navLinks = document.querySelector('.nav-links')
        function onToggleMenu(e){
            e.name = e.name === 'menu' ? 'close' : 'menu'
            navLinks.classList.toggle('top-[100%]')
            navLinks.classList.toggle('left-[0%]')
            navLinks.classList.toggle('w-[100%]')
        }
    </script> --}}
</x-layout>
=======
@section('content')
<div class="container">
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
    <!-- Profile Setup Notification Modal - Enhanced Design with Larger Fonts -->
    @auth
        @if(session('profile_incomplete'))
        <div id="profileSetupModal" class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto" style="display: none; backdrop-filter: blur(8px);">
            <div class="bg-white rounded-3xl shadow-2xl p-0 max-w-2xl w-full transform transition-all relative modal-container">
                <!-- Top accent bar -->
                <div class="h-5 bg-gradient-to-r from-green-500 to-green-600 rounded-t-3xl"></div>
                
                <!-- Close button -->
                <button id="closeProfileModal" class="absolute top-6 right-6 text-gray-400 hover:text-gray-600 transition-colors duration-200 focus:outline-none bg-gray-100 hover:bg-gray-200 rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
=======
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
    <!-- Profile Setup Notification Modal - Improved Design -->
    @auth
        @if(session('profile_incomplete'))
        <div id="profileSetupModal" class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto" style="display: none; backdrop-filter: blur(5px);">
            <div class="bg-white rounded-2xl shadow-2xl p-0 max-w-md w-full transform transition-all relative modal-container">
                <!-- Top accent bar -->
                <div class="h-2 bg-gradient-to-r from-green-500 to-green-600 rounded-t-2xl"></div>
                
                <!-- Close button -->
                <button id="closeProfileModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200 focus:outline-none bg-gray-100 hover:bg-gray-200 rounded-full p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
<<<<<<< Updated upstream
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </button>
                
                <!-- Content area -->
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
                <div class="px-12 pt-12 pb-10">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-36 h-36 rounded-full bg-green-50 mb-8 animate-pulse-slow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="#517A5B" class="bi bi-person-gear" viewBox="0 0 16 16">
                                <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m.256 7a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1zm3.63-4.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382l.045-.148zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0"/>
                            </svg>
                        </div>
                        <h3 class="text-4xl font-bold text-gray-800 mb-5">Complete Your Profile</h3>
                        <p class="text-xl text-gray-600 mb-8 leading-relaxed max-w-2xl mx-auto">
=======
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
                <div class="px-8 pt-8 pb-6">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-50 mb-6 animate-pulse-slow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#517A5B" class="bi bi-person-gear" viewBox="0 0 16 16">
                                <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m.256 7a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1zm3.63-4.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382l.045-.148zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Complete Your Profile</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">
<<<<<<< Updated upstream
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
                            Add your location and contact details to get the most out of Recyclo. This helps connect you with nearby opportunities and simplifies transactions.
                        </p>
                    </div>
                    
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
                    <div class="space-y-6 mb-10">
                        <div class="flex items-center p-7 bg-green-50 rounded-2xl transition-transform hover:translate-x-2 hover:shadow-lg">
                            <div class="flex-shrink-0 mr-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#517A5B" class="bi bi-geo-alt" viewBox="0 0 16 16">
=======
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
                    <div class="space-y-5 mb-8">
                        <div class="flex items-center p-4 bg-green-50 rounded-xl transition-transform hover:translate-x-1">
                            <div class="flex-shrink-0 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#517A5B" class="bi bi-geo-alt" viewBox="0 0 16 16">
<<<<<<< Updated upstream
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
                                    <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                                    <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                </svg>
                            </div>
                            <div>
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
                                <h4 class="font-semibold text-gray-800 text-2xl mb-2">Set Your Location</h4>
                                <p class="text-lg text-gray-600">Connect with local buyers and sellers easily in your area</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center p-7 bg-green-50 rounded-2xl transition-transform hover:translate-x-2 hover:shadow-lg">
                            <div class="flex-shrink-0 mr-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#517A5B" class="bi bi-telephone" viewBox="0 0 16 16">
=======
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
                                <h4 class="font-semibold text-gray-800">Set Your Location</h4>
                                <p class="text-sm text-gray-600">Connect with local buyers and sellers</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center p-4 bg-green-50 rounded-xl transition-transform hover:translate-x-1">
                            <div class="flex-shrink-0 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#517A5B" class="bi bi-telephone" viewBox="0 0 16 16">
<<<<<<< Updated upstream
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
                                    <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                                </svg>
                            </div>
                            <div>
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
                                <h4 class="font-semibold text-gray-800 text-2xl mb-2">Add Contact Number</h4>
                                <p class="text-lg text-gray-600">Enable faster communication for trades and transactions</p>
=======
                                <h4 class="font-semibold text-gray-800">Add Contact Number</h4>
                                <p class="text-sm text-gray-600">Enable faster communication for trades</p>
>>>>>>> Stashed changes
=======
                                <h4 class="font-semibold text-gray-800">Add Contact Number</h4>
                                <p class="text-sm text-gray-600">Enable faster communication for trades</p>
>>>>>>> Stashed changes
=======
                                <h4 class="font-semibold text-gray-800">Add Contact Number</h4>
                                <p class="text-sm text-gray-600">Enable faster communication for trades</p>
>>>>>>> Stashed changes
                            </div>
                        </div>
                    </div>
                    
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
                    <div class="flex gap-6 mb-6">
                        <button id="remindLaterBtn" class="flex-1 py-4 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-all duration-200 font-bold focus:outline-none focus:ring-2 focus:ring-gray-200 text-lg">
                            Remind Later
                        </button>
                        <a href="{{ route('profile') }}" class="flex-1 py-4 px-5 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-all duration-200 font-bold focus:outline-none focus:ring-2 focus:ring-green-500 text-center text-lg">
=======
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
                    <div class="flex gap-3">
                        <button id="remindLaterBtn" class="flex-1 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors duration-200 font-medium focus:outline-none focus:ring-2 focus:ring-gray-200">
                            Remind Later
                        </button>
                        <a href="{{ route('profile') }}" class="flex-1 py-3 px-4 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors duration-200 font-medium focus:outline-none focus:ring-2 focus:ring-green-500 text-center">
<<<<<<< Updated upstream
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
                            Complete Now
                        </a>
                    </div>
                    
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
                    <div class="text-base text-center text-gray-500 mt-6">
=======
                    <div class="text-xs text-center text-gray-500 mt-4">
>>>>>>> Stashed changes
=======
                    <div class="text-xs text-center text-gray-500 mt-4">
>>>>>>> Stashed changes
=======
                    <div class="text-xs text-center text-gray-500 mt-4">
>>>>>>> Stashed changes
                        This information helps improve your Recyclo experience
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endauth

    <article>
        <section class="section hero" id="home" aria-label="hero">
            <div class="container">
                <ul class="has-scrollbar">
                    <li class="scrollbar-item">
                        <div class="hero-card has-bg-image" style="background-image: url('images/sss.jpg')">
                            <div class="card-content">
                                <h1 class="h1 hero-title">
                                    Reduce, Reuse,<br>
                                    Recycle
                                </h1>
                                <p class="hero-text" style="color: black">
                                    Solid recyclable materials available for you! So what are you waiting for?
                                </p>
                                <p class="price" style="color: black;">Starting at ₱ 15.00</p>
                                <a href="{{ route('posts') }}" class="btn btn-primary">Shop Now</a>
                            </div>
                        </div>
                    </li>
                    <li class="scrollbar-item">
                        <div class="hero-card has-bg-image" style="background-image: url('images/mm.jpg')">
                            <div class="card-content">
                                <h1 class="h1 hero-title">
                                    Plastic? Metals? <br>
                                    Woods & more?
                                </h1>
                                <p class="hero-text" style="color: black">
                                    Recyclo has a lot to offer of different kinds of recyclable materials!
                                </p>
                                <p class="price">Starting at ₱ 15.00</p>
                                <a href="{{ route('posts') }}" class="btn btn-primary">Shop Now</a>
                            </div>
                        </div>
                    </li>
                    <li class="scrollbar-item">
                        <div class="hero-card has-bg-image" style="background-image: url('images/bboo.jpg')">
                            <div class="card-content">
                                <h1 class="h1 hero-title">
                                    Reveal The <br>
                                    Beauty of Skin
                                </h1>
                                <p class="hero-text" style="color: black">
                                    Made using clean, non-toxic ingredients, our products are designed for everyone.
                                </p>
                                <p class="price">Starting at ₱ 15.00</p>
                                <a href="{{ route('posts') }}" class="btn btn-primary">Shop Now</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
        <section class="section collection" id="collection" aria-label="collection">
            <div class="container">
                <ul class="collection-list">
                    <li>
                        <div class="collection-card has-before hover:shine">
                            <h2 class="h2 card-title">Recyclable Materials</h2>
                            <p class="card-text">All sorts of solid waste awaits!</p>
                            <a href="{{ route('posts') }}" class="btn-link">
                                <span class="span">Shop Now</span>
                                <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                            </a>
                            <div class="has-bg-image" style="background-image: url('images/bos.jpg')"></div>
                        </div>
                    </li>
                    <li>
                        <div class="collection-card has-before hover:shine">
                            <h2 class="h2 card-title">Thrash?</h2>
                            <p class="card-text">No. They are treasures!</p>
                            <a href="{{ route('posts') }}" class="btn-link">
                                <span class="span">Shop Now</span>
                                <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                            </a>
                            <div class="has-bg-image" style="background-image: url('images/plastic.jpg')"></div>
                        </div>
                    </li>
                    <li>
                        <div class="collection-card has-before hover:shine">
                            <h2 class="h2 card-title">Shop in Recyclo</h2>
                            <p class="card-text">Budget-friendly & Economic Growth</p>
                            <a href="{{ route('posts') }}" class="btn-link">
                                <span class="span">Shop Now</span>
                                <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                            </a>
                            <div class="has-bg-image" style="background-image: url('images/glass.jpg')"></div>
                        </div>
                    </li>
                </ul>
            </div>
        </section>

        {{-- User's Posts --}}
        <section class="section shop" id="shop" aria-label="shop">
            <div class="container">
                <div class="title-wrapper">
                    <h2 class="h2 section-title">Best Deals</h2>
                    <a href="{{ route('posts') }}" class="btn-link">
                        <span class="span">View More Products</span>
                        <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                    </a>
                </div>
                <ul class="has-scrollbar">
                    @foreach ($posts as $post)       
                        <li class="scrollbar-item">
                            <x-postCard :post="$post"/>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

        <section class="section shop" id="shop" aria-label="shop">
            <div class="container">
                <div class="title-wrapper">
                    <h2 class="h2 section-title">Shops For You</h2>
                    <a href="{{ route('shops') }}" class="btn-link">
                        <span class="span">View More Shops</span>
                        <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                    </a>
                </div>
                <ul class="has-scrollbar">
                    @forelse ($shops as $shop)
                    <li class="scrollbar-item">
                        <div class="shop-card">
                            <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                                @if($shop->image)
                                <img src="{{ asset('storage/' . $shop->image) }}" width="540" height="720" loading="lazy" alt="{{ $shop->shop_name }}" class="img-cover">
                                @elseif($shop->user && $shop->user->profile_picture)
                                <img src="{{ asset('storage/' . $shop->user->profile_picture) }}" width="540" height="720" loading="lazy" alt="{{ $shop->shop_name }}" class="img-cover">
                                @else
                                <img src="{{ asset('images/f' . ($loop->iteration % 6 + 1) . '.jpg') }}" width="540" height="720" loading="lazy" alt="{{ $shop->shop_name }}" class="img-cover">
                                @endif
                                <div class="card-actions">
                                    <a href="{{ route('shops.show', $shop->user_id) }}" class="action-btn" aria-label="view shop">
                                        <ion-icon name="bag-handle-outline" aria-hidden="true"></ion-icon>
                                    </a>
                                    <button class="action-btn" aria-label="favorite shop">
                                        <ion-icon name="heart-outline" aria-hidden="true"></ion-icon>
                                    </button>
                                    <button class="action-btn" aria-label="contact shop">
                                        <ion-icon name="chatbubble-outline" aria-hidden="true"></ion-icon>
                                    </button>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="price">
                                    <span class="span">{{ $shop->shop_name }}</span>
                                </div>
                                <h3>
                                    <a href="{{ route('shops.show', $shop->user_id) }}" class="card-title">
                                        @if($shop->user && $shop->user->profile_picture)
                                        <img src="{{ asset('storage/' . $shop->user->profile_picture) }}" alt="Profile" class="shop-profile-pic" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 8px; vertical-align: middle;">
                                        @endif
                                        {{ $shop->user->username ?? 'Shop' }}'s Shop
                                    </a>
                                </h3>
                                <div class="card-rating">
                                    <div class="rating-wrapper" aria-label="5 start rating">
                                        <ion-icon name="star" aria-hidden="true"></ion-icon>
                                        <ion-icon name="star" aria-hidden="true"></ion-icon>
                                        <ion-icon name="star" aria-hidden="true"></ion-icon>
                                        <ion-icon name="star" aria-hidden="true"></ion-icon>
                                        <ion-icon name="star" aria-hidden="true"></ion-icon>
                                    </div>
                                    <p class="rating-text">{{ random_int(10, 500) }} reviews</p>
                                </div>
                            </div>
                        </div>
                    </li>
                    @empty
                        @for ($i = 1; $i <= 6; $i++)
                        <li class="scrollbar-item">
                            <div class="shop-card">
                                <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                                    <img src="images/f{{ $i }}.jpg" width="540" height="720" loading="lazy" alt="Shop Image" class="img-cover">
                                    <div class="card-actions">
                                        <button class="action-btn" aria-label="add to cart">
                                            <ion-icon name="bag-handle-outline" aria-hidden="true"></ion-icon>
                                        </button>
                                        <button class="action-btn" aria-label="add to whishlist">
                                            <ion-icon name="heart-outline" aria-hidden="true"></ion-icon>
                                        </button>
                                        <button class="action-btn" aria-label="compare">
                                            <ion-icon name="repeat-outline" aria-hidden="true"></ion-icon>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="price">
                                        <span class="span">Sample Shop {{ $i }}</span>
                                    </div>
                                    <h3>
                                        <a href="#" class="card-title">Sample Shop {{ $i }}</a>
                                    </h3>
                                    <div class="card-rating">
                                        <div class="rating-wrapper" aria-label="5 start rating">
                                            <ion-icon name="star" aria-hidden="true"></ion-icon>
                                            <ion-icon name="star" aria-hidden="true"></ion-icon>
                                            <ion-icon name="star" aria-hidden="true"></ion-icon>
                                            <ion-icon name="star" aria-hidden="true"></ion-icon>
                                            <ion-icon name="star" aria-hidden="true"></ion-icon>
                                        </div>
                                        <p class="rating-text">{{ random_int(10, 500) }} reviews</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endfor
                    @endforelse
                </ul>
            </div>
        </section>

        <section class="section banner" aria-label="banner">
            <div class="container">
                <ul class="banner-list">
                    <li>
                        <div class="banner-card banner-card-1 has-before hover:shine">
                            <p class="card-subtitle" style="color: whitesmoke;">Make an Order in Recyclo</p>
                            <h2 class="h2 card-title" style="color: whitesmoke;">Budget-Friendly Prices!</h2>
                            <a href="#" class="btn btn-secondary">Order Now</a>
                            <div class="has-bg-image" style="background-image: url('images/rec.jpg')"></div>
                        </div>
                    </li>
                    <li>
                        <div class="banner-card banner-card-2 has-before hover:shine">
                            <h2 class="h2 card-title" style="color: green;">Recyclo</h2>
                            <p class="card-text">
                                In Recyclo, We practice proper and innovative ways to use recyclable materials.
                            </p>
                            <a href="#" class="btn btn-secondary">Shop Sale</a>
                            <div class="has-bg-image" style="background-image: url('images/bag.jpg')"></div>
                        </div>
                    </li>
                </ul>
            </div>
        </section>

        <section class="section feature" aria-label="feature">
            <div class="container">
                <h2 class="h2-large section-title">Why Use Recyclo?</h2>
                <ul class="flex-list">
                    <li class="flex-item">
                        <div class="feature-card">
                            <img src="images/c1.png" width="204" height="236" loading="lazy" alt="Guaranteed PURE" class="card-icon">
                            <h3 class="h3 card-title">100% Recyclable Materials</h3>
                            <p class="card-text">
                                Throwaway materials can be much more and can be use in many different ways.
                            </p>
                        </div>
                    </li>
                    <li class="flex-item">
                        <div class="feature-card">
                            <img src="images/c2.png" width="204" height="236" loading="lazy" alt="Completely Cruelty-Free" class="card-icon">
                            <h3 class="h3 card-title">Pollution-Free</h3>
                            <p class="card-text">
                                We care not only for our users but for the entire world. Hence, we support a greener planet!
                            </p>
                        </div>
                    </li>
                    <li class="flex-item">
                        <div class="feature-card">
                            <img src="images/c3.png" width="204" height="236" loading="lazy" alt="Ingredient Sourcing" class="card-icon">
                            <h3 class="h3 card-title">Innovation</h3>
                            <p class="card-text">
                                An innovation lies hidden among these scraps.
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
        <section class="section offer" id="offer" aria-label="offer">
            <div class="container">
                <figure class="offer-banner">
                    <img src="images/r2.jpg" width="305" height="408" loading="lazy" alt="offer products" class="w-100">
                    <img src="images/r1.jpg" width="450" height="625" loading="lazy" alt="offer products" class="w-100">
                </figure>
                <div class="offer-content">
                    <p class="offer-subtitle">
                        <span class="span">Budget-Friendly Prices</span>
                        <span class="badge" aria-label="20% off">Plastic</span>
                        <span class="badge" aria-label="20% off">Wood</span>
                        <span class="badge" aria-label="20% off">Metals</span>
                        <span class="badge" aria-label="20% off">More!</span>
                    </p>
                    <h2 class="h2-large section-title">Products That Are Made Out Ff Solid Waste</h2>
                    <p class="section-text" style="color: black;">
                        Here are some examples of products that are recycled up using recyclable materials.
                    </p>
                    <div class="countdown">
                        <span class="time" aria-label="days">Reduce</span>
                        <span class="time" aria-label="hours">Reuse</span>
                        <span class="time" aria-label="minutes">Recycle</span>
                    </div>
                    <a href="#" class="btn btn-primary">Shop Now In Recyclo</a>
                </div>
            </div>
        </section>
        <section class="section blog" id="blog" aria-label="blog">
            <div class="container">
                <h2 class="h2-large section-title">More about <span><img src="images/mainlogo.png" alt="logo" style="width: 50px; height: 50px; margin-left: 600px;"></span></h2>
                <ul class="flex-list">
                    <li class="flex-item">
                        <div class="blog-card">
                            <figure class="card-banner img-holder has-before hover:shine" style="--width: 700; --height: 450;">
                                <img src="images/m1.jpg" width="700" height="450" loading="lazy" alt="Find a Store" class="img-cover">
                            </figure>
                            <h3 class="h3">
                                <a href="#" class="card-title">Our Mission</a>
                            </h3>
                            <a href="#" class="btn-link">
                                <span class="span">View</span>
                                <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
                            </a>
                        </div>
                    </li>
                    <li class="flex-item">
                        <div class="blog-card">
                            <figure class="card-banner img-holder has-before hover:shine" style="--width: 700; --height: 450;">
                                <img src="images/m2.jpg" width="700" height="450" loading="lazy" alt="From Our Blog" class="img-cover">
                            </figure>
                            <h3 class="h3">
                                <a href="#" class="card-title">Our Goals</a>
                            </h3>
                            <a href="#" class="btn-link">
                                <span class="span">View</span>
                                <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
                            </a>
                        </div>
                    </li>
                    <li class="flex-item">
                        <div class="blog-card">
                            <figure class="card-banner img-holder has-before hover:shine" style="--width: 700; --height: 450;">
                                <img src="images/blog-3.jpg" width="700" height="450" loading="lazy" alt="Our Story" class="img-cover">
                            </figure>
                            <h3 class="h3">
                                <a href="#" class="card-title">Our Vision</a>
                            </h3>
                            <a href="#" class="btn-link">
                                <span class="span">View</span>
                                <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
    </article>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
    // Profile setup notification - Enhanced animation
=======
    // Profile setup notification - Improved animation
>>>>>>> Stashed changes
=======
    // Profile setup notification - Improved animation
>>>>>>> Stashed changes
=======
    // Profile setup notification - Improved animation
>>>>>>> Stashed changes
    const profileModal = document.getElementById('profileSetupModal');
    if (profileModal) {
        // Show modal with staggered animation after page loads
        setTimeout(function() {
            profileModal.style.display = 'flex';
            // First fade in the backdrop
            profileModal.classList.add('modal-backdrop-visible');
            
            // Then animate in the modal content
            setTimeout(() => {
                const modalContainer = profileModal.querySelector('.modal-container');
                modalContainer.classList.add('modal-content-visible');
            }, 300);
        }, 1500); // Slightly longer delay for better UX
        
        // Close button event with animation
        document.getElementById('closeProfileModal').addEventListener('click', function() {
            closeProfileModalWithAnimation();
        });
        
        // Remind later button with animation
        document.getElementById('remindLaterBtn').addEventListener('click', function() {
            closeProfileModalWithAnimation();
            
            // Set a longer cookie to remember the user's choice
            document.cookie = "profile_reminder_dismissed=true; max-age=86400; path=/"; // 24 hours
        });
        
        // Function to close modal with animation
        function closeProfileModalWithAnimation() {
            const modalContainer = profileModal.querySelector('.modal-container');
            modalContainer.classList.remove('modal-content-visible');
            modalContainer.classList.add('modal-content-hidden');
            
            // First hide the modal content
            setTimeout(() => {
                // Then fade out the backdrop
                profileModal.classList.remove('modal-backdrop-visible');
                profileModal.classList.add('modal-backdrop-hidden');
                
                // Finally completely hide the modal
                setTimeout(() => {
                    profileModal.style.display = 'none';
                }, 300);
            }, 200);
        }
        
        // Close modal when clicking outside
        profileModal.addEventListener('click', function(e) {
            if (e.target === profileModal) {
                closeProfileModalWithAnimation();
            }
        });
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && profileModal.style.display === 'flex') {
                closeProfileModalWithAnimation();
            }
        });
    }
});
</script>

<style>
/* Enhanced animations and styling for the modal */
.modal-container {
    opacity: 0;
    transform: scale(0.95) translateY(-10px);
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
    transition: all 0.5s cubic-bezier(0.19, 1, 0.22, 1);
    max-width: 700px; /* Wider modal for better text display */
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
=======
    transition: all 0.4s cubic-bezier(0.19, 1, 0.22, 1);
>>>>>>> Stashed changes
=======
    transition: all 0.4s cubic-bezier(0.19, 1, 0.22, 1);
>>>>>>> Stashed changes
=======
    transition: all 0.4s cubic-bezier(0.19, 1, 0.22, 1);
>>>>>>> Stashed changes
}

.modal-content-visible {
    opacity: 1 !important;
    transform: scale(1) translateY(0) !important;
}

.modal-content-hidden {
    opacity: 0 !important;
    transform: scale(0.95) translateY(10px) !important;
}

.modal-backdrop-visible {
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
    background-color: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(8px);
    transition: all 0.4s ease-out;
=======
    background-color: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
    transition: all 0.3s ease-out;
>>>>>>> Stashed changes
=======
    background-color: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
    transition: all 0.3s ease-out;
>>>>>>> Stashed changes
=======
    background-color: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
    transition: all 0.3s ease-out;
>>>>>>> Stashed changes
}

.modal-backdrop-hidden {
    background-color: rgba(0, 0, 0, 0);
    backdrop-filter: blur(0px);
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
    transition: all 0.4s ease-in;
=======
    transition: all 0.3s ease-in;
>>>>>>> Stashed changes
=======
    transition: all 0.3s ease-in;
>>>>>>> Stashed changes
=======
    transition: all 0.3s ease-in;
>>>>>>> Stashed changes
}

/* Animation for the icon */
.animate-pulse-slow {
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
    animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
=======
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
>>>>>>> Stashed changes
=======
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
>>>>>>> Stashed changes
=======
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
>>>>>>> Stashed changes
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
        transform: scale(1);
    }
    50% {
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
        opacity: 0.85;
        transform: scale(1.08);
    }
}

/* Responsive adjustments for larger fonts */
@media (max-width: 768px) {
    .modal-container {
        width: 95% !important;
        max-width: 95% !important;
        margin: 0 auto;
    }
    
    #profileSetupModal h3 {
        font-size: 2.5rem;
    }
    
    #profileSetupModal h4 {
        font-size: 1.75rem;
    }
    
    #profileSetupModal p {
        font-size: 1.25rem;
    }
    
    #profileSetupModal button,
    #profileSetupModal a.flex-1 {
        font-size: 1.25rem;
        padding-top: 1rem;
        padding-bottom: 1rem;
    }
}

/* Enhanced modal styling with larger elements */
#profileSetupModal .bg-green-50 {
    background-color: rgba(81, 122, 91, 0.08);
=======
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
        opacity: 0.8;
        transform: scale(1.05);
    }
}

/* Responsive adjustments */
@media (max-width: 640px) {
    .modal-container {
        width: 90% !important;
        margin: 0 auto;
    }
    
    .flex {
        flex-direction: column;
    }
    
    .space-y-5 > div {
        padding: 12px !important;
    }
}

/* Make buttons match the site's color scheme */
#profileSetupModal .bg-green-50 {
    background-color: rgba(81, 122, 91, 0.1);
<<<<<<< Updated upstream
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
}

#profileSetupModal .bg-green-600 {
    background-color: #517A5B;
}

<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
=======
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
#profileSetupModal .bg-green-700:hover {
    background-color: #3c5c44;
}

<<<<<<< Updated upstream
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
#profileSetupModal .hover\:bg-green-700:hover {
    background-color: #3c5c44;
}

#profileSetupModal .focus\:ring-green-500:focus {
    --tw-ring-color: rgba(81, 122, 91, 0.5);
}

<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
/* Enhanced hover effects with larger transform */
#profileSetupModal .hover\:shadow-lg:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

/* Button styling enhancements */
#profileSetupModal button,
#profileSetupModal a.flex-1 {
    font-weight: 700;
    letter-spacing: 0.01em;
    transition: all 0.3s ease;
}

#profileSetupModal button:hover,
#profileSetupModal a.flex-1:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
}

/* Additional enhancements for text */
#profileSetupModal {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
}

#profileSetupModal h3, 
#profileSetupModal h4 {
    letter-spacing: -0.01em;
    color: #517A5B;
}
</style>
@endsection
>>>>>>> Stashed changes
=======
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
#profileSetupModal h3 {
    color: #517A5B;
}

#profileSetupModal .from-green-500 {
    --tw-gradient-from: #517A5B;
}

#profileSetupModal .to-green-600 {
    --tw-gradient-to: #3c5c44;
}
</style>
<<<<<<< Updated upstream
<<<<<<< Updated upstream
@endsection
>>>>>>> Stashed changes
=======
@endsection
>>>>>>> Stashed changes
=======
@endsection
>>>>>>> Stashed changes
