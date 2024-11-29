<x-layout>
    @guest

    @endguest

   @auth
   <h1>Latest Post</h1>

   <div class="header">
    <img src="../images/logo1.png" alt="Recyclo Logo" class="logo">
    <h1 class="title">Re<span>cyclo</span></h1>
    <div class="menu">
        <i class="bi bi-list"></i>
    </div>
</div>

<div class="hero-section">
    <div class="hero-content">
        <img src="../images/bg.jpg" alt="Hero Image" class="hero-image">
    </div>
</div>

<div class="categories">
    <h3>Categories</h3>
    <div class="category-items">
        <button class="category-btn">Plastic</button>
        <button class="category-btn">Metal</button>
        <button class="category-btn">Paper</button>
    </div>
</div>

<div class="section">
    <h3>Shops Near You</h3>
    <div class="shop-card">
        <img src="../images/metals1.jpg" alt="Plastic Waste">
        <span class="star-icon">★</span>
        <div class="shop-info">
            <h4>Ronald's Junk Shop</h4>
            <span class="waste-filter">Metal</span>
            <p>Veterans Ave Ext, Zamboanga City</p>
            <p>₱ 20.00 per kilo</p>
            <span class="rating">★ 5.0</span>
        </div>
        <button class="buy-btn">Buy</button>
    </div>

    <div class="shop-card">
        <img src="../images/plasticwaste2.jpg" alt="Metal Waste">
        <span class="star-icon">★</span>
        <div class="shop-info">
            <h4>Ian's Recycle Shop</h4>
            <span class="waste-filter">Plastic</span>
            <span class="waste-filter">Paper</span>
            <p>Veterans Ave Ext, Zamboanga City</p>
            <p>₱ 20.00 per kilo</p>
            <span class="rating">★ 5.0</span>
        </div>
        <button class="buy-btn" onclick="window.location.href='buy.html?productId=2&productName=Ian%27s%20Recycle%20Shop&location=Veterans%20Ave%20Ext,%20Zamboanga%20City&price=20.00&imageUrl=../images/metals1.jpg'">Buy</button>
    </div>
</div>

<div class="section">
    <h3>More Shops For You</h3>
    <div class="shop-card">
        <img src="../images/metals1.jpg" alt="Plastic Waste">
        <div class="shop-info">
            <h4>Ronald's Junk Shop</h4>
            <span class="waste-filter">Metal</span>
            <p>Veterans Ave Ext, Zamboanga City</p>
            <p>₱ 20.00 per kilo</p>
            <span class="rating">★ 5.0</span>
        </div>
        <button class="buy-btn" onclick="window.location.href='buy.html?productId=1&productName=Ronald%27s%20Junk%20Shop&location=Veterans%20Ave%20Ext,%20Zamboanga%20City&price=20.00&imageUrl=../images/plasticwaste2.jpg'">Buy</button>
    </div>

    <div class="shop-card">
        <img src="../images/plasticwaste2.jpg" alt="Metal Waste">
        <div class="shop-info">
            <h4>Ian's Recycle Shop</h4>
            <span class="waste-filter">Plastic</span>
            <span class="waste-filter">Paper</span>
            <p>Veterans Ave Ext, Zamboanga City</p>
            <p>₱ 20.00 per kilo</p>
            <span class="rating">★ 5.0</span>
        </div>
        <button class="buy-btn" onclick="window.location.href='buy.html?productId=2&productName=Ian%27s%20Recycle%20Shop&location=Veterans%20Ave%20Ext,%20Zamboanga%20City&price=20.00&imageUrl=../images/metals1.jpg'">Buy</button>
    </div>
    <div class="shop-card">
        <img src="../images/plasticwaste2.jpg" alt="Metal Waste">
        <div class="shop-info">
            <h4>Lim's Recycle Shop</h4>
            <span class="waste-filter">Plastic</span>
            <span class="waste-filter">Paper</span>
            <p>Veterans Ave Ext, Zamboanga City</p>
            <p>₱ 20.00 per kilo</p>
            <span class="rating">★ 5.0</span>
        </div>
        <button class="buy-btn" onclick="window.location.href='buy.html?productId=2&productName=Ian%27s%20Recycle%20Shop&location=Veterans%20Ave%20Ext,%20Zamboanga%20City&price=20.00&imageUrl=../images/metals1.jpg'">Buy</button>
    </div>
    <div class="shop-card">
        <img src="../images/plasticwaste2.jpg" alt="Metal Waste">
        <div class="shop-info">
            <h4>Azief's Recycle Shop</h4>
            <span class="waste-filter">Plastic</span>
            <span class="waste-filter">Paper</span>
            <p>Veterans Ave Ext, Zamboanga City</p>
            <p>₱ 20.00 per kilo</p>
            <span class="rating">★ 5.0</span>
        </div>
        <button class="buy-btn" onclick="window.location.href='buy.html?productId=2&productName=Ian%27s%20Recycle%20Shop&location=Veterans%20Ave%20Ext,%20Zamboanga%20City&price=20.00&imageUrl=../images/metals1.jpg'">Buy</button>
    </div>
    <div class="shop-card">
        <img src="../images/plasticwaste2.jpg" alt="Metal Waste">
        <div class="shop-info">
            <h4>Jameel's Recycle Shop</h4>
            <span class="waste-filter">Plastic</span>
            <span class="waste-filter">Paper</span>
            <p>Veterans Ave Ext, Zamboanga City</p>
            <p>₱ 20.00 per kilo</p>
            <span class="rating">★ 5.0</span>
        </div>
        <button class="buy-btn" onclick="window.location.href='buy.html?productId=2&productName=Ian%27s%20Recycle%20Shop&location=Veterans%20Ave%20Ext,%20Zamboanga%20City&price=20.00&imageUrl=../images/metals1.jpg'">Buy</button>
    </div>
</div>
<div class="footer">
    <img src="../images/recycle.jpg" alt="Recyclo Logo" class="footer-logo" style="width: 430px; height: 90px; object-fit: cover; margin-bottom: -5px;">
<div class="footer-links">
    </div>
</div>

<div class="nav-bar">
    <div class="nav-item">
        <i class="bi bi-house-door-fill"></i>
        <span>Home</span>
    </div>
    <div class="nav-item">
        <i class="bi bi-cart3"></i>
        <span>Cart</span>
    </div>
    <div class="nav-item">
        <i class="bi bi-search"></i>
        <span>Search</span>
    </div>
    <div class="nav-item">
        <i class="bi bi-person-circle"></i>
        <span>Account</span>
    </div>
</div>
<script src="script.js"></script>

   {{-- <div>
       {{ $posts->links() }}
   </div> --}}
   @endauth
</x-layout>