<!-- resources/views/services.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services - BizConsult</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Navbar -->
    <header class="bg-gray-900 bg-opacity-80 fixed top-0 left-0 w-full z-20">
        <div class="container mx-auto flex justify-between items-center p-4">
            <a href="{{ route('home') }}" class="flex items-center pl-6">
                <img src="{{ asset('images/Bizcon.png') }}" 
                     alt="Biz Consult Logo" 
                     class="h-14 w-auto">
            </a>
            <nav class="flex items-center space-x-6 pr-6 text-gray-300">
                <div class="flex space-x-6">
                    <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                    <a href="{{ route('about') }}" class="hover:text-white">About Us</a>
                    <a href="{{ route('services') }}" class="hover:text-white">Services</a>
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

    <!-- Full Page Background -->
    <main 
        class="relative bg-cover bg-center text-white min-h-screen pt-24 flex flex-col justify-between"
        style="background-image: url('{{ asset('images/background.png') }}');">

        <!-- Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-50 z-0"></div>

        <!-- Services Content -->
        <div class="relative z-10 flex flex-col items-center text-center px-6 py-20">
            <h2 class="text-4xl font-bold mb-6">Our Services</h2>
            <p class="text-lg mb-12 max-w-2xl">
                Discover the wide range of professional services we offer to help your business grow.
            </p>

            <!-- Service Cards -->
            <div class="grid md:grid-cols-3 gap-8 w-full max-w-6xl">
                <div class="bg-white p-6 rounded-lg shadow text-gray-900">
                    <h3 class="text-xl font-semibold mb-3">Consulting</h3>
                    <p>Expert advice tailored to your business strategy, operations, and growth.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow text-gray-900">
                    <h3 class="text-xl font-semibold mb-3">Market Analysis</h3>
                    <p>In-depth research and analysis to guide your decisions in competitive markets.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow text-gray-900">
                    <h3 class="text-xl font-semibold mb-3">Project Management</h3>
                    <p>Full lifecycle project planning and execution support from start to finish.</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="relative z-10 bg-gray-900 bg-opacity-80 text-gray-300 py-6 text-center">
            <p>&copy; {{ date('Y') }} BizConsult. All rights reserved.</p>
        </footer>
    </main>

</body>
</html>
