<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard - BizConsult</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Navbar -->
    <header class="bg-gray-900 bg-opacity-80 fixed top-0 left-0 w-full z-20">
        <div class="container mx-auto flex justify-between items-center p-4">
            <a href="{{ route('dashboard.customer') }}" class="flex items-center pl-6">
                <img src="{{ asset('images/Bizcon.png') }}" alt="Biz Consult Logo" class="h-14 w-auto">
            </a>
            <nav class="flex items-center space-x-6 pr-6 text-gray-300">
                <a href="{{ route('logout') }}" class="hover:text-white">Logout</a>
            </nav>
        </div>
    </header>

    <!-- Dashboard Content -->
    <main class="min-h-screen pt-32 px-6">
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-md">

            <!-- Flash Message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <h1 class="text-4xl font-bold mb-4">Welcome to Your Customer Dashboard</h1>
            <p class="text-lg text-gray-700 mb-6">Hello, {{ Auth::user()->name }}! Here you can browse services, view bookings, and manage your profile.</p>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-blue-600">0</div>
                    <div class="text-sm text-blue-800">Active Bookings</div>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-green-600">0</div>
                    <div class="text-sm text-green-800">Completed Sessions</div>
                </div>
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-purple-600">0</div>
                    <div class="text-sm text-purple-800">Consultants Available</div>
                </div>
            </div>

            <!-- Main Widgets -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold">Browse Services</h2>
                    </div>
                    <p class="text-gray-600 mb-4">Explore available consulting services tailored for your business needs.</p>
                    <a href="#" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition">
                        View All Services
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold">Your Bookings</h2>
                    </div>
                    <p class="text-gray-600 mb-4">Check upcoming and past appointments with consultants.</p>
                    <a href="#" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition">
                        View Bookings
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Available Consultants Preview -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold mb-4">Featured Consultants</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                        <div class="flex items-center mb-2">
                            <div class="w-8 h-8 bg-gray-300 rounded-full mr-3"></div>
                            <div>
                                <div class="font-medium">Marketing Expert</div>
                                <div class="text-sm text-gray-600">5.0 ⭐ (12 reviews)</div>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">Specializes in digital marketing and brand strategy</p>
                        <button class="text-blue-600 text-sm hover:underline">View Profile</button>
                    </div>
                    
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                        <div class="flex items-center mb-2">
                            <div class="w-8 h-8 bg-gray-300 rounded-full mr-3"></div>
                            <div>
                                <div class="font-medium">Finance Consultant</div>
                                <div class="text-sm text-gray-600">4.9 ⭐ (8 reviews)</div>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">Expert in financial planning and investment strategies</p>
                        <button class="text-blue-600 text-sm hover:underline">View Profile</button>
                    </div>
                    
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                        <div class="flex items-center mb-2">
                            <div class="w-8 h-8 bg-gray-300 rounded-full mr-3"></div>
                            <div>
                                <div class="font-medium">IT Specialist</div>
                                <div class="text-sm text-gray-600">4.8 ⭐ (15 reviews)</div>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">Technology solutions and digital transformation</p>
                        <button class="text-blue-600 text-sm hover:underline">View Profile</button>
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <a href="#" class="text-blue-600 hover:underline">View All Consultants →</a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 bg-opacity-80 text-gray-300 py-6 text-center mt-12">
        <p>&copy; {{ date('Y') }} BizConsult. All rights reserved.</p>
    </footer>

</body>
</html>

