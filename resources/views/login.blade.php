<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In - BizConsult</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Navbar -->
    <header class="bg-gray-900 bg-opacity-80 fixed top-0 left-0 w-full z-20">
        <div class="container mx-auto flex justify-between items-center p-4">
            <a href="{{ route('home') }}" class="flex items-center pl-6">
                <img src="{{ asset('images/Bizcon.png') }}" alt="Biz Consult Logo" class="h-14 w-auto">
            </a>
            <nav class="flex items-center space-x-6 pr-6 text-gray-300">
                <div class="flex space-x-6">
                    <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                    <a href="{{ route('services') }}" class="hover:text-white">Services</a>
                    <a href="{{ route('about') }}" class="hover:text-white">About Us</a>

                    <a href="{{ route('consultants') }}" class="hover:text-white transition duration-300">Our Consultants</a>
                </div>
                <span class="mx-2 border-l border-gray-500 h-6"></span>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="px-4 py-2 border border-gray-300 text-gray-300 rounded-lg font-medium hover:bg-gray-300 hover:text-gray-900 transition">Log In</a>
                    <a href="{{ route('signup') }}" class="px-4 py-2 bg-gray-300 text-gray-900 rounded-lg font-medium hover:bg-white transition">Sign Up</a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Login Section -->
    <main class="min-h-screen pt-24 relative bg-cover bg-center flex items-center justify-center px-4"
          style="background-image: url('{{ asset('images/background.png') }}');">

        <!-- Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-50 z-0"></div>

        <!-- Login Form -->
        <div class="relative z-10 w-full max-w-md bg-white bg-opacity-30 backdrop-blur-md p-8 rounded-xl shadow-xl border border-white border-opacity-20">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-6">Welcome Back</h2>

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" name="email" id="email" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-400">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-400">
                </div>

                <div class="flex items-center justify-between text-sm text-gray-600">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" class="rounded" name="remember">
                        <span>Remember me</span>
                    </label>
                    <a href="#" class="text-blue-500 hover:underline">Forgot Password?</a>
                </div>

                <button type="submit"
                        class="w-full py-2 px-4 bg-gray-900 text-white rounded-lg font-semibold hover:bg-gray-800 transition">
                    Log In
                </button>

               
            </form>

            <p class="text-center text-sm text-gray-700 mt-6">
                Don’t have an account?
                <a href="{{ route('signup') }}" class="text-blue-500 hover:underline">Sign Up</a>
            </p>
        </div>
    </main>

    <footer class="bg-gray-900 bg-opacity-80 text-gray-300 py-6 text-center">
        <p>&copy; {{ date('Y') }} BizConsult. All rights reserved.</p>
    </footer>

</body>
</html>