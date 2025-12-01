@extends('admin-folder.layout')

@section('title', 'Manage Users')
@section('page-title', 'User Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">User Management</h2>
        <p class="text-gray-600">Manage consultants, customers, and pending approvals</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending Approvals</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $pending->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Verified Consultants</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $consultants->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Customers</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $customers->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="bg-white rounded-lg shadow">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                <button onclick="showTab('pending')" id="pending-tab" class="tab-button py-4 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600">
                    Pending Approvals ({{ $pending->count() }})
                </button>
                <button onclick="showTab('consultants')" id="consultants-tab" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    All Consultants ({{ $consultants->count() }})
                </button>
                <button onclick="showTab('customers')" id="customers-tab" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    All Customers ({{ $customers->count() }})
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            <!-- Pending Approvals Tab -->
            <div id="pending-content" class="tab-content">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Pending Consultant Approvals</h3>
                @if($pending->count() > 0)
                    <div class="space-y-4">
                        @foreach($pending as $profile)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-100 flex items-center justify-center text-sm font-medium text-gray-600">
                                            @if($profile->avatar_path)
                                                <img src="{{ asset('storage/'.$profile->avatar_path) }}" alt="Avatar" class="w-full h-full object-cover">
                                            @else
                                                <span class="select-none text-lg font-semibold text-gray-500">{{ substr($profile->full_name ?? $profile->user->name, 0, 1) }}</span>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-medium text-gray-900">{{ $profile->user->name }}</h4>
                                            <p class="text-sm text-gray-500">{{ $profile->user->email }}</p>
                                            <p class="text-sm text-gray-600">Expertise: {{ $profile->expertise ?? 'Not specified' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.consultants.show', $profile->id) }}" class="bg-blue-50 text-blue-700 px-4 py-2 rounded hover:bg-blue-100">
                                            View
                                        </a>
                                        <form action="{{ route('admin.consultants.approve', $profile->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                                Approve
                                            </button>
                                        </form>
                                        <button onclick="toggleRejectForm({{ $profile->id }})" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                            Reject
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Reject Form (Hidden by default) -->
                                <div id="reject-form-{{ $profile->id }}" class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg hidden">
                                    <form action="{{ route('admin.consultants.reject', $profile->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="reject_reason_{{ $profile->id }}" class="block text-sm font-medium text-gray-700">Rejection Reason</label>
                                            <textarea name="reject_reason" id="reject_reason_{{ $profile->id }}" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required></textarea>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                                Confirm Rejection
                                            </button>
                                            <button type="button" onclick="toggleRejectForm({{ $profile->id }})" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex items-center space-x-4 p-6 bg-white rounded-lg shadow">
                        @php
                            $avatar = auth()->user()->avatar_path ?? null;
                            $nameParts = array_filter(explode(' ', trim(auth()->user()->name)));
                            $initials = '';
                            foreach (array_slice($nameParts, 0, 2) as $part) {
                                $initials .= strtoupper(substr($part, 0, 1));
                            }
                            if ($initials === '') {
                                $initials = strtoupper(substr(auth()->user()->name, 0, 1) ?: 'U');
                            }
                        @endphp
                        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center text-lg font-medium text-gray-700 overflow-hidden">
                            @if($avatar)
                                <img src="{{ asset('storage/' . $avatar) }}" alt="{{ auth()->user()->name }}" class="h-full w-full object-cover">
                            @else
                                <span class="select-none">{{ $initials }}</span>
                            @endif
                        </div>
                        <div>
                            <div class="text-lg font-medium text-gray-900">{{ auth()->user()->name }}</div>
                            <div class="text-sm text-gray-500">{{ auth()->user()->email }}</div>
                            <p class="text-sm text-gray-500 mt-2">No pending approvals at the moment.</p>
                        </div>
                    </div>
                 @endif
            </div>

            <!-- Consultants Tab -->
            <div id="consultants-content" class="tab-content hidden">
                <h3 class="text-lg font-medium text-gray-900 mb-4">All Consultants</h3>
                @if($consultants->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expertise</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($consultants as $consultant)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-100 flex items-center justify-center text-xs font-medium text-gray-600">
                                                    @if($consultant->avatar_path)
                                                        <img src="{{ asset('storage/'.$consultant->avatar_path) }}" alt="Avatar" class="w-full h-full object-cover">
                                                    @else
                                                        <span class="select-none font-semibold text-gray-500">{{ substr($consultant->full_name ?? $consultant->user->name, 0, 1) }}</span>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $consultant->user->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $consultant->user->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $consultant->expertise ?? 'Not specified' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Verified
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $consultant->created_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('admin.consultants.show', $consultant->id) }}" class="text-blue-600 hover:text-blue-800">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <p class="text-gray-500">No consultants found</p>
                    </div>
                @endif
            </div>

            <!-- Customers Tab -->
            <div id="customers-content" class="tab-content hidden">
                <h3 class="text-lg font-medium text-gray-900 mb-4">All Customers</h3>
                @if($customers->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($customers as $customer)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-100 flex items-center justify-center text-xs font-medium text-gray-600">
                                                    @if($customer->avatar_path)
                                                        <img src="{{ asset('storage/'.$customer->avatar_path) }}" alt="Avatar" class="w-full h-full object-cover">
                                                    @else
                                                        <span class="select-none font-semibold text-gray-500">{{ substr($customer->name, 0, 1) }}</span>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $customer->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $customer->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Active
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $customer->created_at->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <p class="text-gray-500">No customers found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all tab contents
    const contents = document.querySelectorAll('.tab-content');
    contents.forEach(content => content.classList.add('hidden'));
    
    // Remove active styling from all tabs
    const tabs = document.querySelectorAll('.tab-button');
    tabs.forEach(tab => {
        tab.classList.remove('border-blue-500', 'text-blue-600');
        tab.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    document.getElementById(tabName + '-content').classList.remove('hidden');
    
    // Add active styling to selected tab
    const activeTab = document.getElementById(tabName + '-tab');
    activeTab.classList.remove('border-transparent', 'text-gray-500');
    activeTab.classList.add('border-blue-500', 'text-blue-600');
}

function toggleRejectForm(profileId) {
    const form = document.getElementById('reject-form-' + profileId);
    form.classList.toggle('hidden');
}
</script>
@endsection