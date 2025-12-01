<!-- resources/views/home.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BizConsult</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Navbar -->
    <header class="bg-gray-900 bg-opacity-80 fixed top-0 left-0 w-full z-20">
        <div class="container mx-auto flex justify-between items-center p-4">
            
            <!-- Brand Logo -->
            <a href="#home" class="flex items-center pl-6">
                <img src="{{ asset('images/Bizcon.png') }}" 
                     alt="Biz Consult Logo" 
                     class="h-14 w-auto">
            </a>

            <!-- Navigation -->
            <nav class="flex items-center space-x-6 pr-6 text-gray-300">
                <div class="flex space-x-6">
                    <a href="#home" class="hover:text-white transition duration-300">Home</a>
                    <a href="#services" class="hover:text-white transition duration-300">Services</a>
                    <a href="#about" class="hover:text-white transition duration-300">About Us</a>
                    <a href="{{ route('consultants') }}" class="hover:text-white transition duration-300">Our Consultants</a>
                </div>

                <span class="mx-2 border-l border-gray-500 h-6"></span>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" 
                        class="px-4 py-2 border border-gray-300 text-gray-300 rounded-lg font-medium hover:bg-gray-300 hover:text-gray-900 transition">
                        Log In
                    </a>

                    <a href="{{ route('signup') }}" 
                    class="px-4 py-2 bg-gray-300 text-gray-900 rounded-lg font-medium hover:bg-white transition">
                    Sign Up
                    </a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Home Section -->
    <section id="home" class="relative bg-cover bg-center text-white min-h-screen flex items-center"
        style="background-image: url('{{ asset('images/background.png') }}');">
        
        <!-- Dark overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>

        <!-- Hero Content -->
        <div class="relative z-10 container mx-auto text-center px-6">
            <h1 class="text-5xl font-bold mb-6">Welcome to BizConsult</h1>
            <p class="text-xl mb-8 max-w-3xl mx-auto">Your trusted partner for business consulting and professional services. We help businesses grow, innovate, and achieve their goals through expert guidance and strategic planning.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#services" class="bg-white text-gray-900 px-8 py-4 rounded-lg font-semibold shadow-lg hover:bg-gray-100 transition duration-300">
                    Our Services
                </a>
                <a href="{{ route('signup') }}" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-gray-900 transition duration-300">
                    Get Started
                </a>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Services</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Explore the core service areas where our consultants can support your growth.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Technology & IT Support -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-3-3v6m9-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Technology & IT Support</h3>
                    <p class="text-gray-600 mb-6">Secure, stable, and scalable IT support to keep your tools, data, and systems running smoothly.</p>
                    <ul class="text-gray-600 space-y-2">
                        <li>• Infrastructure & system setup</li>
                        <li>• Cybersecurity & data protection</li>
                        <li>• Day-to-day technical support</li>
                    </ul>
                </div>

                <!-- E-commerce Business -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M3 7h18M5 11h14l-1.5 7h-11L5 11z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">E-commerce Business</h3>
                    <p class="text-gray-600 mb-6">From setup to scaling, get support to turn your online store into a reliable revenue channel.</p>
                    <ul class="text-gray-600 space-y-2">
                        <li>• Store setup & optimization</li>
                        <li>• Product catalog & pricing strategy</li>
                        <li>• Conversion & checkout improvements</li>
                    </ul>
                </div>

                <!-- Marketing Business -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5a1 1 0 011-1h7m0 0v7m0-7L11 16l-4-4-4 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Marketing Business</h3>
                    <p class="text-gray-600 mb-6">Build your brand, reach the right audience, and turn attention into measurable results.</p>
                    <ul class="text-gray-600 space-y-2">
                        <li>• Brand & campaign strategy</li>
                        <li>• Digital & social marketing</li>
                        <li>• Customer acquisition planning</li>
                    </ul>
                </div>

                <!-- Education & Career Coaching -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-orange-100 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v7"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Education & Career Coaching</h3>
                    <p class="text-gray-600 mb-6">Plan your next step with expert guidance on education paths and career opportunities.</p>
                    <ul class="text-gray-600 space-y-2">
                        <li>• Career & course guidance</li>
                        <li>• Skills and growth planning</li>
                        <li>• Interview & CV coaching</li>
                    </ul>
                </div>

                <!-- Financial Business -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-red-100 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .843-3 2.5S10.343 13 12 13s3 .843 3 2.5S13.657 18 12 18m0-10V4m0 14v2"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Financial Business</h3>
                    <p class="text-gray-600 mb-6">Gain clarity and control over your numbers with structured financial support.</p>
                    <ul class="text-gray-600 space-y-2">
                        <li>• Budgeting & cashflow review</li>
                        <li>• Financial planning & analysis</li>
                        <li>• Compliance & reporting guidance</li>
                    </ul>
                </div>

            </div>
        </div>
            </section>

    <!-- About Us Section -->
    <section id="about" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">About Us</h2>
                    <p class="text-xl text-gray-600">Your trusted partner in business excellence</p>
                </div>

                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-6">Who We Are</h3>
                        <p class="text-lg text-gray-600 mb-6">
                            BizConsult is a leading business consulting firm dedicated to helping organizations achieve their full potential. With years of experience and a team of expert consultants, we provide comprehensive solutions tailored to your unique business needs.
                        </p>
                        <p class="text-lg text-gray-600 mb-8">
                            Our mission is to empower businesses with strategic insights, innovative solutions, and actionable recommendations that drive sustainable growth and long-term success.
                        </p>
                        
                        <div class="grid grid-cols-2 gap-6">
                            <div class="text-center">
                                
                            </div>
                            <div class="text-center">
                               
                            </div>
                            <div class="text-center">
                                
                            </div>
                            <div class="text-center">
                                
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-xl shadow-lg">
                        <h4 class="text-2xl font-semibold text-gray-900 mb-6">Our Values</h4>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-4 mt-1">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="font-semibold text-gray-900">Excellence</h5>
                                    <p class="text-gray-600">We strive for the highest standards in everything we do.</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-4 mt-1">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="font-semibold text-gray-900">Integrity</h5>
                                    <p class="text-gray-600">We maintain the highest ethical standards in all our interactions.</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-4 mt-1">
                                    <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="font-semibold text-gray-900">Innovation</h5>
                                    <p class="text-gray-600">We embrace new ideas and cutting-edge solutions.</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center mr-4 mt-1">
                                    <svg class="w-4 h-4 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="font-semibold text-gray-900">Collaboration</h5>
                                    <p class="text-gray-600">We work closely with our clients as trusted partners.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    </div>
                </div>
            </section>

            <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-16">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-8">
                <!-- BizConsult Intro -->
                <div>
                    <h3 class="text-2xl font-semibold text-white mb-4">BizConsult</h3>
                    <p class="text-gray-300 leading-relaxed max-w-md">
                        Your trusted partner for business consulting and professional services. 
                        We help businesses grow, innovate, and achieve their goals through expert guidance, 
                        strategic planning, and practical, results-driven solutions.
                    </p>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-xl font-semibold text-white mb-6">CONTACT US</h3>
                    <ul class="space-y-3">
                        <li><a href="mailto:bizconsult@gmail.com" class="hover:text-white transition duration-300">bizconsult@gmail.com</a></li>
                        <li><span class="hover:text-white transition duration-300">Uc Main Sancianqko St, Avocado Bldg, 5th Floor</span></li>
                        <li><span class="hover:text-white transition duration-300">Cebu City</span></li>
                        <li><a href="tel:+09123456789" class="hover:text-white transition duration-300">+0912 345 6789</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-12 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center mb-4 md:mb-0">
                        <img src="{{ asset('images/Bizcon.png') }}" alt="BizConsult Logo" class="h-10 w-auto mr-4">
                        <span class="text-white font-semibold">BizConsult</span>
                    </div>
                    <div class="text-center md:text-right">
                <p>&copy; {{ date('Y') }} BizConsult. All rights reserved.</p>
                        <p class="text-sm mt-2">Empowering businesses through expert consulting services.</p>
                    </div>
                </div>
            </div>
        </div>
            </footer>

</body>
</html>
