<x-layout>
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

                  <p class="hero-text"style="color: black">
                    Recyclo has alot to offer of different kinds of recyclable materials!
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
                  <p class="hero-text"  style="color: black">
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

            <li class="scrollbar-item">
              <div class="shop-card">

                <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                  <img src="images/cups.jpg" width="540" height="720" loading="lazy"
                    alt="Facial cleanser" class="img-cover">

                  <span class="badge" aria-label="20% off">Plastic</span>
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

                    <span class="span">₱20.00</span>
                  </div>

                  <h3>
                    <a href="#" class="card-title">Ronald's Shop</a>
                  </h3>

                  <div class="card-rating">

                    <div class="rating-wrapper" aria-label="5 start rating">
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                    </div>

                    <p class="rating-text">5170 reviews</p>

                  </div>

                </div>

              </div>
            </li>

            <li class="scrollbar-item">
              <div class="shop-card">

                <div class="card-banner img-holder" style="--width: 540; --height: 720; --border-radius: 20px;"                >
                  <img src="images/mets.jpg" border-radius="20px"width="540" height="720" loading="lazy"
                    alt="Bio-shroom Rejuvenating Serum" class="img-cover">
                    <span class="badge" aria-label="20% off">Metal</span>
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
                    <span class="span">₱20.00</span>
                  </div>

                  <h3>
                    <a href="#" class="card-title">John's Shop</a>
                  </h3>

                  <div class="card-rating">

                    <div class="rating-wrapper" aria-label="5 start rating">
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                    </div>

                    <p class="rating-text">5170 reviews</p>

                  </div>

                </div>

              </div>
            </li>

            <li class="scrollbar-item">
              <div class="shop-card">

                <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                  <img src="images/wood.jpg" width="540" height="720" loading="lazy"
                    alt="Coffee Bean Caffeine Eye Cream" class="img-cover">
                    <span class="badge" aria-label="20% off">Wood</span>
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
                    <span class="span">₱20.00</span>
                  </div>

                  <h3>
                    <a href="#" class="card-title">Fred's Shop</a>
                  </h3>

                  <div class="card-rating">

                    <div class="rating-wrapper" aria-label="5 start rating">
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                    </div>

                    <p class="rating-text">5170 reviews</p>

                  </div>

                </div>

              </div>
            </li>

            <li class="scrollbar-item">
              <div class="shop-card">

                <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                  <img src="images/bottle.jpg" width="540" height="720" loading="lazy"
                    alt="Facial cleanser" class="img-cover">
                    <span class="badge" aria-label="20% off">Glass</span>
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
                    <span class="span">₱20.00</span>
                  </div>

                  <h3>
                    <a href="#" class="card-title">Teppey's Shop</a>
                  </h3>

                  <div class="card-rating">

                    <div class="rating-wrapper" aria-label="5 start rating">
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                    </div>

                    <p class="rating-text">5170 reviews</p>

                  </div>

                </div>

              </div>
            </li>

            <li class="scrollbar-item">
              <div class="shop-card">

                <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                  <img src="images/br.jpg" width="540" height="720" loading="lazy"
                    alt="Coffee Bean Caffeine Eye Cream" class="img-cover">

                  <span class="badge" aria-label="20% off">Plastic</span>

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
                    <span class="span">₱20.00</span>
                  </div>

                  <h3>
                    <a href="#" class="card-title">Ragnar's Shop</a>
                  </h3>

                  <div class="card-rating">

                    <div class="rating-wrapper" aria-label="5 start rating">
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                    </div>

                    <p class="rating-text">5170 reviews</p>

                  </div>

                </div>

              </div>
            </li>

            <li class="scrollbar-item">
              <div class="shop-card">

                <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                  <img src="images/cups.jpg" width="540" height="720" loading="lazy"
                    alt="Facial cleanser" class="img-cover">
                    <span class="badge" aria-label="20% off">Plastic</span>
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
                    <span class="span">₱20.00</span>
                  </div>

                  <h3>
                    <a href="#" class="card-title">Ronald's Shop</a>
                  </h3>

                  <div class="card-rating">

                    <div class="rating-wrapper" aria-label="5 start rating">
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                    </div>

                    <p class="rating-text">5170 reviews</p>

                  </div>

                </div>

              </div>
            </li>

          </ul>

        </div>
      </section>

      <section class="section shop" id="shop" aria-label="shop">
        <div class="container">

          <div class="title-wrapper">
            <h2 class="h2 section-title">Shops For You</h2>

            <a href="#" class="btn-link">
              <span class="span">View More Shops</span>

              <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
            </a>
          </div>

          <ul class="has-scrollbar">
            <li class="scrollbar-item">
              <div class="shop-card">

                <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                  <img src="images/f1.jpg" width="540" height="720" loading="lazy"
                    alt="Facial cleanser" class="img-cover">
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
                    <span class="span">Ronald Organic</span>
                  </div>

                  <h3>
                    <a href="#" class="card-title">Ronald's Shop</a>
                  </h3>

                  <div class="card-rating">

                    <div class="rating-wrapper" aria-label="5 start rating">
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                    </div>

                    <p class="rating-text">5170 reviews</p>

                  </div>

                </div>

              </div>
            </li>

            <li class="scrollbar-item">
              <div class="shop-card">

                <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                  <img src="images/f2.jpg" width="540" height="720" loading="lazy"
                    alt="Bio-shroom Rejuvenating Serum" class="img-cover">

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
                    <span class="span">John Organic</span>
                  </div>

                  <h3>
                    <a href="#" class="card-title">John's Shop</a>
                  </h3>

                  <div class="card-rating">

                    <div class="rating-wrapper" aria-label="5 start rating">
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                    </div>

                    <p class="rating-text">5170 reviews</p>

                  </div>

                </div>

              </div>
            </li>

            <li class="scrollbar-item">
              <div class="shop-card">

                <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                  <img src="images/f3.jpg" width="540" height="720" loading="lazy"
                    alt="Coffee Bean Caffeine Eye Cream" class="img-cover">

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
                    <span class="span">Teppey Recycle</span>
                  </div>

                  <h3>
                    <a href="#" class="card-title">Teppey's Shop</a>
                  </h3>

                  <div class="card-rating">

                    <div class="rating-wrapper" aria-label="5 start rating">
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                    </div>

                    <p class="rating-text">5170 reviews</p>

                  </div>

                </div>

              </div>
            </li>

            <li class="scrollbar-item">
              <div class="shop-card">

                <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                  <img src="images/f4.jpg" width="540" height="720" loading="lazy"
                    alt="Facial cleanser" class="img-cover">

                  <div class="card-actions">

                    <button class="action-btn" aria-label="add to cart">
                      <ion-icon name="bag-handle-outline" aria-hidden="true"></ion-icon>
                    </button>

                    <button class="action-btn" aria-label="add to whishlist">
                      <ion-icon name="star-outline" aria-hidden="true"></ion-icon>
                    </button>

                    <button class="action-btn" aria-label="compare">
                      <ion-icon name="repeat-outline" aria-hidden="true"></ion-icon>
                    </button>

                  </div>
                </div>

                <div class="card-content">

                  <div class="price">
                    <span class="span">Fred Economy</span>
                  </div>

                  <h3>
                    <a href="#" class="card-title">Fred's Shop</a>
                  </h3>

                  <div class="card-rating">

                    <div class="rating-wrapper" aria-label="5 start rating">
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                    </div>

                    <p class="rating-text">5170 reviews</p>

                  </div>

                </div>

              </div>
            </li>

            <li class="scrollbar-item">
              <div class="shop-card">

                <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                  <img src="images/f5.jpg" width="540" height="720" loading="lazy"
                    alt="Coffee Bean Caffeine Eye Cream" class="img-cover">
                  <div class="card-actions">

                    <button class="action-btn" aria-label="add to cart">
                      <ion-icon name="bag-handle-outline" aria-hidden="true"></ion-icon>
                    </button>

                    <button class="action-btn" aria-label="add to whishlist">
                      <ion-icon name="star-outline" aria-hidden="true"></ion-icon>
                    </button>

                    <button class="action-btn" aria-label="compare">
                      <ion-icon name="repeat-outline" aria-hidden="true"></ion-icon>
                    </button>

                  </div>
                </div>

                <div class="card-content">

                  <div class="price">
                    <span class="span">Ragnar Junk Shop</span>
                  </div>

                  <h3>
                    <a href="#" class="card-title">Ragnar's Shop</a>
                  </h3>

                  <div class="card-rating">

                    <div class="rating-wrapper" aria-label="5 start rating">
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                    </div>

                    <p class="rating-text">5170 reviews</p>

                  </div>

                </div>

              </div>
            </li>

            <li class="scrollbar-item">
              <div class="shop-card">

                <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                  <img src="images/f6.jpg" width="540" height="720" loading="lazy"
                    alt="Facial cleanser" class="img-cover">

                  <div class="card-actions">

                    <button class="action-btn" aria-label="add to cart">
                      <ion-icon name="bag-handle-outline" aria-hidden="true"></ion-icon>
                    </button>

                    <button class="action-btn" aria-label="add to whishlist">
                      <ion-icon name="star-outline" aria-hidden="true"></ion-icon>
                    </button>

                    <button class="action-btn" aria-label="compare">
                      <ion-icon name="repeat-outline" aria-hidden="true"></ion-icon>
                    </button>

                  </div>
                </div>

                <div class="card-content">

                  <div class="price">
                    <span class="span">Aaron Brown</span>
                  </div>

                  <h3>
                    <a href="#" class="card-title">Aaron's Shop</a>
                  </h3>

                  <div class="card-rating">

                    <div class="rating-wrapper" aria-label="5 start rating">
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                    </div>

                    <p class="rating-text">5170 reviews</p>

                  </div>

                </div>

              </div>
            </li>

          </ul>

        </div>
      </section>

      <section class="section banner" aria-label="banner">
        <div class="container">

          <ul class="banner-list">

            <li>
              <div class="banner-card banner-card-1 has-before hover:shine">

                <p class="card-subtitle" style="color: whitesmoke;">Make an Order in Recyclo</p>

                <h2 class="h2 card-title"style="color: whitesmoke;">Budget-Friendly Prices!</h2>

                <a href="#" class="btn btn-secondary" >Order Now</a>

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

                <img src="images/c1.png" width="204" height="236" loading="lazy" alt="Guaranteed PURE"
                  class="card-icon">

                <h3 class="h3 card-title">100% Recyclable Materials</h3>

                <p class="card-text">
                  Throwaway materials can be much more and can be use in many different ways.
                </p>

              </div>
            </li>

            <li class="flex-item">
              <div class="feature-card">

                <img src="images/c2.png" width="204" height="236" loading="lazy"
                  alt="Completely Cruelty-Free" class="card-icon">

                <h3 class="h3 card-title">Pollution-Free</h3>

                <p class="card-text">
                  We care not only for our users but for the entire world. Hence, we support a greener planet!
                </p>

              </div>
            </li>

            <li class="flex-item">
              <div class="feature-card">

                <img src="images/c3.png" width="204" height="236" loading="lazy"
                  alt="Ingredient Sourcing" class="card-icon">

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
            <img src="images/r2.jpg" width="305" height="408" loading="lazy" alt="offer products"
              class="w-100">

            <img src="images/r1.jpg" width="450" height="625" loading="lazy" alt="offer products"
              class="w-100">
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
                  <img src="images/m1.jpg" width="700" height="450" loading="lazy" alt="Find a Store"
                    class="img-cover">
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
                  <img src="images/m2.jpg" width="700" height="450" loading="lazy" alt="From Our Blog"
                    class="img-cover">
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
                  <img src="images/blog-3.jpg" width="700" height="450" loading="lazy" alt="Our Story"
                    class="img-cover">
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

</x-layout>