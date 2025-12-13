<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultant Verification - BizConsult</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-gray-900">

    <!-- Navbar -->
    <header class="bg-gray-900 bg-opacity-80 fixed top-0 left-0 w-full z-20">
        <div class="container mx-auto flex justify-between items-center p-4">
            <a href="{{ route('home') }}" class="flex items-center pl-6">
                <img src="{{ asset('images/Bizcon.png') }}" 
                     alt="Biz Consult Logo" 
                     class="h-14 w-auto">
            </a>
            <nav class="flex items-center space-x-6 pr-6 text-gray-300">
                <a href="{{ route('logout') }}" class="hover:text-white">Logout</a>
            </nav>
        </div>
    </header>

    <!-- Verification Form Section -->
    <main
        class="min-h-screen pt-24 relative flex items-center justify-center px-4 bg-cover bg-center"
        style="background-image: url('{{ asset('images/background.png') }}');">

        <!-- Verification Form -->
        <div class="relative z-10 w-full max-w-2xl bg-slate-900/60 backdrop-blur-xl p-8 rounded-2xl shadow-2xl border border-slate-700/60">
            <div class="text-center mb-6">
                <h2 class="text-3xl font-bold text-white mb-2">Consultant Verification</h2>
                <p class="text-gray-300">Please submit your information to become a verified consultant</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 bg-red-900/50 border border-red-500 text-red-100 px-4 py-3 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-4 bg-green-900/50 border border-green-500 text-green-100 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ url('/consultant/verify') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Address -->
                <div>
                    <label for="address" class="block text-white font-medium mb-2">Address *</label>
                    <input type="text" 
                           id="address" 
                           name="address" 
                           value="{{ old('address') }}"
                           required
                           maxlength="255"
                           class="w-full px-4 py-3 bg-slate-800/50 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Enter your full address">
                </div>

                <!-- Age -->
                <div>
                    <label for="age" class="block text-white font-medium mb-2">Age *</label>
                    <input type="number" 
                           id="age" 
                           name="age" 
                           value="{{ old('age') }}"
                           required
                           min="18"
                           max="120"
                           class="w-full px-4 py-3 bg-slate-800/50 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Enter your age">
                </div>

                <!-- Sex -->
                <div>
                    <label for="sex" class="block text-white font-medium mb-2">Sex *</label>
                    <select id="sex" 
                            name="sex" 
                            required
                            class="w-full px-4 py-3 bg-slate-800/50 border border-slate-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select your sex</option>
                        <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('sex') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <!-- Resume Upload -->
                <div>
                    <label for="resume" class="block text-white font-medium mb-2">Resume *</label>
                    <input type="file" 
                           id="resume" 
                           name="resume" 
                           required
                           accept=".pdf,.doc,.docx"
                           class="w-full px-4 py-3 bg-slate-800/50 border border-slate-600 rounded-lg text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-500 file:text-white hover:file:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="mt-2 text-sm text-gray-400">Accepted formats: PDF, DOC, DOCX (Max: 5MB)</p>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-slate-900">
                    Submit Verification Request
                </button>

                <div class="text-center">
                    <a href="{{ route('dashboard.consultant') }}" class="text-gray-300 hover:text-white text-sm underline">
                        Cancel and return to dashboard
                    </a>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 bg-opacity-80 text-gray-300 py-6 text-center mt-12">
        <p>&copy; {{ date('Y') }} BizConsult. All rights reserved.</p>
    </footer>

</body>
</html>

