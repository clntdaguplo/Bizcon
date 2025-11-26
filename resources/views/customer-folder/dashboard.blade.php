@extends('customer-folder.layout')

@section('title', 'Customer Dashboard')
@section('page-title', 'Dashboard')

@section('content')
        <div class="max-w-5xl mx-auto">

            <!-- Flash Message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <h1 class="text-4xl font-bold mb-4">Welcome to Your Customer Dashboard</h1>
            <p class="text-lg text-gray-700 mb-6">Hello, {{ Auth::user()->name }}! Here you can browse services, view bookings, and manage your profile.</p>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-blue-600">0</div>
                    <div class="text-sm text-blue-800">Active Bookings</div>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-green-600">0</div>
                    <div class="text-sm text-green-800">Completed Sessions</div>
                </div>
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-purple-600">{{ $totalVerifiedConsultants ?? 0 }}</div>
                    <div class="text-sm text-purple-800">Consultants Available</div>
                </div>
            </div>

            <!-- Main Widgets -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold">Browse Services</h2>
                    </div>
                    <p class="text-gray-600 mb-4">Explore available consulting services tailored for your business needs.</p>
                    <a href="{{ route('customer.consultants') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition">
                        See All Consultants
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold">Your Bookings</h2>
                    </div>
                    <p class="text-gray-600 mb-4">Check upcoming and past appointments with consultants.</p>
                    <a href="#" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition">
                        View Bookings
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Available Consultants Preview -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold mb-4">Featured Consultants</h3>
                @if(isset($featuredConsultants) && $featuredConsultants->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($featuredConsultants as $c)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                <div class="flex items-center mb-2">
                                    <div class="w-8 h-8 rounded-full mr-3 overflow-hidden bg-gray-300">
                                        @if($c->avatar_path)
                                            <img src="{{ asset('storage/'.$c->avatar_path) }}" alt="{{ $c->full_name ?? $c->user->name }}" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-medium">{{ $c->full_name ?? $c->user->name }}</div>
                                        <div class="text-sm text-gray-600">{{ $c->expertise ?? '—' }}</div>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">{{ $c->email ?? $c->user->email }}</p>
                                <a href="{{ route('customer.consultants') }}" class="text-blue-600 text-sm hover:underline">View Profile</a>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('customer.consultants') }}" class="text-blue-600 hover:underline">View All Consultants →</a>
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <p class="text-gray-500">No consultants available yet</p>
                    </div>
                @endif
            </div>

			<!-- Personal Notes Widget -->
			<div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm mt-8">
				<h3 class="text-lg font-semibold mb-4">Personal Notes</h3>
				<form id="notesForm" class="flex flex-col sm:flex-row gap-3 mb-4">
					<input id="noteInput" type="text" placeholder="Add a quick note..." class="flex-1 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
					<button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Add</button>
				</form>
				<ul id="notesList" class="space-y-2"></ul>
				<div class="mt-4">
					<button id="clearNotes" class="text-sm text-gray-600 hover:text-gray-800">Clear all</button>
				</div>
			</div>
        </div>
@endsection

@section('scripts')
    <script>
		(function() {
			const STORAGE_KEY = 'customerNotes';
			const form = document.getElementById('notesForm');
			const input = document.getElementById('noteInput');
			const list = document.getElementById('notesList');
			const clearBtn = document.getElementById('clearNotes');

			function getNotes() {
				try {
					return JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
				} catch (_) {
					return [];
				}
			}

			function saveNotes(notes) {
				localStorage.setItem(STORAGE_KEY, JSON.stringify(notes));
			}

			function renderNotes() {
				const notes = getNotes();
				list.innerHTML = '';
				notes.forEach((note, index) => {
					const li = document.createElement('li');
					li.className = 'flex items-center justify-between border border-gray-200 rounded-md px-3 py-2';
					const text = document.createElement('span');
					text.className = 'text-gray-800';
					text.textContent = note;
					const del = document.createElement('button');
					del.className = 'text-sm text-red-600 hover:text-red-800';
					del.textContent = 'Delete';
					del.addEventListener('click', function() {
						const updated = getNotes();
						updated.splice(index, 1);
						saveNotes(updated);
						renderNotes();
					});
					li.appendChild(text);
					li.appendChild(del);
					list.appendChild(li);
				});
			}

			form.addEventListener('submit', function(e) {
				e.preventDefault();
				const value = (input.value || '').trim();
				if (!value) return;
				const notes = getNotes();
				notes.unshift(value);
				saveNotes(notes);
				input.value = '';
				renderNotes();
			});

			clearBtn.addEventListener('click', function() {
				saveNotes([]);
				renderNotes();
			});

			renderNotes();
		})();
    </script>
@endsection

