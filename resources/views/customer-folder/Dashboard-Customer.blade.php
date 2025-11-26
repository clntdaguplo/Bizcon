<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard - BizConsult</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Navbar -->
    <header class="bg-gray-900 bg-opacity-80 fixed top-0 left-0 w-full z-20">
        <div class="container mx-auto flex justify-between items-center p-4">
            <a href="{{ route('dashboard.customer') }}" class="flex items-center pl-6">
                <img src="{{ asset('images/Bizcon.png') }}" alt="Biz Consult Logo" class="h-14 w-auto">
            </a>
            <nav class="flex items-center space-x-6 pr-6 text-gray-300">
                <a href="{{ route('logout') }}" class="hover:text-white">Logout</a>
            </nav>
        </div>
    </header>

    <!-- Dashboard Content -->
    <main class="min-h-screen pt-32 px-6">
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-md">

            <!-- Flash Message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <h1 class="text-4xl font-bold mb-4">Welcome to Your Customer Dashboard</h1>
            <p class="text-lg text-gray-700 mb-6">Hello, {{ Auth::user()->name }}! Here you can browse services, view bookings, and manage your profile.</p>

            <!-- Widgets -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 shadow-sm">
                    <h2 class="text-xl font-semibold mb-2">Browse Services</h2>
                    <p class="text-gray-600 mb-3">Explore available consulting services tailored for you.</p>
                    <a href="#" class="text-blue-600 hover:underline">View Services</a>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 shadow-sm">
                    <h2 class="text-xl font-semibold mb-2">Your Bookings</h2>
                    <p class="text-gray-600 mb-3">Check upcoming and past appointments.</p>
                    <a href="#" class="text-blue-600 hover:underline">View Bookings</a>
                </div>
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
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 bg-opacity-80 text-gray-300 py-6 text-center mt-12">
        <p>&copy; {{ date('Y') }} BizConsult. All rights reserved.</p>
    </footer>

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
</body>
</html>