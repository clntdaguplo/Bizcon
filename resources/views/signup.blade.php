<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - BizConsult</title>
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

    <!-- Sign Up Section -->
    <main class="min-h-screen pt-24 relative bg-cover bg-center flex items-center justify-center px-4"
          style="background-image: url('{{ asset('images/background.png') }}');">

        <!-- Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-50 z-0"></div>

        <!-- Sign Up Form -->
        <div class="relative z-10 w-full max-w-md bg-white bg-opacity-30 backdrop-blur-md p-8 rounded-xl shadow-xl border border-white border-opacity-20">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-6">Create Your Account</h2>
            
            <form action="#" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="name" id="name" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-400">
                </div>

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

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-400">
                </div>

                <!-- Default Sign Up Button -->
                <button type="submit"
                        class="w-full py-2 px-4 bg-gray-900 text-white rounded-lg font-semibold hover:bg-gray-800 transition">
                    Sign Up
                </button>

                <!-- Divider -->
                <div class="flex items-center my-6">
                    <div class="flex-grow border-t border-gray-300"></div>
                    <span class="mx-4 text-Blue-500 text-sm">or sign up with</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>

                <!-- Social Sign Up Buttons -->
                <div class="space-y-3">
                    <a href="#"
                       class="flex items-center justify-center w-full py-2 px-4 border border-gray-300 rounded-lg bg-white hover:bg-gray-100 transition">
                        <img src="{{ asset('images/google.png') }}" alt="Google Logo" class="h-5 w-5 mr-2">
                        <span class="text-gray-700 font-medium">Sign up with Google</span>
                    </a>
                    <a href="#"
                       class="flex items-center justify-center w-full py-2 px-4 border border-gray-300 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                        <img src="{{ asset('images/facebook.png') }}" alt="Facebook Logo" class="h-5 w-5 mr-2">
                        <span class="font-medium">Sign up with Facebook</span>
                    </a>
                </div>
            </form>

            <p class="text-center text-sm text-gray-700 mt-6">
                Already have an account?
                <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Log In</a>
            </p>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 bg-opacity-80 text-gray-300 py-6 text-center">
        <p>&copy; {{ date('Y') }} BizConsult. All rights reserved.</p>
    </footer>

</body>
</html>
