<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Consultant Dashboard') - BizConsult</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-900 text-white flex flex-col">
            <div class="p-6 border-b border-gray-700">
                <a href="{{ route('dashboard.consultant') }}" class="flex items-center">
                    <img src="{{ asset('images/Bizcon.png') }}" alt="Biz Consult Logo" class="h-10 w-auto">
                    <span class="ml-3 text-xl font-bold">Consultant</span>
                </a>
            </div>

            @php
                $sidebarProfile = \App\Models\ConsultantProfile::firstWhere('user_id', Auth::id());
                $consultantIsVerified = $sidebarProfile && $sidebarProfile->is_verified;
            @endphp

            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('dashboard.consultant') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('dashboard.consultant') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('consultant.consultations') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('consultant.consultations') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    Consultations
                </a>

                @if($consultantIsVerified)
                    <a href="{{ route('consultant.respond') }}"
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('consultant.respond') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Respond to Requests
                    </a>
                    <a href="{{ route('consultant.messages.admin') }}"
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('consultant.messages.admin') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        Messages with Admin
                    </a>
                    <a href="{{ route('consultant.profile.manage') }}"
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('consultant.profile.manage') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profile
                    </a>
                @endif
            </nav>

            <div class="p-4 border-t border-gray-700">
                <a href="{{ route('logout') }}" 
                   class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
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
                            $consultantNotifications = \App\Models\ConsultationNotification::where('user_id', Auth::id())
                                ->orderByDesc('sent_at')
                                ->limit(10)
                                ->get();
                            $consultantUnreadCount = $consultantNotifications->where('is_read', false)->count();
                        @endphp
                        <div class="relative">
                            <button id="consultant-notification-button"
                                    class="relative inline-flex items-center justify-center w-10 h-10 rounded-full border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0a3 3 0 11-6 0h6z"/>
                                </svg>
                                @if($consultantUnreadCount > 0)
                                    <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 rounded-full text-xs font-semibold bg-red-500 text-white">
                                        {{ $consultantUnreadCount }}
                                    </span>
                                @endif
                            </button>
                            <div id="consultant-notification-dropdown"
                                 class="hidden absolute right-0 mt-2 w-80 bg-white border border-gray-200 rounded-lg shadow-lg z-30">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-900">Notifications</p>
                                    <p class="text-xs text-gray-500">
                                        You have {{ $consultantUnreadCount }} unread
                                        {{ $consultantUnreadCount === 1 ? 'notification' : 'notifications' }}.
                                    </p>
                                </div>
                                <div class="max-h-80 overflow-y-auto px-3 py-2 space-y-2">
                                    @forelse($consultantNotifications as $notification)
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
                @php
                    $profile = \App\Models\ConsultantProfile::firstWhere('user_id', Auth::id());
                @endphp
                @if($profile && !$profile->is_verified)
                    <div class="mt-3 p-3 rounded-lg bg-yellow-50 border border-yellow-200 text-yellow-800">
                        <div class="flex items-center justify-between">
                            <span>Your account is pending review. Wait for approval.</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Wait for approval</span>
                        </div>
                    </div>
                @endif
            </header>

            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                    <div class="mb-6 p-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-xl shadow-md" id="success-notification">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-lg font-semibold text-green-900 mb-2">Welcome to BizConsult!</h3>
                                <p class="text-green-800">{{ session('success') }}</p>
                            </div>
                            <button onclick="document.getElementById('success-notification').remove()" class="ml-4 flex-shrink-0 text-green-600 hover:text-green-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-lg">{{ session('error') }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('consultant-notification-button');
            const dropdown = document.getElementById('consultant-notification-dropdown');

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
