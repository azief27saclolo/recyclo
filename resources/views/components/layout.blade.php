<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-roboto">
    <header class="bg-white sticky top-[0%] z-10 drop-shadow-md mt-3">
        <nav class="flex items-center justify-between w-[92%] m-auto">
            <div>
                <img class="w-32" src="../src/img/logo1.png" alt="logo">
            </div>
            <div class="nav-links absolute top-0">
                <ul class="flex flex-col gap-[4vw] bg-white pb-6">
                    @auth
                        <li><a class="hover:text-green-200 ml-3" href="{{ route('posts') }}">Home</a></li>
                    @endauth
                    @guest
                        <li><a class="hover:text-green-200 ml-3" href="{{ route('landingpage') }}">Home</a></li>
                    @endguest
                    
                    <li>
                        @guest
                            <a class="text-black bg-green-400 py-3 px-5 rounded-sm ml-3" href="{{ route('register') }}">Sign up</a>
                            <a class="text-black bg-green-400 py-3 px-5 rounded-sm ml-3" href="{{ route('login') }}">Login</a>                          
                        @endguest
                    </li>
                </ul>
            </div>

            <div class="relative grid place-items-center" x-data="{ open: false }">
                
                {{-- Dropdown Menu Button--}}
                <button @click="open = !open" type="button">
                    <ion-icon class="text-3xl cursor-pointer mr-[10px]" onclick="onToggleMenu(this)" name="menu"></ion-icon>
                </button>

                {{-- Dropdown Menu--}}
                <div x-show="open" @click.outside="open = false" class="bg-white shadow-lg absolute top-10 right-0 rounded-lg overflow-hidden font-light">
                    
                    @auth
                        <p class="username">{{ auth()->user()->username }}</p>                  
                    @endauth

                    <a class="block hover:text-green-200 pl-4 pr-8 py-2 mb-1" href="#">About</a>
                    <a class="block hover:text-green-200 pl-4 pr-8 py-2 mb-1" href="#">Waste</a>
                    <a class="block hover:text-green-200 pl-4 pr-8 py-2 mb-1" href="#">ContactUs</a>
                    @auth                       
                        <a href="{{ route('dashboard') }}" class="block hover:text-green-200 pl-4 pr-8 py-2 mb-1">Profile</a>

                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="block hover:text-green-200 pl-4 pr-8 py-2 mb-1">Logout</button>
                        </form>
                    @endauth
               
                </div>
            </div>
        </nav>
    </header>

    <main>
        {{ $slot }}
    </main>
</body>
</html>