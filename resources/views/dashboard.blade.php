<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - BizConsult</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Navbar -->
    <header class="bg-gray-900 bg-opacity-80 fixed top-0 left-0 w-full z-20">
        <div class="container mx-auto flex justify-between items-center p-4">
            <a href="{{ route('dashboard') }}" class="flex items-center pl-6">
                <img src="{{ asset('images/Bizcon.png') }}" alt="Biz Consult Logo" class="h-14 w-auto">
            </a>
            <nav class="flex items-center space-x-6 pr-6 text-gray-300">
                
                <a href="{{ route('logout') }}" class="hover:text-white">Logout</a>
            </nav>
        </div>
    </header>

    <!-- Dashboard Content -->
    <main class="min-h-screen pt-32 px-6">
        @if(is_null(Auth::user()->role))
            <!-- Role Selection Modal -->
            <div id="role-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                <div class="bg-white p-8 rounded-xl shadow-xl w-full max-w-md relative">
                    <h2 class="text-2xl font-bold mb-6 text-center">Select Your Role</h2>
                    <form method="POST" action="{{ route('role.save') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">Choose your role:</label>
                            <select name="role" class="w-full px-3 py-2 border rounded" required>
                                <option value="" disabled selected>Select a role</option>
                                <option value="Customer">Customer</option>
                                <option value="Consultant">Consultant</option>
                            </select>
                            @error('role')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">Save Role</button>
                    </form>
                </div>
            </div>
        @endif
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-md">

            <!-- Flash Message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <h1 class="text-4xl font-bold mb-4">Welcome to Your Dashboard</h1>
            <p class="text-lg text-gray-700 mb-6">Hello, {{ Auth::user()->name }}! Here's your personalized space.</p>

            <!-- Placeholder for widgets -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 shadow-sm">
                    <h2 class="text-xl font-semibold mb-2">Your Stats</h2>
                    <p class="text-gray-600">Coming soon: user activity, performance, and more.</p>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 shadow-sm">
                    <h2 class="text-xl font-semibold mb-2">Quick Links</h2>
                    <ul class="list-disc list-inside text-gray-600">
                        <li><a href="#" class="text-blue-500 hover:underline">Edit Profile</a></li>
                        <li><a href="#" class="text-blue-500 hover:underline">View Reports</a></li>
                        <li><a href="#" class="text-blue-500 hover:underline">Settings</a></li>
                    </ul>
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