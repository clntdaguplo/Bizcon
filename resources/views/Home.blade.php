<!-- resources/views/home.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BizConsult</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Navbar -->
    <header class="bg-gray-900 bg-opacity-80 fixed top-0 left-0 w-full z-20">
        <div class="container mx-auto flex justify-between items-center p-4">
            
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center pl-6">
                <img src="{{ asset('images/Bizcon.png') }}" 
                     alt="Biz Consult Logo" 
                     class="h-14 w-auto">
            </a>

            <!-- Navigation -->
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
        class="relative bg-cover bg-center text-white min-h-screen"
        style="background-image: url('{{ asset('images/background.png') }}');">
        
        <!-- Dark overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>

        <!-- Page Content -->
        <div class="relative z-10 pt-24">

            <!-- Hero -->
            <section class="py-20 text-center">
                <h2 class="text-4xl font-bold mb-4">Welcome to BizConsult</h2>
                <p class="text-lg mb-6">This is your customizable home page. You can edit text, add links, or images easily.</p>
                <a href="{{ route('about') }}" class="bg-white text-gray-900 px-6 py-3 rounded-lg font-semibold shadow hover:bg-gray-100">
                    Learn More
                </a>
            </section>

            <!-- Features -->
            <section class="container mx-auto py-12 px-6">
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-white p-6 rounded-lg shadow text-gray-900">
                        <h3 class="text-xl font-semibold mb-3">Feature One</h3>
                        <p>Edit this section in <code>home.blade.php</code> to showcase your first feature or service.</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow text-gray-900">
                        <h3 class="text-xl font-semibold mb-3">Feature Two</h3>
                        <p>You can add text, images, or links here. Everything is editable.</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow text-gray-900">
                        <h3 class="text-xl font-semibold mb-3">Feature Three</h3>
                        <p>Customize this homepage to fit your project or business needs.</p>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <footer class="bg-gray-900 bg-opacity-80 text-gray-300 py-6 text-center">
                <p>&copy; {{ date('Y') }} BizConsult. All rights reserved.</p>
            </footer>

        </div>
    </main>

</body>
</html>
