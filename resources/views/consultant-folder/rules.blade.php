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

    <main class="min-h-screen pt-24 px-6 pb-12 bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-5xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-8">
                <div class="inline-block p-4 bg-blue-100 rounded-full mb-4">
                    <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-3">Consultant Rules & Regulations</h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Please read through our guidelines carefully. These rules ensure a professional and trustworthy environment for all consultants and clients.
                </p>
            </div>

            <!-- Rules Cards Grid -->
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <!-- Rule 1 -->
                    <div class="flex items-start p-5 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border-l-4 border-blue-500 hover:shadow-md transition duration-300">
                        <div class="flex-shrink-0 w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mr-4">
                            <span class="text-white font-bold text-lg">1</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 mb-1">Accurate Information</h3>
                            <p class="text-sm text-gray-700">Provide accurate and up-to-date professional information.</p>
                        </div>
                    </div>

                    <!-- Rule 2 -->
                    <div class="flex items-start p-5 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl border-l-4 border-purple-500 hover:shadow-md transition duration-300">
                        <div class="flex-shrink-0 w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center mr-4">
                            <span class="text-white font-bold text-lg">2</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 mb-1">Confidentiality</h3>
                            <p class="text-sm text-gray-700">Maintain confidentiality of client data at all times.</p>
                        </div>
                    </div>

                    <!-- Rule 3 -->
                    <div class="flex items-start p-5 bg-gradient-to-br from-green-50 to-green-100 rounded-xl border-l-4 border-green-500 hover:shadow-md transition duration-300">
                        <div class="flex-shrink-0 w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mr-4">
                            <span class="text-white font-bold text-lg">3</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 mb-1">Prompt Response</h3>
                            <p class="text-sm text-gray-700">Respond to client requests promptly and professionally.</p>
                        </div>
                    </div>

                    <!-- Rule 4 -->
                    <div class="flex items-start p-5 bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl border-l-4 border-orange-500 hover:shadow-md transition duration-300">
                        <div class="flex-shrink-0 w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center mr-4">
                            <span class="text-white font-bold text-lg">4</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 mb-1">Genuine Documents</h3>
                            <p class="text-sm text-gray-700">Upload only genuine and verifiable credentials/documents.</p>
                        </div>
                    </div>

                    <!-- Rule 5 -->
                    <div class="flex items-start p-5 bg-gradient-to-br from-red-50 to-red-100 rounded-xl border-l-4 border-red-500 hover:shadow-md transition duration-300">
                        <div class="flex-shrink-0 w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center mr-4">
                            <span class="text-white font-bold text-lg">5</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 mb-1">Legal Compliance</h3>
                            <p class="text-sm text-gray-700">Comply with all applicable laws and platform policies.</p>
                        </div>
                    </div>

                    <!-- Rule 6 -->
                    <div class="flex items-start p-5 bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl border-l-4 border-indigo-500 hover:shadow-md transition duration-300">
                        <div class="flex-shrink-0 w-12 h-12 bg-indigo-500 rounded-lg flex items-center justify-center mr-4">
                            <span class="text-white font-bold text-lg">6</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 mb-1">Conflict of Interest</h3>
                            <p class="text-sm text-gray-700">Avoid conflicts of interest and disclose where applicable.</p>
                        </div>
                    </div>

                    <!-- Rule 7 -->
                    <div class="flex items-start p-5 bg-gradient-to-br from-pink-50 to-pink-100 rounded-xl border-l-4 border-pink-500 hover:shadow-md transition duration-300">
                        <div class="flex-shrink-0 w-12 h-12 bg-pink-500 rounded-lg flex items-center justify-center mr-4">
                            <span class="text-white font-bold text-lg">7</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 mb-1">Professional Communication</h3>
                            <p class="text-sm text-gray-700">Maintain respectful and appropriate communication with clients.</p>
                        </div>
                    </div>

                    <!-- Rule 8 -->
                    <div class="flex items-start p-5 bg-gradient-to-br from-teal-50 to-teal-100 rounded-xl border-l-4 border-teal-500 hover:shadow-md transition duration-300">
                        <div class="flex-shrink-0 w-12 h-12 bg-teal-500 rounded-lg flex items-center justify-center mr-4">
                            <span class="text-white font-bold text-lg">8</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 mb-1">Account Security</h3>
                            <p class="text-sm text-gray-700">Do not share your account or impersonate other professionals.</p>
                        </div>
                    </div>

                    <!-- Rule 9 -->
                    <div class="flex items-start p-5 bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl border-l-4 border-amber-500 hover:shadow-md transition duration-300">
                        <div class="flex-shrink-0 w-12 h-12 bg-amber-500 rounded-lg flex items-center justify-center mr-4">
                            <span class="text-white font-bold text-lg">9</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 mb-1">Fair Billing</h3>
                            <p class="text-sm text-gray-700">Bill fairly and transparently for your services.</p>
                        </div>
                    </div>

                    <!-- Rule 10 -->
                    <div class="flex items-start p-5 bg-gradient-to-br from-cyan-50 to-cyan-100 rounded-xl border-l-4 border-cyan-500 hover:shadow-md transition duration-300">
                        <div class="flex-shrink-0 w-12 h-12 bg-cyan-500 rounded-lg flex items-center justify-center mr-4">
                            <span class="text-white font-bold text-lg">10</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 mb-1">Report Issues</h3>
                            <p class="text-sm text-gray-700">Report suspicious activity to the administrators immediately.</p>
                        </div>
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-5 bg-red-50 border-l-4 border-red-500 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h4 class="text-red-800 font-semibold mb-1">Please fix the following errors:</h4>
                            <ul class="list-disc list-inside text-red-700 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Acceptance Form -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <form action="{{ route('consultant.rules.accept') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 p-6 bg-gray-50 rounded-xl border-2 border-gray-200">
                        <label class="inline-flex items-center cursor-pointer group">
                            <input type="checkbox" name="accept" class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" required>
                            <span class="ml-3 text-gray-700 group-hover:text-gray-900 font-medium">
                                I have read and agree to all the rules and regulations above
                            </span>
                        </label>
                        <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-800 transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center justify-center">
                            <span>Accept & Continue</span>
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Info Box -->
            <div class="mt-6 p-5 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <h4 class="text-blue-900 font-semibold mb-1">Important Note</h4>
                        <p class="text-blue-800 text-sm">
                            By accepting these rules, you acknowledge that violation of any of these guidelines may result in account suspension or termination. 
                            We reserve the right to review and take appropriate action on any reported violations.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-gray-900 text-gray-300 py-16 mt-12">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-8 justify-items-center">
                <!-- BizConsult Intro -->
                <div>
                    <h3 class="text-2xl font-semibold text-white mb-4">BizConsult</h3>
                    <p class="text-gray-300 leading-relaxed max-w-md">
                        Your trusted partner for business consulting and professional services. 
                        We help businesses grow, innovate, and achieve their goals through expert guidance, 
                        strategic planning, and practical, results-driven solutions.
                    </p>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-xl font-semibold text-white mb-6">CONTACT US</h3>
                    <ul class="space-y-3">
                        <li><a href="mailto:bizconsult@gmail.com" class="hover:text-white transition duration-300">bizconsult@gmail.com</a></li>
                        <li><span class="hover:text-white transition duration-300">Uc Main Sancianqko St, Avocado Bldg, 5th Floor</span></li>
                        <li><span class="hover:text-white transition duration-300">Cebu City</span></li>
                        <li><a href="tel:+09123456789" class="hover:text-white transition duration-300">+0912 345 6789</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-12 pt-8 text-center">
                <p>&copy; {{ date('Y') }} BizConsult. All rights reserved.</p>
                <p class="text-sm mt-2">Empowering businesses through expert consulting services.</p>
            </div>
        </div>
    </footer>
</body>
</html>

