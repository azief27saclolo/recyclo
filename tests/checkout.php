<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout - Recyclo</title>
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body id="top">
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
          <button class="header-action-btn" aria-label="user">
            <ion-icon name="person-outline" aria-hidden="true" aria-hidden="true"></ion-icon>
          </button>
          <button class="header-action-btn" aria-label="heart item">
            <ion-icon name="heart-outline" aria-hidden="true" aria-hidden="true"></ion-icon>
            <span class="btn-badge">0</span>
          </button>
          <button class="header-action-btn" aria-label="cart item">
            <ion-icon name="cart-outline" aria-hidden="true" aria-hidden="true"></ion-icon>
            <span class="btn-badge">0</span>
          </button>
        </div>
        <nav class="navbar">
          <ul class="navbar-list">
            <li>
              <a href="index.html" class="navbar-link has-after">Home</a>
            </li>
            <li>
              <a href="#collection" class="navbar-link has-after">About Us</a>
            </li>
            <li>
              <a href="#collection" class="navbar-link has-after">Categories</a>
            </li>
            <li>
              <a href="#collection" class="navbar-link has-after">Goals</a>
            </li>
            <li>
              <a href="shops.html" class="navbar-link has-after">Shops</a>
            </li>
            <li>
                <a href="shops.html" class="navbar-link has-after">Orders</a>
              </li>
          </ul>
        </nav>

      </div>
    </div>
  </header>
  <div class="sidebar">
    <div class="mobile-navbar" data-navbar>

      <div class="wrapper">
        <h1>Recyclo</h1>
        <button class="nav-close-btn" aria-label="close menu" data-nav-toggler>
          <ion-icon name="close-outline" aria-hidden="true"></ion-icon>
        </button>
      </div>
      <ul class="navbar-list">
        <li>
          <a href="#home" class="navbar-link" data-nav-link>Home</a>
        </li>
        <li>
          <a href="#shop" class="navbar-link" data-nav-link>Categories</a>
        </li>
        <li>
          <a href="#offer" class="navbar-link" data-nav-link>Shops</a>
        </li>
      </ul>
    </div>
    <div class="overlay" data-nav-toggler data-overlay></div>
  </div>
  <main>
    <article>
        <section class="section checkout" id="checkout" aria-label="checkout" data-section>
            <div class="container">
                <div class="checkout-header">
                    <h2 class="h2 section-title">Checkout</h2>
                    <p class="checkout-subtitle">Complete your purchase</p>
                </div>

                <div class="checkout-content">
                    <!-- Order Summary -->
                    <div class="checkout-card">
                        <div class="card-header">
                            <h3><i class="bi bi-bag"></i> Order Summary</h3>
                        </div>
                        <div class="card-content">
                            <div class="product-card">
                                <img src="./assets/images/wood.jpg" alt="Wood Scraps" class="product-image">
                                <div class="product-info">
                                    <div class="shop-name">Ronald Organic Shop</div>
                                    <h4 class="product-name">Wood Scraps Furniture</h4>
                                    <div class="product-price">₱20.00 × 3kg</div>
                                </div>
                            </div>

                            <div class="price-summary">
                                <div class="price-row">
                                    <span>Subtotal</span>
                                    <span>₱60.00</span>
                                </div>
                                <div class="price-row total">
                                    <span>Total</span>
                                    <span>₱60.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="checkout-card">
                        <div class="card-header">
                            <h3><i class="bi bi-credit-card"></i> Payment Details</h3>
                        </div>
                        <div class="card-content">
                            <div class="payment-option">
                                <div class="gcash-details">
                                    <img src="./assets/images/mon.jpg" alt="GCash" class="gcash-logo">
                                    <div class="gcash-info">
                                        <p class="gcash-label">Scan / Send payment to:</p>
                                        <p class="gcash-number">0929 519 0987</p>
                                        <p class="gcash-name">Ronald P.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="pickup-info">
                                <h4><i class="bi bi-shop"></i> Pickup Information</h4>
                                <p class="pickup-address">Ronald Organic Shop<br>123 Green Street, Manila</p>
                                <p class="pickup-note">Please pick up your order within 3 days after payment confirmation.</p>
                            </div>

                            <div class="action-buttons">
                                <button type="button" class="btn-primary" onclick="window.location.href='completed.php'">
                                    Complete Order
                                </button>
                                <button type="button" class="btn-secondary" onclick="window.location.href='index.php'">
                                    Continue Shopping
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </article>
</main>

<style>
/* Base styles */
.checkout-content {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.checkout-header {
    text-align: center;
    margin-bottom: 40px;
}

.checkout-subtitle {
    color: #666;
    margin-top: 5px;
}

.checkout-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 25px;
    overflow: hidden;
}

.card-header {
    background: var(--hoockers-green);
    color: white;
    padding: 15px 20px;
}

.card-header h3 {
    margin: 0;
    font-size: 1.2rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.card-content {
    padding: 20px;
}

/* Product card styles */
.product-card {
    display: flex;
    gap: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid #eee;
}

.product-image {
    width: 100px;
    height: 100px;
    border-radius: 10px;
    object-fit: cover;
}

.product-info {
    flex: 1;
}

.shop-name {
    color: var(--hoockers-green);
    font-size: 0.9rem;
    margin-bottom: 5px;
}

.product-name {
    margin: 5px 0;
    font-size: 1.1rem;
}

.product-price {
    color: #666;
    font-size: 1rem;
}

/* Price summary styles */
.price-summary {
    margin-top: 20px;
}

.price-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    color: #666;
}

.price-row.total {
    border-top: 2px solid #eee;
    margin-top: 10px;
    padding-top: 15px;
    font-weight: 600;
    color: var(--hoockers-green);
    font-size: 1.2rem;
}

/* Payment section styles */
.payment-option {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 30px;
    margin-bottom: 20px;
    text-align: center;
}

.gcash-details {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
}

.gcash-logo {
    height: 80px; /* Increased from 40px */
    width: auto;
    object-fit: contain;
}

.gcash-info {
    width: 100%;
    text-align: center;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.gcash-label {
    color: #666;
    margin-bottom: 10px;
    font-size: 1rem;
}

.gcash-number {
    font-size: 1.8rem; /* Increased from 1.2rem */
    font-weight: 600;
    color: var(--hoockers-green);
    margin: 10px 0;
}

.gcash-name {
    color: #333;
    font-size: 1.2rem;
    font-weight: 500;
}

/* Add a QR code section if needed */
.gcash-qr {
    margin-top: 20px;
    padding: 15px;
    border: 2px dashed #ddd;
    border-radius: 10px;
    display: inline-block;
}

/* Pickup info styles */
.pickup-info {
    margin: 25px 0;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 10px;
}

.pickup-info h4 {
    color: var(--hoockers-green);
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.pickup-address {
    margin-bottom: 10px;
    color: #333;
}

pickup-note {
    color: #666;
    font-size: 0.9rem;
}

/* Button styles */
.action-buttons {
    display: grid;
    gap: 15px;
    margin-top: 25px;
}

.btn-primary {
    background: var(--hoockers-green);
    color: white;
    border: none;
    padding: 15px;
    border-radius: 8px;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
}

.btn-secondary {
    background: none;
    border: 2px solid var(--hoockers-green);
    color: var(--hoockers-green);
    padding: 15px;
    border-radius: 8px;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
}

.btn-primary:hover {
    background: var(--hoockers-green_80);
    transform: translateY(-2px);
}

.btn-secondary:hover {
    background: rgba(81, 122, 91, 0.1);
}

@media (max-width: 768px) {
    .checkout-content {
        padding: 10px;
    }

    .product-card {
        flex-direction: column;
    }

    .product-image {
        width: 100%;
        height: 200px;
    }
}
</style>
  <footer class="footer" data-section>
    <div class="container">
      <div class="footer-top">
        <ul class="footer-list">
          <li>
            <p class="footer-list-title"><i class="bi bi-link-45deg"></i> Recyclo Links</p>
          </li>
          <li>
            <p class="footer-list-text">
              <i class="bi bi-facebook"></i>   <a href="#" class="link">Recyclo</a>
            </p>
          </li>
          <br>
          <li>
            <p class="footer-list-text">
              <i class="bi bi-instagram"></i>   <a href="#" class="link">@RecycloEst2024</a>
            </p>
          </li>
          <br>
          <li>
            <p class="footer-list-text">
              <i class="bi bi-twitter"></i>   <a href="#" class="link">RecycloEst2024</a>
            </p>
          </li>
        </ul>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Shops</p>
          </li>

          <li>
            <a href="#" class="footer-link">New Products</a>
          </li>

          <li>
            <a href="#" class="footer-link">Best Sellers</a>
          </li>

        </ul>

        <ul class="footer-list">
          <li>
            <p class="footer-list-title"><i class="bi bi-info-circle"></i> Infomation</p>
          </li>
          <li>
            <a href="#" class="footer-link">About Us</a>
          </li>
          <li>
            <a href="#" class="footer-link">Start a Return</a>
          </li>

          <li>
            <a href="#" class="footer-link">Contact Us</a>
          </li>

          <li>
            <a href="#" class="footer-link">Shipping FAQ</a>
          </li>

          <li>
            <a href="#" class="footer-link">Terms & Conditions</a>
          </li>

          <li>
            <a href="#" class="footer-link">Privacy Policy</a>
          </li>

        </ul>

        <div class="footer-list">

          <p class="newsletter-title">Good emails.</p>

          <p class="newsletter-text">
            Enter your email below to be the first to know about new collections and product launches.
          </p>

          <form action="" class="newsletter-form">
            <input type="email" name="email_address" placeholder="Enter your email address" required
              class="email-field">

            <button type="submit" class="btn btn-primary">Subscribe</button>
          </form>

        </div>

      </div>

      <div class="footer-bottom">

        <div class="wrapper">
          <p class="copyright">
            &copy; 2024 Recyclo
          </p>

          <ul class="social-list">

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-twitter"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-facebook"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-instagram"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-youtube"></ion-icon>
              </a>
            </li>

          </ul>
        </div>

        <div style="display: flex; align-items: center;">
          <img src="./assets/images/mainlogo.png" alt="Logo" style="width: 50px; height: 50px; margin-right: 10px;">
          <h1 style="color: black; margin: 0;"></h1>
      </div>

        <img src="./assets/images/p.png" width="313" height="28" alt="available all payment method" class="w-100">

      </div>

    </div>
  </footer>

  <a href="#top" class="back-top-btn" aria-label="back to top" data-back-top-btn>
    <ion-icon name="arrow-up" aria-hidden="true"></ion-icon>
  </a>
  <script src="./assets/js/script.js" defer></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script>
    document.querySelectorAll('input[name="payment-method"]').forEach((input) => {
      input.addEventListener('change', function() {
        const locationDetails = document.getElementById('location-details');
        if (this.value === 'cod') {
          locationDetails.style.display = 'block';
        } else {
          locationDetails.style.display = 'none';
        }
      });
    });
  </script>
</body>

</html>