<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Arya Landing Page</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <header style="background-color: #f0f0f0; padding: 20px; text-align: center;">
            <h1>Welcome to Our New Landing Page</h1>
        </header>

        <main style="padding: 20px; text-align: center;">
            <p>This is a brand new landing page for Arya.</p>
            <p>We are excited to show you what's coming next!</p>
            <button style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; cursor: pointer; font-size: 16px;">Learn More</button>
        </main>

        <footer style="background-color: #f0f0f0; padding: 20px; text-align: center; position: fixed; bottom: 0; width: 100%;">
            <p>&copy; {{ date('Y') }} Arya. All rights reserved.</p>
        </footer>
    </body>
</html>