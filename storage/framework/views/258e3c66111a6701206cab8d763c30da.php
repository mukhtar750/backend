<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AWN Venture Ready Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #b81d8f;
            --primary-light: #e8a4d5;
            --dark: #333333;
            --light: #f8f9fa;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            scroll-behavior: smooth;
        }
        
        .btn-primary {
            background-color: var(--primary);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: #9e1878;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -10px var(--primary);
        }
        
        .feature-card {
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(184, 29, 143, 0.2);
        }
        
        .testimonial-card {
            transition: all 0.3s ease;
        }
        
        .testimonial-card:hover {
            transform: scale(1.02);
        }
        
        .hero-section {
            background: linear-gradient(135deg, rgba(184, 29, 143, 0.1) 0%, rgba(255, 255, 255, 1) 100%);
        }
        
        .nav-link {
            position: relative;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: var(--primary);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 1s ease forwards;
        }
        
        .delay-1 { animation-delay: 0.2s; }
        .delay-2 { animation-delay: 0.4s; }
        .delay-3 { animation-delay: 0.6s; }
    </style>
</head>
<body class="bg-white text-gray-800">
    <!-- Navigation -->
<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
            <img src="/images/logo.jpg" alt="AWN Logo" class="w-14 h-14 object-contain rounded-full shadow-lg transition-transform hover:scale-105">
                    <div>
                <span class="text-xl font-semibold">AWN Venture Ready Portal</span>
    </div>
            
            <!-- Add nav links or buttons here on the right -->
        </div>          
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="menu-btn" class="text-gray-800 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#home" class="nav-link text-gray-800 hover:text-[#b81d8f]">Home</a>
                    <a href="#about" class="nav-link text-gray-800 hover:text-[#b81d8f]">About</a>
                    <a href="#features" class="nav-link text-gray-800 hover:text-[#b81d8f]">Features</a>
                    <a href="#testimonials" class="nav-link text-gray-800 hover:text-[#b81d8f]">Success Stories</a>
                    <a href="#contact" class="nav-link text-gray-800 hover:text-[#b81d8f]">Contact</a>
                    <a href="/register" class="ml-4 btn-primary text-white font-semibold px-6 py-2 rounded-full shadow hover:bg-[#9e1878] transition-all">Get Started</a>
                </div>
            </div>
            
            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden mt-4">
                <a href="#home" class="block py-2 text-gray-800 hover:text-[#b81d8f]">Home</a>
                <a href="#about" class="block py-2 text-gray-800 hover:text-[#b81d8f]">About</a>
                <a href="#features" class="block py-2 text-gray-800 hover:text-[#b81d8f]">Features</a>
                <a href="#testimonials" class="block py-2 text-gray-800 hover:text-[#b81d8f]">Success Stories</a>
                <a href="#contact" class="block py-2 text-gray-800 hover:text-[#b81d8f]">Contact</a>
                <a href="/register" class="block mt-4 btn-primary text-white font-semibold px-6 py-2 rounded-full text-center">Get Started</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section py-20 md:py-32">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-12 md:mb-0 fade-in">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-800 leading-tight mb-6">
                        AWN  <br/><span class="text-[#b81d8f]">Venture Ready </span><br/>Portal
                    </h1>
                    <h2 class="text-2xl md:text-3xl text-gray-600 mb-6 delay-1 fade-in">
                        Your Gateway to Venture Success
                    </h2>
                    <p class="text-lg text-gray-600 mb-8 delay-2 fade-in">
                        Empowering female-led ventures through capacity building and investor access
                    </p>
                    <a href="<?php echo e(route('register.role')); ?>" class="btn-primary text-white font-semibold px-8 py-3 rounded-full delay-3 fade-in">
                        Get Started
                    </a>
                </div>
                <div class="md:w-1/2 fade-in delay-3">
                    <!-- AWN Team Photo -->
                    <img src="/images/awn.jpg" alt="AWN Team - Venture Ready Portal" class="rounded-lg shadow-xl w-full h-auto object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-12 md:mb-0">
                    <img src="/images/about.jpg" alt="About AWN" 
                         class="rounded-lg shadow-lg w-full h-auto object-cover">
                </div>
                <div class="md:w-1/2 md:pl-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">
                        Our <span class="text-[#b81d8f]">Mission</span>
                    </h2>
                    <p class="text-lg text-gray-600 mb-6">
                    At Arya Women Nigeria (AWN) our mission is to empower women-led ventures by providing a structured and supportive environment for business growth and investment readiness. Through a blend of initiatives including training, mentoring, peer learning, and ecosystem building, we equip female founders with the skills, resources, and networks they need to succeed.
                    </p>
                    <p class="text-lg text-gray-600 mb-8">
                    The AWN Venture Ready Portal is a key tool in this mission: a centralized, interactive platform that helps entrepreneurs navigate their investment journey with clarity and confidence. By connecting them to expert Business Development Support Providers (BDSPs), curated resources, and investor access, we're bridging the gap between potential and opportunity; building a future where women-led businesses can thrive, scale, and lead lasting impact.
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-[#b81d8f] flex items-center justify-center text-white mr-4">
                            <i class="fas fa-venus text-xl"></i>
                        </div>
                        <p class="text-gray-600 font-medium">
                            Empowering women to lead in business and innovation
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">
                    How We <span class="text-[#b81d8f]">Support</span> You
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Comprehensive resources designed specifically for female entrepreneurs
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card bg-white p-8 rounded-xl shadow-md text-center hover:border-l-4 hover:border-[#b81d8f]">
                    <div class="w-20 h-20 bg-[#f8e0f0] rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-graduation-cap text-[#b81d8f] text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Capacity Building</h3>
                    <p class="text-gray-600">
                        Access to tailored training programs, workshops, and mentorship to develop essential entrepreneurial skills.
                    </p>
                </div>
                
                <!-- Feature 2 -->
                <div class="feature-card bg-white p-8 rounded-xl shadow-md text-center hover:border-l-4 hover:border-[#b81d8f]">
                    <div class="w-20 h-20 bg-[#f8e0f0] rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-hand-holding-usd text-[#b81d8f] text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Investor Access</h3>
                    <p class="text-gray-600">
                        Direct connections to a network of investors specifically interested in supporting women-led ventures.
                    </p>
                </div>
                
                <!-- Feature 3 -->
                <div class="feature-card bg-white p-8 rounded-xl shadow-md text-center hover:border-l-4 hover:border-[#b81d8f]">
                    <div class="w-20 h-20 bg-[#f8e0f0] rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users text-[#b81d8f] text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Community Support</h3>
                    <p class="text-gray-600">
                        Join a vibrant community of like-minded female entrepreneurs for collaboration and peer learning.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">
                    Success <span class="text-[#b81d8f]">Stories</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Hear from women who have transformed their ventures through our portal
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="testimonial-card bg-white p-8 rounded-xl shadow-md">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mr-4">
                            <i class="fas fa-leaf text-green-600 text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold">Amina Johnson</h4>
                            <p class="text-gray-500 text-sm">Founder, GreenTech Solutions</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">
                        "The investor connections I made through AWN were game-changing. Within 6 months, I secured funding that allowed me to scale my clean energy startup."
                    </p>
                    <div class="mt-4 text-[#b81d8f]">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="testimonial-card bg-white p-8 rounded-xl shadow-md">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                            <i class="fas fa-heartbeat text-blue-600 text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold">Sarah Chen</h4>
                            <p class="text-gray-500 text-sm">CEO, HealthBridge Africa</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">
                        "The mentorship program helped me refine my business model and go-to-market strategy. I've doubled my revenue since joining the portal."
                    </p>
                    <div class="mt-4 text-[#b81d8f]">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="testimonial-card bg-white p-8 rounded-xl shadow-md">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 rounded-full bg-yellow-100 flex items-center justify-center mr-4">
                            <i class="fas fa-seedling text-yellow-600 text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold">Fatima Ndiaye</h4>
                            <p class="text-gray-500 text-sm">Founder, AgriWomen Co-op</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">
                        "Being part of this community gave me the confidence to expand my agricultural cooperative. The peer support is invaluable."
                    </p>
                    <div class="mt-4 text-[#b81d8f]">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="contact" class="py-20 bg-[#b81d8f] text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to grow your venture?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Join hundreds of women entrepreneurs who are transforming their businesses through the AWN Venture Readiness Portal.
            </p>
            <a href="<?php echo e(route('register.role')); ?>" class="bg-white text-[#b81d8f] font-semibold px-8 py-3 rounded-full hover:bg-gray-100 hover:shadow-lg transition-all duration-300">
                Join Now
            </a>
            
            <div class="mt-12 flex justify-center space-x-6">
                <a href="#" class="text-white hover:text-gray-200 text-2xl">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="#" class="text-white hover:text-gray-200 text-2xl">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="text-white hover:text-gray-200 text-2xl">
                    <i class="fab fa-linkedin"></i>
                </a>
                <a href="#" class="text-white hover:text-gray-200 text-2xl">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <img src="/images/logo.jpg" alt="AWN Logo" class="w-14 h-14 object-contain rounded-full shadow-lg transition-transform hover:scale-105 mb-3">
                    <p class="text-gray-400">
                        Empowering female entrepreneurs to build successful, scalable ventures.
                    </p>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#home" class="text-gray-400 hover:text-white">Home</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-white">About</a></li>
                        <li><a href="#features" class="text-gray-400 hover:text-white">Features</a></li>
                        <li><a href="#testimonials" class="text-gray-400 hover:text-white">Success Stories</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Resources</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Blog</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">FAQs</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Events</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Mentorship</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact Us</h4>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <i class="fas fa-envelope text-gray-400 mr-2"></i>
                            <span class="text-gray-400">hello@aryawomennigeria.org</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone text-gray-400 mr-2"></i>
                            <span class="text-gray-400">+234-9122777758</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>
                            <span class="text-gray-400">31 Parakou Street, Wuse 2, Abuja, Nigeria</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
                <p>&copy; <?php echo e(date('Y')); ?> Arya Women Nigeria. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
                
                // Close mobile menu if open
                if (!mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                }
            });
        });
        
        // Scroll animation
        const fadeElements = document.querySelectorAll('.fade-in');
        
        const fadeInOnScroll = () => {
            fadeElements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const windowHeight = window.innerHeight;
                
                if (elementTop < windowHeight - 100) {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }
            });
        };
        
        // Initialize elements as invisible
        fadeElements.forEach(element => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(20px)';
        });
        
        // Run on load and scroll
        window.addEventListener('load', fadeInOnScroll);
        window.addEventListener('scroll', fadeInOnScroll);
    </script>
</body>
</html><?php /**PATH C:\Users\ABU-UMAR\Documents\GitHub\backend\resources\views/welcome.blade.php ENDPATH**/ ?>