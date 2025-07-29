<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Arya | Empowering Growth</title>

    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">
    <link rel="shortcut icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.jpg') }}">

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-white text-gray-800 antialiased">

    <!-- Header -->
    <header class="bg-gray-100 shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-6 flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-900">Arya</h1>
            <nav>
                <a href="#about" class="text-gray-700 hover:text-green-600 mx-4">About</a>
                <a href="#features" class="text-gray-700 hover:text-green-600 mx-4">Features</a>
                <a href="#contact" class="text-gray-700 hover:text-green-600 mx-4">Contact</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-green-50 py-20">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl font-bold mb-4 text-green-700">Welcome to Arya</h2>
            <p class="text-lg text-gray-700 mb-6">Empowering entrepreneurs, investors, and innovators to connect and grow.</p>
            <a href="#about" class="bg-green-600 text-white px-6 py-3 rounded-lg text-lg hover:bg-green-700 transition">
                Learn More
            </a>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 bg-white">
        <div class="max-w-5xl mx-auto px-4 text-center">
            <h3 class="text-3xl font-semibold text-gray-900 mb-4">What is Arya?</h3>
            <p class="text-gray-600 text-lg">Arya is a platform that brings together entrepreneurs (mentees), investors, and BDSPs to collaborate, grow businesses, and drive innovation in Africa and beyond.</p>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4">
            <h3 class="text-3xl font-semibold text-center text-gray-900 mb-10">Core Features</h3>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-6 shadow rounded-lg text-center">
                    <h4 class="text-xl font-bold mb-2 text-green-600">Investor Matching</h4>
                    <p class="text-gray-600">Find the right investor for your business idea or startup easily.</p>
                </div>
                <div class="bg-white p-6 shadow rounded-lg text-center">
                    <h4 class="text-xl font-bold mb-2 text-green-600">Business Mentorship</h4>
                    <p class="text-gray-600">Access expert guidance and mentorship from certified BDSPs.</p>
                </div>
                <div class="bg-white p-6 shadow rounded-lg text-center">
                    <h4 class="text-xl font-bold mb-2 text-green-600">Growth Tools</h4>
                    <p class="text-gray-600">Use our tools to track your business growth and impact.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="bg-green-600 py-12 text-center text-white">
        <h3 class="text-3xl font-semibold mb-4">Ready to Join Arya?</h3>
        <p class="mb-6 text-lg">Create an account today and connect with a network of success-driven professionals.</p>
        <a href="{{ route('register.role') }}" class="bg-white text-green-700 font-semibold px-6 py-3 rounded-lg hover:bg-gray-100 transition">
            Get Started
        </a>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-100 text-center py-6 mt-8">
        <p class="text-gray-600">&copy; {{ date('Y') }} Arya. All rights reserved.</p>
    </footer>

</body>
</html>
