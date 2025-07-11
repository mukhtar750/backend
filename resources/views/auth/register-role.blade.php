<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Who Are You? | Choose Your Path</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f9fafb; }
        .glow-hover:hover { box-shadow: 0 0 15px rgba(184, 29, 143, 0.3); transform: translateY(-5px); transition: all 0.3s ease; }
        .character-card { transition: all 0.3s ease; }
        .character-card:hover .character-tag { background-color: #b81d8f; color: white; }
        .abstract-shape { position: absolute; border-radius: 50%; opacity: 0.1; z-index: -1; }
        .shape-1 { width: 300px; height: 300px; background-color: #b81d8f; top: -100px; left: -100px; }
        .shape-2 { width: 200px; height: 200px; background-color: #b81d8f; bottom: -50px; right: -50px; }
        .shape-3 { width: 150px; height: 150px; background-color: #b81d8f; top: 50%; right: 10%; }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <!-- Logo Home Link Top Left -->
    <a href="/" class="absolute top-6 left-6 z-20 group" aria-label="Go to home">
        <img src="/images/logo.jpg" alt="AWN Logo" class="w-14 h-14 object-contain rounded-full shadow-lg transition-transform group-hover:scale-105">
    </a>
    <!-- Abstract background shapes -->
    <div class="abstract-shape shape-1"></div>
    <div class="abstract-shape shape-2"></div>
    <div class="abstract-shape shape-3"></div>
    <!-- Header -->
    <header class="py-8 px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-3">Step In. Define Your Role. Unlock Your Journey.
        </h1>
        <p class="text-xl md:text-2xl text-gray-600">Whether you're building, guiding, or investing, your journey starts here</p>
    </header>
    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- BDSP Card -->
            <div class="character-card bg-white rounded-xl shadow-md overflow-hidden glow-hover">
                <div class="relative h-64 bg-gradient-to-b from-purple-50 to-white flex items-center justify-center">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-40 h-40 rounded-full bg-purple-100 opacity-30"></div>
                    </div>
                    <div class="relative z-10">
                        <div class="w-32 h-32 mx-auto bg-white rounded-full shadow-lg flex items-center justify-center overflow-hidden">
                            <img src="https://bing.com/th/id/BCO.2f57dbc4-bc0d-41eb-9d56-58161cee45e7.png" alt="BDSP Professional" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="character-tag absolute -mt-8 ml-6 bg-white text-purple-800 font-semibold px-4 py-2 rounded-full shadow-md border border-purple-200">BDSP</div>
                    <div class="mt-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Business Growth Partner</h3>
                        <p class="text-gray-600 mb-4">Seasoned professionals who provide strategic guidance, mentorship, and technical support to help ventures grow and scale.</p>
                        <div class="flex items-center text-purple-600 mb-2"><i class="fas fa-tablet-alt mr-2"></i><span>Digital tools</span></div>
                        <div class="flex items-center text-purple-600 mb-2"><i class="fas fa-chart-line mr-2"></i><span>Strategic planning</span></div>
                        <div class="flex items-center text-purple-600"><i class="fas fa-handshake mr-2"></i><span>Professional network</span></div>
                    </div>
                    <a href="{{ route('register.bdsp') }}" class="mt-6 w-full bg-purple-100 hover:bg-purple-200 text-purple-800 font-medium py-2 px-4 rounded-lg transition duration-300 block text-center">Explore Path</a>
                </div>
            </div>
            <!-- Entrepreneur Card -->
            <div class="character-card bg-white rounded-xl shadow-md overflow-hidden glow-hover">
                <div class="relative h-64 bg-gradient-to-b from-pink-50 to-white flex items-center justify-center">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-40 h-40 rounded-full bg-pink-100 opacity-30"></div>
                    </div>
                    <div class="relative z-10">
                        <div class="w-32 h-32 mx-auto bg-white rounded-full shadow-lg flex items-center justify-center overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" alt="Entrepreneur" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="character-tag absolute -mt-8 ml-6 bg-white text-pink-800 font-semibold px-4 py-2 rounded-full shadow-md border border-pink-200">Entrepreneur</div>
                    <div class="mt-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Visionary Founder</h3>
                        <p class="text-gray-600 mb-4">Bold innovators transforming ideas into impactful businesses with passion, resilience, and purpose.</p>
                        <br/>
                        <div class="flex items-center text-pink-600 mb-2"><i class="fas fa-lightbulb mr-2"></i><span>Creative ideas</span></div>
                        <div class="flex items-center text-pink-600 mb-2"><i class="fas fa-rocket mr-2"></i><span>Startup growth</span></div>
                        <div class="flex items-center text-pink-600"><i class="fas fa-users mr-2"></i><span>Team building</span></div>
                    </div>
                    <a href="{{ route('register.entrepreneur') }}" class="mt-6 w-full bg-pink-100 hover:bg-pink-200 text-pink-800 font-medium py-2 px-4 rounded-lg transition duration-300 block text-center">Explore Path</a>
                </div>
            </div>
            <!-- Investor Card -->
            <div class="character-card bg-white rounded-xl shadow-md overflow-hidden glow-hover">
                <div class="relative h-64 bg-gradient-to-b from-blue-50 to-white flex items-center justify-center">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-40 h-40 rounded-full bg-blue-100 opacity-30"></div>
                    </div>
                    <div class="relative z-10">
                        <div class="w-32 h-32 mx-auto bg-white rounded-full shadow-lg flex items-center justify-center overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" alt="Investor" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="character-tag absolute -mt-8 ml-6 bg-white text-blue-800 font-semibold px-4 py-2 rounded-full shadow-md border border-blue-200">Investor</div>
                    <div class="mt-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Catalyst for Growth</h3>
                        <p class="text-gray-600 mb-4">Individuals or institutions who fuel promising ventures with capital, networks, and strategic insight to drive scalable success.</p>
                        <div class="flex items-center text-blue-600 mb-2"><i class="fas fa-chart-pie mr-2"></i><span>Market analysis</span></div>
                        <div class="flex items-center text-blue-600 mb-2"><i class="fas fa-search-dollar mr-2"></i><span>Opportunity spotting</span></div>
                        <div class="flex items-center text-blue-600"><i class="fas fa-piggy-bank mr-2"></i><span>Capital growth</span></div>
                    </div>
                    <a href="{{ route('register.investor') }}" class="mt-6 w-full bg-blue-100 hover:bg-blue-200 text-blue-800 font-medium py-2 px-4 rounded-lg transition duration-300 block text-center">Explore Path</a>
                </div>
            </div>
        </div>
    </main>
    <!-- Footer -->
    <footer class="bg-white py-8 px-4 sm:px-6 lg:px-8 border-t border-gray-200">
        <div class="container mx-auto text-center">
            <p class="text-gray-600 mb-4">Already part of us?
                <a href="{{ route('login') }}" class="inline-block ml-2 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-semibold py-3 px-8 rounded-full shadow-lg transition duration-300">Login Now</a>
            </p>
            <div class="mt-6 text-gray-500 text-sm">
                <p>© 2025 AWN. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <script>
        document.querySelectorAll('.character-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.querySelector('.character-tag').classList.add('transform', 'scale-110');
            });
            card.addEventListener('mouseleave', function() {
                this.querySelector('.character-tag').classList.remove('transform', 'scale-110');
            });
        });
        function animateShapes() {
            const shapes = document.querySelectorAll('.abstract-shape');
            shapes.forEach((shape, index) => {
                const speed = 0.0005 * (index + 1);
                let angle = 0;
                function moveShape() {
                    const x = Math.sin(angle) * 20;
                    const y = Math.cos(angle) * 20;
                    shape.style.transform = `translate(${x}px, ${y}px)`;
                    angle += speed;
                    requestAnimationFrame(moveShape);
                }
                moveShape();
            });
        }
        window.addEventListener('load', animateShapes);
    </script>
</body>
</html> 