<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation Requests - BizConsult</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <header class="bg-gray-900 bg-opacity-80 fixed top-0 left-0 w-full z-20">
        <div class="container mx-auto flex justify-between items-center p-4">
            <a href="{{ route('dashboard.consultant') }}" class="flex items-center pl-6">
                <img src="{{ asset('images/Bizcon.png') }}" alt="Biz Consult Logo" class="h-14 w-auto">
            </a>
            <nav class="flex items-center space-x-6 pr-6 text-gray-300">
                <a href="{{ route('logout') }}" class="hover:text-white">Logout</a>
            </nav>
        </div>
    </header>

    <main class="min-h-screen pt-32 px-6">
        <div class="max-w-5xl mx-auto bg-white p-8 rounded-xl shadow-md">
            <h1 class="text-3xl font-bold mb-6">Consultation Requests</h1>

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left px-4 py-2">Customer</th>
                            <th class="text-left px-4 py-2">Topic</th>
                            <th class="text-left px-4 py-2">Preferred</th>
                            <th class="text-left px-4 py-2">Status</th>
                            <th class="text-left px-4 py-2">Requested</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($consultations as $item)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $item->customer->name }}</td>
                                <td class="px-4 py-2">{{ $item->topic }}</td>
                                <td class="px-4 py-2">{{ $item->preferred_date }} {{ $item->preferred_time }}</td>
                                <td class="px-4 py-2">{{ $item->status }}</td>
                                <td class="px-4 py-2">{{ $item->created_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-600">No consultation requests yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $consultations->links() }}
            </div>
        </div>
    </main>

    <footer class="bg-gray-900 bg-opacity-80 text-gray-300 py-6 text-center mt-12">
        <p>&copy; {{ date('Y') }} BizConsult. All rights reserved.</p>
    </footer>
</body>
</html>


