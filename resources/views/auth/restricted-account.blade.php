<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Restricted - Recyclo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --hoockers-green: #517A5B;
            --hoockers-green_80: #517A5Bcc;
        }
        
        body {
            font-family: 'Urbanist', sans-serif;
            background-color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .restricted-container {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            max-width: 500px;
            width: 90%;
            text-align: center;
        }

        .restricted-icon {
            font-size: 4rem;
            color: #dc3545;
            margin-bottom: 1rem;
        }

        .restricted-title {
            color: #dc3545;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .restricted-message {
            color: #666;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .contact-support {
            color: var(--hoockers-green);
            text-decoration: none;
            font-weight: 500;
        }

        .contact-support:hover {
            color: var(--hoockers-green_80);
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="restricted-container">
        <div class="restricted-icon">
            <i class="bi bi-shield-lock"></i>
        </div>
        <h1 class="restricted-title">Account Restricted</h1>
        <p class="restricted-message">
            Your account has been restricted by the administrator. This action may have been taken due to violations of our terms of service or community guidelines.
        </p>
        <p class="restricted-message">
            If you believe this is a mistake or would like to appeal this decision, please contact our support team with the following information:
        </p>
        <div class="support-info mb-4">
            <ul class="list-unstyled text-start">
                <li><i class="bi bi-envelope me-2"></i>Email: jamzmeel@gmail.com</li>
                <li><i class="bi bi-clock me-2"></i>Response Time: Within 24-48 hours</li>
                <li><i class="bi bi-info-circle me-2"></i>Please include your account email and reason for appeal</li>
            </ul>
        </div>
        <div class="support-actions">
            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=jamzmeel@gmail.com" target="_blank" class="btn btn-primary me-2">
                <i class="bi bi-envelope me-2"></i>Contact Support
            </a>
            <a href="/" class="btn btn-outline-secondary">
                <i class="bi bi-house me-2"></i>Return Home
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html> 