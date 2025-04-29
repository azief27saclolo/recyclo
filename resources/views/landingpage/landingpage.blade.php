<x-layout>
    <section class="bg-green-600 h-[60vh] flex items-center flex-col justify-center gap-5">
        <h1 class="text-3xl text-center text-white font-semibold">Your Trash Has Value – <br> Recycle and Earn!</h1>
        <p class="text-center text-white">Don’t let valuable waste go to waste! Join others turning their trash into cash by recycling responsibly today!</p>
        <a class="text-black font-semibold bg-green-400 py-3 px-5 rounded-sm" href="{{ route('login') }}">Recycle Now!</a>
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
    
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Profile setup notification - Improved animation
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
    transition: all 0.5s cubic-bezier(0.19, 1, 0.22, 1);
    max-width: 700px; /* Wider modal for better text display */
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
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
    background-color: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(8px);
    transition: all 0.4s ease-out;
}

.modal-backdrop-hidden {
    background-color: rgba(0, 0, 0, 0);
    backdrop-filter: blur(0px);
    transition: all 0.4s ease-in;
}

/* Animation for the icon */
.animate-pulse-slow {
    animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
        transform: scale(1);
    }
    50% {
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
}

#profileSetupModal .bg-green-600 {
    background-color: #517A5B;
}

#profileSetupModal .hover\:bg-green-700:hover {
    background-color: #3c5c44;
}

#profileSetupModal .focus\:ring-green-500:focus {
    --tw-ring-color: rgba(81, 122, 91, 0.5);
}

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
</x-layout>
