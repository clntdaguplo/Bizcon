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

            @if($pending->count() > 0)
                <div class="mb-4 text-sm text-gray-600">
                    <span class="font-semibold">{{ $pending->count() }}</span> consultant(s) pending approval
                </div>
            @endif

            <div class="space-y-6">
                @forelse($pending as $p)
                    <div class="border border-gray-200 rounded-lg p-6 bg-white shadow-sm">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800">{{ $p->full_name }}</h3>
                                <p class="text-gray-600">{{ $p->email }}</p>
                                <p class="text-sm text-gray-500">Submitted: {{ $p->created_at->format('M d, Y \a\t g:i A') }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <form method="POST" action="{{ route('admin.consultants.approve', $p->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                                        ✓ Approve
                                    </button>
                                </form>
                                <button onclick="toggleRejectForm({{ $p->id }})" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                                    ✗ Reject
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <p class="text-gray-900">{{ $p->phone_number }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Expertise</label>
                                <span class="inline-block bg-blue-100 text-blue-800 text-sm px-2 py-1 rounded">{{ $p->expertise }}</span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Age</label>
                                <p class="text-gray-900">{{ $p->age }} years old</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Gender</label>
                                <p class="text-gray-900">{{ $p->sex }}</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Resume</label>
                            <a href="{{ asset('storage/'.$p->resume_path) }}" target="_blank" 
                               class="inline-flex items-center text-blue-600 hover:text-blue-800 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                View Resume (PDF)
                            </a>
                        </div>

                        <!-- Reject Form (Hidden by default) -->
                        <div id="rejectForm{{ $p->id }}" class="hidden border-t pt-4 mt-4">
                            <form method="POST" action="{{ route('admin.consultants.reject', $p->id) }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Rejection Reason (Optional)</label>
                                    <textarea name="admin_note" rows="3" 
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500"
                                        placeholder="Please provide a reason for rejection to help the consultant improve..."></textarea>
                                </div>
                                <div class="flex space-x-2">
                                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                                        Confirm Rejection
                                    </button>
                                    <button type="button" onclick="toggleRejectForm({{ $p->id }})" 
                                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Pending Approvals</h3>
                        <p class="text-gray-600">All consultant applications have been reviewed.</p>
                    </div>
                @endforelse
            </div>

            <script>
                function toggleRejectForm(id) {
                    const form = document.getElementById('rejectForm' + id);
                    form.classList.toggle('hidden');
                }
            </script>
        </div>
    </main>

    <footer class="bg-gray-900 bg-opacity-80 text-gray-300 py-6 text-center mt-12">
        <p>&copy; {{ date('Y') }} BizConsult. All rights reserved.</p>
    </footer>
</body>
</html>

