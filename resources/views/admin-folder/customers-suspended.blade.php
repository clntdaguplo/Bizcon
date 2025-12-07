@extends('admin-folder.layout')

@section('title', 'Suspended Customers')
@section('page-title', 'Suspended Customers')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Suspended Customers</h2>
                <p class="text-gray-600">View and manage suspended customer accounts</p>
            </div>
            <div>
                <a href="{{ route('admin.customers') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    All Customers
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-orange-100 rounded-lg">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Suspended</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $customers->total() }}</p>
            </div>
        </div>
    </div>

    <!-- Suspended Customers Table -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Suspended Accounts</h3>
            <p class="text-sm text-gray-600">Customers whose accounts have been suspended</p>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Suspended Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($customers as $customer)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-100 flex items-center justify-center text-xs font-medium text-gray-600 ring-2 ring-orange-500">
                                        @if($customer->avatar_path)
                                            <img src="{{ asset('storage/'.$customer->avatar_path) }}" alt="Avatar" class="w-full h-full object-cover">
                                        @else
                                            <span class="select-none font-semibold text-gray-500">{{ substr($customer->name, 0, 1) }}</span>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $customer->name }}</div>
                                        <div class="text-sm text-gray-500">Customer ID: #{{ $customer->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $customer->email }}</div>
                                <div class="text-sm text-gray-500">Registered User</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                    Suspended
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $customer->updated_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.customers.show', $customer->id) }}" class="text-blue-600 hover:text-blue-900">
                                        View
                                    </a>
                                    <form method="POST" action="{{ route('admin.customers.unsuspend', $customer->id) }}" class="inline" onsubmit="return confirm('Unsuspend this customer?');">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900">
                                            Unsuspend
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-gray-500 text-lg">No suspended customers</p>
                                <p class="text-gray-400 text-sm">Suspended accounts will appear here</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($customers->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $customers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

