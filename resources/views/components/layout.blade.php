<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recyclo - Recycle and Earn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Add any additional CSS or JS resources needed -->
</head>
<body>
    <header>
        <!-- Header content can go here -->
    </header>
    
    <main>
        @yield('content')
    </main>
    
    <footer>
        <!-- Footer content can go here -->
    </footer>
    
    <!-- Include Ionicons for the icons used in the landing page -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>