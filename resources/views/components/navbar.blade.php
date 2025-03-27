<div class="navbar">
    <a href="{{ url('/') }}" class="navbar-brand">
        <img src="{{ asset('images/mainlogo.png') }}" alt="Recyclo">
        <span>Recyclo</span>
    </a>
    
    <ul class="navbar-nav">
        <li class="nav-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="nav-item"><a href="{{ route('posts') }}">Browse</a></li>
        <li class="nav-item"><a href="{{ route('shop.dashboard') }}">My Shop</a></li>
        <li class="nav-item"><a href="{{ route('profile') }}">Profile</a></li>
    </ul>
</div>
