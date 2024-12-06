<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="profilePageUSER.css">
    <link rel="stylesheet" href="../USER/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<style>
    body {
        color: #6F8BA4;
        margin-top: 20px;
    }

    .section {
        padding: 100px 0;
        position: relative;
    }

    .gray-bg {
        background-color: #f5f5f5;
    }

    img {
        max-width: 100%;
    }

    img {
        vertical-align: middle;
        border-style: none;
    }

    /* About Me 
---------------------*/
    .about-text h3 {
        font-size: 45px;
        font-weight: 700;
        margin: 0 0 6px;
    }

    @media (max-width: 767px) {
        .about-text h3 {
            font-size: 35px;
        }
    }

    .about-text h6 {
        font-weight: 600;
        margin-bottom: 15px;
    }

    @media (max-width: 767px) {
        .about-text h6 {
            font-size: 18px;
        }
    }

    .about-text p {
        font-size: 18px;
        max-width: 450px;
    }

    .about-text p mark {
        font-weight: 600;
        color: #20247b;
    }

    .about-list {
        padding-top: 10px;
    }

    .about-list .media {
        padding: 5px 0;
    }

    .about-list label {
        color: #20247b;
        font-weight: 600;
        width: 88px;
        margin: 0;
        position: relative;
    }

    .about-list label:after {
        content: "";
        position: absolute;
        top: 0;
        bottom: 0;
        right: 11px;
        width: 1px;
        height: 12px;
        background: #20247b;
        -moz-transform: rotate(15deg);
        -o-transform: rotate(15deg);
        -ms-transform: rotate(15deg);
        -webkit-transform: rotate(15deg);
        transform: rotate(15deg);
        margin: auto;
        opacity: 0.5;
    }

    .about-list p {
        margin: 0;
        font-size: 15px;
    }

    @media (max-width: 991px) {
        .about-avatar {
            margin-top: 30px;
        }
    }

    .about-avatar {
        width: 300px;
        height: 300px;
        border-radius: 50%;
        overflow: hidden;
        position: relative;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        border: 3px solid #4B81BD;
    }

    .about-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .username {
        text-align: center;
        margin-top: 10px;
        font-size: 20px;
        font-weight: 600;
        color: #20247b;
    }

    .edit {
        display: block;
        text-align: center;
        margin: 20px auto;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: 600;
        color: #fff;
        background-color: #4B81BD;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .edit:hover {
        background-color: #3a6ba1;
    }

    .about-section .counter {
        padding: 22px 20px;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 0 30px rgba(31, 45, 61, 0.125);
    }
    .counter{
        margin-top: 10px;
    }

    .about-section .counter .count-data {
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .about-section .counter .count {
        font-weight: 700;
        color: #20247b;
        margin: 0 0 5px;
    }

    .about-section .counter p {
        font-weight: 600;
        margin: 0;
    }

    mark {
        background-image: linear-gradient(rgba(252, 83, 86, 0.6), rgba(252, 83, 86, 0.6));
        background-size: 100% 3px;
        background-repeat: no-repeat;
        background-position: 0 bottom;
        background-color: transparent;
        padding: 0;
        color: currentColor;
    }

    .theme-color {
        color: #fc5356;
    }

    .dark-color {
        color: #20247b;
    }

    .dropdown-menu {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 200px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 8px 16px;
            cursor: pointer;
        }

        .dropdown-item img {
            margin-right: 10px;
        }

        .dropdown-item:hover {
            background-color: #f1f1f1;
        }

        .dropdown-toggle::after {
            display: none;
        }

        #navbarDropdown {
            margin-right: 150px;
            margin-top: 23px;
        }

        #tasker {
            margin-top: 23px;
        }

        .show {
            display: block;
        }
    
</style>

<body>

    <section class="section about-section gray-bg" id="about">

                  <div class="row align-items-center flex-row-reverse">
                <div class="col-lg-6 mt-5" >
                    <div class="about-text go-to">
                        <h3 class="dark-color">About Me</h3>
                        <h6 class="theme-color lead">A Lead UX &amp; Bisaya Warrior</h6>
                        <p>Diri katong about me content ni user</p>
                        <div class="row about-list">
                            <div class="col-md-6">
                                <div class="media">
                                    <label>Birthday</label>
                                    <p>January 1, 1990</p>
                                </div>
                                <div class="media">
                                    <label>Age</label>
                                    <p>31 Yr</p>
                                </div>
                                <div class="media">
                                    <label>Address</label>
                                    <p>123 Main St, Anytown, USA</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="media">
                                    <label>E-mail</label>
                                    <p>email@example.com</p>
                                </div>
                                <div class="media">
                                    <label>Phone</label>
                                    <p>(123) 456-7890</p>
                                </div>
                                <div class="media">
                                    <label>Education</label>
                                    <p>University of Example</p>
                                </div>
                            </div>
                        </div>
                        <div class="row about-list">
                            <div class="col-md-12">
                                <div class="media">
                                    <label>Experiences</label>
                                    <p>Experience content goes here...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-avatar">
                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" title="" alt=""><br>
                    </div>
                    <div class="username">
                        <p>Username</p>
                    </div>
                    <a href="edit-profile.php" class="edit">Edit Profile</a>
                </div>
            </div>
            <div class="counter">
                <div class="row">
                    <div class="col-6 col-lg-3">
                    <div class="count-data text-center">
    <h6 class="count h2" data-to="500" data-speed="500">10</h6>
    <p class="m-0px font-w-600">Jobs Completed</p>
</div>
</div>
<div class="col-6 col-lg-3">
    <div class="count-data text-center">
        <h6 class="count h2" data-to="150" data-speed="150">100$</h6>
        <p class="m-0px font-w-600">Earnings</p>
    </div>
</div>
<div class="col-6 col-lg-3 wallet-section">
    <div class="count-data text-center">
        <h6 class="count h2" data-to="850" data-speed="850">$50</h6>
        <p class="m-0px font-w-600">Wallet</p>
    </div>
</div>
<div class="col-6 col-lg-3">
    <div class="count-data text-center">
        <h6 class="count h2" data-to="190" data-speed="190">Sales</h6>
        <p class="m-0px font-w-600">View sales</p>
    </div>
</div>
</div>
</div>
</div>

<!-- Wallet Modal -->
<div class="modal fade" id="walletModal" tabindex="-1" aria-labelledby="walletModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="walletModalLabel">Wallet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Your current balance is: <span id="walletBalance"></span>$</p>
                <form id="cashInForm">
                    <div class="mb-3">
                        <label for="cashInAmount" class="form-label">Cash In Amount</label>
                        <input type="number" class="form-control" id="cashInAmount" name="cash_in_amount" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Cash In</button>
                </form>
                <div id="cashInMessage" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  
 

    
        
   
</body>

</html>