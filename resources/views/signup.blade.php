<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - BizConsult</title>
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
                <div class="flex space-x-6">
                    <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                    <a href="{{ route('services') }}" class="hover:text-white">Services</a>
                    <a href="{{ route('about') }}" class="hover:text-white">About Us</a>
                   
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

    <!-- Sign Up Section -->
    <main
        class="min-h-screen pt-24 relative flex items-center justify-center px-4 bg-cover bg-center"
        style="background-image: url('{{ asset('images/background.png') }}');">

        <!-- Sign Up Form -->
        <div class="relative z-10 w-full max-w-md bg-slate-900/60 backdrop-blur-xl p-8 rounded-2xl shadow-2xl border border-slate-700/60">
            <div class="text-center mb-6">
                <h2 class="text-3xl font-bold text-white mb-2">Create your account</h2>
                <p class="text-sm text-slate-300">Join BizConsult to connect with expert consultants and manage your sessions.</p>
            </div>
            
            <form action="#" method="POST" class="space-y-5">
                @csrf

                <div class="space-y-1">
                    <label for="name" class="block text-sm font-medium text-slate-100">Full name</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A8 8 0 1118.88 6.196 8 8 0 015.12 17.804zM15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </span>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            required
                            autocomplete="name"
                            placeholder="John Doe"
                            class="block w-full rounded-xl border border-slate-600/60 bg-slate-900/70 pl-9 pr-3 py-2.5 text-sm text-slate-100 placeholder-slate-500 shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500/80 focus:border-sky-400 transition"
                        >
                    </div>
                </div>

                <div class="space-y-1">
                    <label for="email" class="block text-sm font-medium text-slate-100">Email address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m13-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            required
                            autocomplete="email"
                            placeholder="you@example.com"
                            class="block w-full rounded-xl border border-slate-600/60 bg-slate-900/70 pl-9 pr-3 py-2.5 text-sm text-slate-100 placeholder-slate-500 shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500/80 focus:border-sky-400 transition"
                        >
                    </div>
                </div>

                <div class="space-y-1">
                    <label for="password" class="block text-sm font-medium text-slate-100">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c.667 0 2-.4 2-2s-1.333-2-2-2-2 .4-2 2 1.333 2 2 2z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 19a10.36 10.36 0 0115 0" />
                            </svg>
                        </span>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            autocomplete="new-password"
                            placeholder="Create a strong password"
                            class="block w-full rounded-xl border border-slate-600/60 bg-slate-900/70 pl-9 pr-10 py-2.5 text-sm text-slate-100 placeholder-slate-500 shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500/80 focus:border-sky-400 transition"
                        >
                        <button type="button"
                                id="toggle-password"
                                class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-200 text-xs">
                            Show
                        </button>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">
                        Use at least 8 characters, with a mix of letters and numbers.
                    </p>
                </div>

                <div class="space-y-1">
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-100">Confirm password</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Repeat your password"
                        class="block w-full rounded-xl border border-slate-600/60 bg-slate-900/70 px-3 py-2.5 text-sm text-slate-100 placeholder-slate-500 shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500/80 focus:border-sky-400 transition"
                    >
                </div>

                <!-- Default Sign Up Button -->
                <button type="submit"
                        class="w-full py-2.5 px-4 bg-sky-500 text-white rounded-xl text-sm font-semibold shadow-lg shadow-sky-500/30 hover:bg-sky-400 hover:shadow-sky-400/40 transition">
                    Create account
                </button>

            </form>

            <p class="text-center text-sm text-slate-300 mt-6">
                Already have an account?
                <a href="{{ route('login') }}" class="text-sky-400 hover:text-sky-300 hover:underline">Log in</a>
            </p>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-950/80 text-slate-300 py-6 text-center">
        <p class="text-xs tracking-wide uppercase text-slate-500 mb-1">&copy; {{ date('Y') }} BizConsult</p>
        <p class="text-sm text-slate-400">Empowering businesses through expert consulting.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('toggle-password');
            const passwordInput = document.getElementById('password');

            if (toggleBtn && passwordInput) {
                toggleBtn.addEventListener('click', function () {
                    const isHidden = passwordInput.type === 'password';
                    passwordInput.type = isHidden ? 'text' : 'password';
                    this.textContent = isHidden ? 'Hide' : 'Show';
                });
            }
        });
    </script>

</body>
</html>
