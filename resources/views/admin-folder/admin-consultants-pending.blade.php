<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Consultants - BizConsult</title>
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
        <div class="max-w-5xl mx-auto bg-white p-8 rounded-xl shadow-md">
            <h1 class="text-3xl font-bold mb-6">Pending Consultant Approvals</h1>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left px-4 py-2">Name</th>
                            <th class="text-left px-4 py-2">Email</th>
                            <th class="text-left px-4 py-2">Phone</th>
                            <th class="text-left px-4 py-2">Expertise</th>
                            <th class="text-left px-4 py-2">Resume</th>
                            <th class="text-left px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pending as $p)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $p->full_name }}</td>
                                <td class="px-4 py-2">{{ $p->email }}</td>
                                <td class="px-4 py-2">{{ $p->phone_number }}</td>
                                <td class="px-4 py-2">{{ $p->expertise }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ asset('storage/'.$p->resume_path) }}" target="_blank" class="text-blue-600 hover:underline">View</a>
                                </td>
                                <td class="px-4 py-2 space-x-2">
                                    <form method="POST" action="{{ route('admin.consultants.approve', $p->id) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-green-600 text-white px-4 py-1 rounded hover:bg-green-700">Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.consultants.reject', $p->id) }}" class="inline">
                                        @csrf
                                        <input type="text" name="admin_note" placeholder="Reason (optional)" class="border rounded px-2 py-1 text-sm">
                                        <button type="submit" class="bg-red-600 text-white px-4 py-1 rounded hover:bg-red-700">Reject</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-600">No pending consultants.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer class="bg-gray-900 bg-opacity-80 text-gray-300 py-6 text-center mt-12">
        <p>&copy; {{ date('Y') }} BizConsult. All rights reserved.</p>
    </footer>
</body>
</html>


