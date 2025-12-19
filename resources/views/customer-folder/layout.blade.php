<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Customer Dashboard') - BizConsult</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-900 text-white flex flex-col">
            <div class="p-6 border-b border-gray-700">
                <a href="{{ route('dashboard.customer') }}" class="flex flex-col items-center">
                    <img src="{{ asset('images/Bizcon.png') }}" alt="Biz Consult Logo" class="h-10 w-auto mb-2">
                    <div class="flex flex-col items-center">
                        <span class="text-xl font-bold">Customer</span>
                        @php
                            $tier = Auth::user()->getSubscriptionTier();
                            $tierColor = match($tier) {
                                'Free' => 'text-gray-400 bg-gray-800',
                                'Weekly' => 'text-blue-400 bg-blue-900/50',
                                'Quarterly' => 'text-purple-400 bg-purple-900/50',
                                'Annual' => 'text-amber-400 bg-amber-900/50',
                                default => 'text-gray-500'
                            };
                        @endphp
                        <span class="mt-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-widest border border-current {{ $tierColor }}">
                            {{ $tier }} Plan
                        </span>
                    </div>
                </a>
            </div>

            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('customer.dashboard') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('customer.dashboard') || request()->routeIs('dashboard.customer') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path></svg>
                    Dashboard
                </a>
                <a href="{{ route('customer.new-consult') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('customer.new-consult') || request()->routeIs('customer.new_consult') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    New Consultation
                </a>
                <a href="{{ route('customer.consultants') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('customer.consultants') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"></path></svg>
                    Consultants
                </a>
                <a href="{{ route('customer.my-consults') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('customer.my-consults') || request()->routeIs('customer.my_consults') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    My Consultations
                </a>
                <a href="{{ route('customer.profile') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('customer.profile') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Profile
                </a>
                <a href="{{ route('customer.plans') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('customer.plans') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Plans
                </a>
            </nav>

            <div class="p-4 border-t border-gray-700">
                <a href="{{ route('logout') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-500 hidden sm:block">
                            {{ now()->format('l, F j, Y') }}
                        </div>
                        @php
                            $customerNotifications = \App\Models\ConsultationNotification::where('user_id', Auth::id())
                                ->orderByDesc('sent_at')
                                ->limit(10)
                                ->get();
                            $customerUnreadCount = $customerNotifications->where('is_read', false)->count();
                        @endphp
                        <div class="relative">
                            <button id="customer-notification-button"
                                    class="relative inline-flex items-center justify-center w-10 h-10 rounded-full border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0a3 3 0 11-6 0h6z"/>
                                </svg>
                                @if($customerUnreadCount > 0)
                                    <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 rounded-full text-xs font-semibold bg-red-500 text-white">
                                        {{ $customerUnreadCount }}
                                    </span>
                                @endif
                            </button>
                            <div id="customer-notification-dropdown"
                                 class="hidden absolute right-0 mt-2 w-80 bg-white border border-gray-200 rounded-lg shadow-lg z-30">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-900">Notifications</p>
                                    <p class="text-xs text-gray-500">
                                        You have {{ $customerUnreadCount }} unread
                                        {{ $customerUnreadCount === 1 ? 'notification' : 'notifications' }}.
                                    </p>
                                </div>
                                <div class="max-h-80 overflow-y-auto px-3 py-2 space-y-2">
                                    @forelse($customerNotifications as $notification)
                                        <a href="{{ route('notifications.go', $notification->id) }}"
                                           class="block px-3 py-3 text-sm {{ $notification->is_read ? 'bg-white' : 'bg-blue-50' }} border border-gray-200 rounded-md hover:bg-blue-100 transition-colors">
                                            <p class="font-semibold text-gray-900">{{ $notification->title }}</p>
                                            <p class="text-gray-600 mt-1 whitespace-pre-line">{{ $notification->message }}</p>
                                            <p class="text-xs text-gray-400 mt-1">
                                                {{ $notification->sent_at ? $notification->sent_at->format('M j, Y g:i A') : '' }}
                                            </p>
                                        </a>
                                    @empty
                                        <div class="px-3 py-6 text-center text-sm text-gray-500">
                                            No notifications yet.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg border border-green-200 shadow-sm flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-lg border border-red-200 shadow-sm flex items-center font-bold">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-lg border border-red-200 shadow-sm font-bold">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                            <span>There were some issues with your request:</span>
                        </div>
                        <ul class="list-disc list-inside ml-8 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('customer-notification-button');
            const dropdown = document.getElementById('customer-notification-dropdown');

            if (btn && dropdown) {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('hidden');
                });

                document.addEventListener('click', function (e) {
                    if (!dropdown.classList.contains('hidden')) {
                        if (!dropdown.contains(e.target) && !btn.contains(e.target)) {
                            dropdown.classList.add('hidden');
                        }
                    }
                });
            }
        });
    </script>
    @yield('scripts')
</body>
</html>


