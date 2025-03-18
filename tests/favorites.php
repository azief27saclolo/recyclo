<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Favorites - Recyclo</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .favorites-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .favorites-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .favorites-title {
            color: var(--hoockers-green);
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .favorites-subtitle {
            color: #666;
            font-size: 1.1rem;
        }

        .favorites-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }

        .favorite-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
        }

        .favorite-card:hover {
            transform: translateY(-5px);
        }

        .product-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .category-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            color: white;
            background: rgba(81, 122, 91, 0.9);
            backdrop-filter: blur(5px);
        }

        .product-info {
            padding: 20px;
        }

        .shop-name {
            color: var(--hoockers-green);
            font-size: 0.9rem;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .product-name {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: #333;
        }

        .product-price {
            color: var(--hoockers-green);
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .product-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .action-btn {
            padding: 8px 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.9rem;
        }

        .remove-btn {
            color: #dc3545;
            background: none;
        }

        .add-cart-btn {
            background: var(--hoockers-green);
            color: white;
        }

        .add-cart-btn:hover {
            background: var(--hoockers-green_80);
        }

        .remove-btn:hover {
            background: #fff5f5;
        }

        .empty-favorites {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .empty-favorites i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 20px;
        }

        .empty-favorites h3 {
            color: #333;
            margin-bottom: 10px;
        }

        .empty-favorites p {
            margin-bottom: 20px;
        }

        .browse-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 25px;
            background: var(--hoockers-green);
            color: white;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .browse-btn:hover {
            background: var(--hoockers-green_80);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .favorites-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }
    </style>
</head>
<body id="top">
    <!-- Header Section -->
    <header class="header">
        <div class="header-top" data-header>
            <div class="container">
                <button class="nav-open-btn" aria-label="open menu" data-nav-toggler>
                    <span class="line line-1"></span>
                    <span class="line line-2"></span>
                    <span class="line line-3"></span>
                </button>
                <div class="input-wrapper">
                    <input type="search" name="search" placeholder="Search product" class="search-field">
                    <button class="search-submit" aria-label="search">
                        <ion-icon name="search-outline" aria-hidden="true"></ion-icon>
                    </button>
                </div>
                <div style="display: flex; align-items: center;">
                    <img src="./assets/images/mainlogo.png" alt="Logo" style="width: 50px; height: 50px; flex-shrink: 0; margin-right: 10px;">
                    <div style="flex-grow: 1; text-align: center;">
                        <h1 style="color: green; margin: 0;">Recyclo</h1>
                    </div>
                </div>
                
                <div class="header-actions">
                    <?php if (isset($_SESSION['user_logged_in'])): ?>
                        <div class="profile-dropdown">
                            <button type="button" class="profile-btn" id="profileDropdownBtn">
                                <i class="bi bi-person-check-fill"></i>
                                <span class="profile-name">Profile</span>
                            </button>
                            <div class="dropdown-content" id="profileDropdown">
                                <a href="profile.php">
                                    <i class="bi bi-person"></i>
                                    <span>My Profile</span>
                                </a>
                                <a href="orders.php">
                                    <i class="bi bi-cart"></i>
                                    <span>My Orders</span>
                                </a>
                                <a href="favorites.php">
                                    <i class="bi bi-heart"></i>
                                    <span>Favorites</span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="logout.php" class="logout-btn">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="login-btn">
                            <i class="bi bi-person"></i>
                            <span>Login</span>
                        </a>
                    <?php endif; ?>
                    
                    <button class="header-action-btn" aria-label="favorite">
                        <ion-icon name="heart-outline" aria-hidden="true"></ion-icon>
                        <span class="btn-badge">0</span>
                    </button>
                    
                    <button class="header-action-btn" aria-label="cart">
                        <ion-icon name="cart-outline" aria-hidden="true"></ion-icon>
                        <span class="btn-badge">0</span>
                    </button>
                </div>

                <nav class="navbar">
                    <ul class="navbar-list">
                        <li><a href="index.php" class="navbar-link has-after">Home</a></li>
                        <li><a href="about.php" class="navbar-link has-after">About Us</a></li>
                        <li><a href="categories.php" class="navbar-link has-after">Categories</a></li>
                        <li><a href="goals.php" class="navbar-link has-after">Goals</a></li>
                        <li><a href="shops.php" class="navbar-link has-after">Shops</a></li>
                        <li><a href="orders.php" class="navbar-link has-after">Orders</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <div class="favorites-container">
            <div class="favorites-header">
                <h1 class="favorites-title">My Favorites</h1>
                <p class="favorites-subtitle">Products you've liked and saved for later</p>
            </div>

            <div class="favorites-grid">
                <!-- Sample favorite items -->
                <div class="favorite-card">
                    <div class="product-image">
                        <img src="./assets/images/wood.jpg" alt="Wood Scraps">
                        <span class="category-badge">Wood</span>
                    </div>
                    <div class="product-info">
                        <div class="shop-name">
                            <i class="bi bi-shop"></i> Ronald Organic Shop
                        </div>
                        <h3 class="product-name">Wood Scraps Furniture</h3>
                        <div class="product-price">₱20.00 per kg</div>
                        <div class="product-actions">
                            <button class="action-btn remove-btn">
                                <i class="bi bi-heart-fill"></i> Remove
                            </button>
                            <button class="action-btn add-cart-btn">
                                <i class="bi bi-cart-plus"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Add more favorite cards here -->
                
                <!-- Empty state (hidden by default) -->
                <div class="empty-favorites" style="display: none;">
                    <i class="bi bi-heart"></i>
                    <h3>No favorites yet</h3>
                    <p>Items you like will appear here</p>
                    <a href="index.php" class="browse-btn">
                        <i class="bi bi-shop"></i> Browse Products
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer Section -->
    <footer class="footer" data-section>
        <div class="container">
            <div class="footer-top">
                <ul class="footer-list">
                    <li>
                        <p class="footer-list-title"><i class="bi bi-link-45deg"></i> Recyclo Links</p>
                    </li>
                    <li>
                        <p class="footer-list-text">
                            <i class="bi bi-facebook"></i> <a href="#" class="link">Recyclo</a>
                        </p>
                    </li>
                    <li>
                        <p class="footer-list-text">
                            <i class="bi bi-instagram"></i> <a href="#" class="link">@RecycloEst2024</a>
                        </p>
                    </li>
                    <li>
                        <p class="footer-list-text">
                            <i class="bi bi-twitter"></i> <a href="#" class="link">RecycloEst2024</a>
                        </p>
                    </li>
                </ul>

                <ul class="footer-list">
                    <li>
                        <p class="footer-list-title">Shops</p>
                    </li>
                    <li><a href="#" class="footer-link">New Products</a></li>
                    <li><a href="#" class="footer-link">Best Sellers</a></li>
                </ul>

                <ul class="footer-list">
                    <li>
                        <p class="footer-list-title"><i class="bi bi-info-circle"></i> Information</p>
                    </li>
                    <li><a href="#" class="footer-link">About Us</a></li>
                    <li><a href="#" class="footer-link">Contact Us</a></li>
                    <li><a href="#" class="footer-link">Terms & Conditions</a></li>
                    <li><a href="#" class="footer-link">Privacy Policy</a></li>
                </ul>

                <div class="footer-list">
                    <p class="newsletter-title">Good emails.</p>
                    <p class="newsletter-text">
                        Enter your email below to be the first to know about new collections and product launches.
                    </p>
                    <form action="" class="newsletter-form">
                        <input type="email" name="email_address" placeholder="Enter your email address" required class="email-field">
                        <button type="submit" class="btn btn-primary">Subscribe</button>
                    </form>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="wrapper">
                    <p class="copyright">&copy; 2024 Recyclo</p>
                    <img src="./assets/images/mainlogo.png" alt="Logo" style="width: 50px; height: 50px; margin-right: 10px;">
                </div>
            </div>
        </div>
    </footer>

    <a href="#top" class="back-top-btn" aria-label="back to top" data-back-top-btn>
        <ion-icon name="arrow-up" aria-hidden="true"></ion-icon>
    </a>

    <!-- Scripts -->
    <script src="./assets/js/script.js" defer></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script>
        // Sample interaction for remove button
        document.querySelectorAll('.remove-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const card = this.closest('.favorite-card');
                card.style.opacity = '0';
                setTimeout(() => card.remove(), 300);
            });
        });
    </script>
</body>
</html>
