<x-layout>
    <section class="bg-green-600 h-[60vh] flex items-center flex-col justify-center gap-5">
        <h1 class="text-3xl text-center text-white font-semibold">Your Trash Has Value – <br> Recycle and Earn!</h1>
        <p class="text-center text-white">Don’t let valuable waste go to waste! Join others turning their trash into cash by recycling responsibly today!</p>
        <a class="text-black font-semibold bg-green-400 py-3 px-5 rounded-sm" href="{{ route('posts') }}">Recycle Now!</a>
    </section>

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