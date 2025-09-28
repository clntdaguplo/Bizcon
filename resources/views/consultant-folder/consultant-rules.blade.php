<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultant Rules - BizConsult</title>
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
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-md">
            <h1 class="text-3xl font-bold mb-6">Consultant Rules & Regulations</h1>

            <div class="border border-gray-200 rounded-lg p-6 mb-6 h-96 overflow-y-auto bg-gray-50">
                <ol class="list-decimal list-inside space-y-3 text-gray-700">
                    <li>Provide accurate and up-to-date professional information.</li>
                    <li>Maintain confidentiality of client data at all times.</li>
                    <li>Respond to client requests promptly and professionally.</li>
                    <li>Upload only genuine and verifiable credentials/documents.</li>
                    <li>Comply with all applicable laws and platform policies.</li>
                    <li>Avoid conflicts of interest and disclose where applicable.</li>
                    <li>Maintain respectful and appropriate communication with clients.</li>
                    <li>Do not share your account or impersonate other professionals.</li>
                    <li>Bill fairly and transparently for your services.</li>
                    <li>Report suspicious activity to the administrators immediately.</li>
                </ol>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('consultant.rules.accept') }}" method="POST" class="space-y-4">
                @csrf
                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="accept" class="mr-2" required>
                        <span>I have read and agree to the rules and regulations.</span>
                    </label>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Next</button>
                </div>
            </form>
        </div>
    </main>

    <footer class="bg-gray-900 bg-opacity-80 text-gray-300 py-6 text-center mt-12">
        <p>&copy; {{ date('Y') }} BizConsult. All rights reserved.</p>
    </footer>
</body>
</html>


