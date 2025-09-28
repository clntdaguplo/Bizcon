<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultant Profile - BizConsult</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <header class="bg-gray-900 bg-opacity-80 fixed top-0 left-0 w-full z-20">
        <div class="container mx-auto flex justify-between items-center p-4">
            <a href="{{ route('dashboard.consultant') }}" class="flex items-center pl-6">
                <img src="{{ asset('images/Bizcon.png') }}" alt="Biz Consult Logo" class="h-14 w-auto">
            </a>
            <nav class="flex items-center space-x-6 pr-6 text-gray-300">
                <a href="{{ route('logout') }}" class="hover:text-white">Logout</a>
            </nav>
        </div>
    </header>

    <main class="min-h-screen pt-32 px-6">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-md">
            <h1 class="text-3xl font-bold mb-6">Consultant Profile</h1>
            <p class="text-gray-700 mb-6">Complete your profile to proceed.</p>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('consultant.profile.save') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-gray-700 mb-2">First Name</label>
                    <input type="text" name="first_name" class="w-full px-3 py-2 border rounded" placeholder="Enter your first name" required>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Last Name</label>
                    <input type="text" name="last_name" class="w-full px-3 py-2 border rounded" placeholder="Enter your last name" required>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="email" class="w-full px-3 py-2 border rounded" placeholder="name@example.com" required>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Contact Number</label>
                    <input type="text" name="phone_number" class="w-full px-3 py-2 border rounded" placeholder="e.g. +1 555 123 4567" required>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Age</label>
                    <input type="number" name="age" min="18" max="120" class="w-full px-3 py-2 border rounded" placeholder="Enter your age" required>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Sex</label>
                    <select name="sex" class="w-full px-3 py-2 border rounded" required>
                        <option value="" disabled selected>Select</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Exeperty (experty of what, put selection)</label>
                    <select name="expertise" class="w-full px-3 py-2 border rounded" required>
                        <option value="" disabled selected>Select your experty</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Finance">Finance</option>
                        <option value="Operations">Operations</option>
                        <option value="HR">HR</option>
                        <option value="IT">IT</option>
                        <option value="Legal">Legal</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Resume (file button)</label>
                    <input type="file" name="resume" accept=".pdf,.doc,.docx" class="w-full" required>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">Submit</button>
            </form>
        </div>
    </main>

    <footer class="bg-gray-900 bg-opacity-80 text-gray-300 py-6 text-center mt-12">
        <p>&copy; {{ date('Y') }} BizConsult. All rights reserved.</p>
    </footer>
</body>
</html>

