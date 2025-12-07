@extends('admin-folder.layout')

@section('title', 'Customer Profile')
@section('page-title', 'Customer Profile')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.customers') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 bg-white rounded-lg border border-gray-300 hover:bg-gray-50 hover:text-gray-900 transition shadow-sm hover:shadow">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to All Customers
        </a>
    </div>

    <!-- Profile Header Card -->
    <div class="bg-gradient-to-br from-white to-gray-50 rounded-xl shadow-lg border border-gray-200 p-8">
        <div class="flex flex-col md:flex-row items-start md:items-center space-y-6 md:space-y-0 md:space-x-8">
            <div class="relative">
                <div class="w-28 h-28 rounded-2xl overflow-hidden bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center shadow-md ring-4 ring-white">
                    @if($customer->avatar_path)
                        <img src="{{ asset('storage/'.$customer->avatar_path) }}" alt="Avatar" class="w-full h-full object-cover">
                    @else
                        <span class="text-4xl font-bold text-gray-600">{{ substr($customer->name, 0, 1) }}</span>
                    @endif
                </div>
                @if(!$customer->is_suspended)
                    <div class="absolute -bottom-2 -right-2 bg-green-500 rounded-full p-1.5 shadow-lg">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                @endif
            </div>
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-2">
                    <h2 class="text-3xl font-bold text-gray-900">{{ $customer->name }}</h2>
                </div>
                <div class="flex items-center text-gray-600 mb-4">
                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-lg">{{ $customer->email }}</span>
                </div>
                <div class="flex items-center flex-wrap gap-3 mb-4">
                    @if($customer->is_suspended)
                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-semibold bg-orange-100 text-orange-800 border border-orange-200">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                            </svg>
                            Suspended
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-semibold bg-green-100 text-green-800 border border-green-200">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Active
                        </span>
                    @endif
                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm text-gray-600 bg-gray-50 border border-gray-200">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                        </svg>
                        Customer ID: #{{ $customer->id }}
                    </span>
                </div>
            </div>
            <div class="text-right space-y-3 bg-white rounded-lg p-4 border border-gray-200 shadow-sm">
                <div class="flex items-center justify-end text-gray-600 mb-2">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <div>
                        <div class="text-xs text-gray-500 font-medium">Joined</div>
                        <div class="text-sm font-semibold text-gray-900">{{ $customer->created_at?->format('M d, Y') }}</div>
                    </div>
                </div>
                <div>
                    @if($customer->is_suspended)
                        <form method="POST"
                              action="{{ route('admin.customers.unsuspend', $customer->id) }}"
                              onsubmit="return confirm('Unsuspend this customer?');">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-semibold bg-green-600 text-white hover:bg-green-700 w-full transition shadow-md hover:shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Unsuspend Customer
                            </button>
                        </form>
                    @else
                        <button onclick="if(confirm('Suspend this customer?')) { document.getElementById('suspend-form').submit(); }"
                                class="inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-semibold bg-red-600 text-white hover:bg-red-700 w-full transition shadow-md hover:shadow-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                            </svg>
                            Suspend Customer
                        </button>
                        <form id="suspend-form" method="POST" action="{{ route('admin.customers.suspend', $customer->id) }}" class="hidden">
                            @csrf
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Information Sections -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
            <div class="flex items-center mb-6 pb-4 border-b border-gray-200">
                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Contact Information</h3>
            </div>
            <div class="space-y-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <div class="flex-1">
                        <div class="text-xs text-gray-500 font-medium uppercase mb-1">Email</div>
                        <div class="text-base font-semibold text-gray-900">
                            <a href="mailto:{{ $customer->email }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                {{ $customer->email }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
            <div class="flex items-center mb-6 pb-4 border-b border-gray-200">
                <div class="bg-purple-100 p-2 rounded-lg mr-3">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Account Details</h3>
            </div>
            <div class="space-y-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <div class="flex-1">
                        <div class="text-xs text-gray-500 font-medium uppercase mb-1">Role</div>
                        <div class="text-base font-semibold text-gray-900">{{ $customer->role ?? 'Customer' }}</div>
                    </div>
                </div>
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <div class="flex-1">
                        <div class="text-xs text-gray-500 font-medium uppercase mb-1">Joined</div>
                        <div class="text-base font-semibold text-gray-900">{{ $customer->created_at?->format('M d, Y \a\t g:i A') }}</div>
                    </div>
                </div>
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <div class="text-xs text-gray-500 font-medium uppercase mb-1">Last Updated</div>
                        <div class="text-base font-semibold text-gray-900">{{ $customer->updated_at?->diffForHumans() }}</div>
                    </div>
                </div>
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <div class="text-xs text-gray-500 font-medium uppercase mb-1">Account Status</div>
                        <div class="mt-1">
                            @if($customer->is_suspended)
                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-semibold bg-orange-100 text-orange-800 border border-orange-200">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                    </svg>
                                    Suspended
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-semibold bg-green-100 text-green-800 border border-green-200">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Active
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


