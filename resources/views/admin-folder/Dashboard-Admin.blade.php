<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BizConsult</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Navbar -->
    <header class="bg-gray-900 bg-opacity-80 fixed top-0 left-0 w-full z-20">
        <div class="container mx-auto flex justify-between items-center p-4">
            <a href="{{ route('dashboard.admin') }}" class="flex items-center pl-6">
                <img src="{{ asset('images/Bizcon.png') }}" alt="Biz Consult Logo" class="h-14 w-auto">
            </a>
            <nav class="flex items-center space-x-6 pr-6 text-gray-300">
                <a href="{{ route('logout') }}" class="hover:text-white">Logout</a>
            </nav>
        </div>
    </header>

    <!-- Dashboard Content -->
    <main class="min-h-screen pt-32 px-6">
        <div class="max-w-5xl mx-auto bg-white p-8 rounded-xl shadow-md">

            <!-- Flash Message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <h1 class="text-4xl font-bold mb-4">Welcome to the Admin Dashboard</h1>
            <p class="text-lg text-gray-700 mb-6">Hello, {{ Auth::user()->name }}! Manage users, approvals, and system settings.</p>

            <!-- Widgets -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 shadow-sm">
                    <h2 class="text-xl font-semibold mb-2">Pending Approvals</h2>
                    <p class="text-gray-600 mb-3">Review and approve new consultant accounts.</p>
                    <a href="{{ route('admin.consultants.pending') }}" class="text-blue-600 hover:underline">View Approvals</a>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 shadow-sm">
                    <h2 class="text-xl font-semibold mb-2">Consultants</h2>
                    <p class="text-gray-600 mb-3">Verified consultants on the platform.</p>
                    <div class="max-h-56 overflow-y-auto">
                        <ul class="list-disc list-inside text-gray-700 space-y-1">
                            @forelse($consultants as $c)
                                <li>{{ $c->full_name }} — {{ $c->expertise }}</li>
                            @empty
                                <li class="text-gray-500">No verified consultants yet.</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.consultants') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">View All Consultants</a>
                    </div>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 shadow-sm">
                    <h2 class="text-xl font-semibold mb-2">Customers</h2>
                    <p class="text-gray-600 mb-3">Registered customers.</p>
                    <div class="max-h-56 overflow-y-auto">
                        <ul class="list-disc list-inside text-gray-700 space-y-1">
                            @forelse($customers as $u)
                                <li>{{ $u->name }} — {{ $u->email }}</li>
                            @empty
                                <li class="text-gray-500">No customers yet.</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.customers') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">View All Customers</a>
                    </div>
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


