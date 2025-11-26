<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Consultants - BizConsult</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
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

    <main class="min-h-screen pt-32 px-6">
        <div class="max-w-6xl mx-auto bg-white p-8 rounded-xl shadow-md">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">All Consultants</h1>
                <a href="{{ route('admin.consultants.pending') }}" class="text-blue-600 hover:underline">Pending Approvals</a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left px-4 py-2">Photo</th>
                            <th class="text-left px-4 py-2">Name</th>
                            <th class="text-left px-4 py-2">Email</th>
                            <th class="text-left px-4 py-2">Phone</th>
                            <th class="text-left px-4 py-2">Expertise</th>
                            <th class="text-left px-4 py-2">Verified</th>
                            <th class="text-left px-4 py-2">Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($consultants as $c)
                            <tr class="border-t">
                                <td class="px-4 py-2">
                                    @if($c->avatar_path)
                                        <img src="{{ asset('storage/'.$c->avatar_path) }}" alt="Avatar" class="h-10 w-10 rounded-full object-cover">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">--</div>
                                    @endif
                                </td>
                                <td class="px-4 py-2">{{ $c->full_name }}</td>
                                <td class="px-4 py-2">{{ $c->email }}</td>
                                <td class="px-4 py-2">{{ $c->phone_number }}</td>
                                <td class="px-4 py-2">{{ $c->expertise }}</td>
                                <td class="px-4 py-2">{{ $c->is_verified ? 'Yes' : 'No' }}</td>
                                <td class="px-4 py-2">{{ $c->updated_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-600">No consultants found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $consultants->links() }}
            </div>
        </div>
    </main>

    <footer class="bg-gray-900 bg-opacity-80 text-gray-300 py-6 text-center mt-12">
        <p>&copy; {{ date('Y') }} BizConsult. All rights reserved.</p>
    </footer>
</body>
</html>


