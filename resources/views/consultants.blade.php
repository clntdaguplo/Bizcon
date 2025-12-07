<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Consultants - BizConsult</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Navbar -->
    <header class="bg-gray-900 bg-opacity-80 fixed top-0 left-0 w-full z-20">
        <div class="container mx-auto flex justify-between items-center p-4">
            
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center pl-6">
                <img src="{{ asset('images/Bizcon.png') }}" 
                     alt="Biz Consult Logo" 
                     class="h-14 w-auto">
            </a>

            <!-- Navigation -->
            <nav class="flex items-center space-x-6 pr-6 text-gray-300">
                <div class="flex space-x-6">
                    <a href="{{ route('home') }}" class="hover:text-white transition duration-300">Home</a>
                    <a href="{{ route('home') }}#services" class="hover:text-white transition duration-300">Services</a>
                    <a href="{{ route('home') }}#about" class="hover:text-white transition duration-300">About Us</a>
                    <a href="{{ route('consultants') }}" class="text-white font-semibold">Our Consultants</a>
                </div>

                <span class="mx-2 border-l border-gray-500 h-6"></span>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" 
                        class="px-4 py-2 border border-gray-300 text-gray-300 rounded-lg font-medium hover:bg-gray-300 hover:text-gray-900 transition">
                        Log In
                    </a>

                    <a href="{{ route('signup') }}" 
                    class="px-4 py-2 bg-gray-300 text-gray-900 rounded-lg font-medium hover:bg-white transition">
                    Sign Up
                    </a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative bg-cover bg-center text-white min-h-screen flex items-center pt-20"
        style="background-image: url('{{ asset('images/background.png') }}');">
        
        <!-- Dark overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>

        <!-- Hero Content -->
        <div class="relative z-10 container mx-auto text-center px-6">
            <h1 class="text-5xl font-bold mb-6">Meet Our Expert Consultants</h1>
            <p class="text-xl mb-8 max-w-3xl mx-auto">Discover our team of verified professionals ready to help your business grow and succeed. Each consultant brings years of experience and specialized expertise to deliver exceptional results.</p>
        </div>
    </section>

    <!-- Consultants Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <!-- Search and Filter -->
            <div class="max-w-4xl mx-auto mb-12">
                <form method="GET" action="{{ route('consultants') }}" class="mb-8">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <input type="text" name="q" id="public-live-search" value="{{ $query ?? '' }}" 
                               placeholder="Search by expertise, name, or specialization..." 
                               class="flex-1 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               autocomplete="off">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300 font-semibold">
                            Search Consultants
                        </button>
                    </div>
                </form>

                @if(isset($query) && $query)
                    <div class="text-center mb-6">
                        <p class="text-gray-600">Search results for: <span class="font-semibold text-gray-900">"{{ $query }}"</span></p>
                        <a href="{{ route('consultants') }}" class="text-blue-600 hover:underline">Clear search</a>
                    </div>
                @endif
            </div>

            <!-- Consultants Grid -->
            <div class="max-w-7xl mx-auto">
                @if($consultants->count() > 0)
                    <div id="consultants-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($consultants as $consultant)
                            <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-xl transition duration-300 hover:border-blue-300">
                                <!-- Consultant Avatar and Basic Info -->
                                <div class="flex items-center mb-4">
                                    <div class="h-16 w-16 rounded-full overflow-hidden bg-gray-200 mr-4 flex-shrink-0">
                                        @if($consultant->avatar_path)
                                            <img src="{{ asset('storage/'.$consultant->avatar_path) }}" 
                                                 alt="{{ $consultant->full_name }}" 
                                                 class="h-full w-full object-cover">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center text-gray-500 text-2xl font-bold">
                                                {{ substr($consultant->full_name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-xl font-bold text-gray-900">{{ $consultant->full_name }}</h3>
                                        @php
                                            $expertiseList = $consultant->expertise
                                                ? array_filter(array_map('trim', explode(',', $consultant->expertise)))
                                                : [];
                                        @endphp
                                        @if(!empty($expertiseList))
                                            <ul class="mt-2 text-sm text-gray-700 space-y-1 list-disc list-inside">
                                                @foreach($expertiseList as $expertiseItem)
                                                    <li>{{ $expertiseItem }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-sm text-gray-500 mt-2">No expertise listed</p>
                                        @endif
                                        <div class="flex items-center mt-4 space-x-3">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="text-sm text-green-600 font-medium">Verified</span>
                                            </div>
                                            @if($consultant->average_rating)
                                                <div class="flex items-center">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= round($consultant->average_rating))
                                                            <span class="text-yellow-500 text-base">⭐</span>
                                                        @else
                                                            <span class="text-gray-300 text-base">☆</span>
                                                        @endif
                                                    @endfor
                                                </div>
                                            @else
                                                <div class="flex items-center">
                                                    <span class="text-gray-300 text-base">☆☆☆☆☆</span>
                                                    <span class="text-xs text-gray-500 ml-2">No ratings yet</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Information -->
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-sm">{{ $consultant->email }}</span>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex space-x-3">
                                    <a href="{{ route('login') }}" 
                                       class="flex-1 bg-blue-600 text-white text-center py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300 font-semibold">
                                        Request Consultation
                                    </a>
                                    <button class="bg-gray-100 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-200 transition duration-300">
                                        View Profile
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12" id="pagination-wrapper">
                        {{ $consultants->appends(['q' => $query])->links() }}
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">No Consultants Found</h3>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">
                            @if(isset($query) && $query)
                                We couldn't find any consultants matching your search criteria. Try adjusting your search terms.
                            @else
                                We're currently building our team of expert consultants. Check back soon!
                            @endif
                        </p>
                        @if(isset($query) && $query)
                            <a href="{{ route('consultants') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                                View All Consultants
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-20 bg-blue-600 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-6">Ready to Get Started?</h2>
            <p class="text-xl mb-8 max-w-3xl mx-auto">
                Join thousands of businesses that have transformed their operations with our expert consulting services. 
                Connect with a consultant today and take your business to the next level.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('signup') }}" 
                   class="bg-white text-blue-600 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                    Sign Up Now
                </a>
                <a href="{{ route('login') }}" 
                   class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition duration-300">
                    Log In
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-16">
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('public-live-search');
            const grid = document.getElementById('consultants-grid');
            const pagination = document.getElementById('pagination-wrapper');
            const originalGridHtml = grid ? grid.innerHTML : '';
            const originalPaginationHtml = pagination ? pagination.innerHTML : '';
            let searchTimer = null;

            if (searchInput && grid) {
                searchInput.addEventListener('input', function () {
                    const q = this.value.trim();

                    clearTimeout(searchTimer);
                    searchTimer = setTimeout(() => {
                        if (q.length < 2) {
                            // Restore original server-rendered list when search is cleared/very short
                            grid.innerHTML = originalGridHtml;
                            if (pagination) {
                                pagination.innerHTML = originalPaginationHtml;
                            }
                            return;
                        }

                        fetch(`{{ route('public.consultants.api.all') }}?q=${encodeURIComponent(q)}`)
                            .then(response => response.json())
                            .then(data => {
                                if (!data.success) return;

                                const consultants = data.data || [];
                                if (!consultants.length) {
                                    grid.innerHTML = `
                                        <div class="col-span-full text-center py-16">
                                            <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"></path>
                                                </svg>
                                            </div>
                                            <h3 class="text-2xl font-bold text-gray-900 mb-4">No Consultants Found</h3>
                                            <p class="text-gray-600 mb-4">We couldn't find any consultants matching "<span class="font-semibold">${q}</span>".</p>
                                        </div>
                                    `;
                                    if (pagination) {
                                        pagination.innerHTML = '';
                                    }
                                    return;
                                }

                                if (pagination) {
                                    pagination.innerHTML = '';
                                }

                                grid.innerHTML = consultants.map(c => {
                                    const expertiseList = c.expertise
                                        ? c.expertise.split(',').map(item => item.trim()).filter(Boolean)
                                        : [];
                                    const expertiseHtml = expertiseList.length
                                        ? `<ul class="mt-2 text-sm text-gray-700 space-y-1 list-disc list-inside">
                                                ${expertiseList.map(item => `<li>${item}</li>`).join('')}
                                           </ul>`
                                        : `<p class="text-sm text-gray-500 mt-2">No expertise listed</p>`;

                                    const avatar = c.avatar_path
                                        ? `<img src="{{ asset('storage') }}/${c.avatar_path}" alt="${c.full_name}" class="h-full w-full object-cover">`
                                        : `<div class="h-full w-full flex items-center justify-center text-gray-500 text-2xl font-bold">
                                               ${c.full_name ? c.full_name.charAt(0) : '?'}
                                           </div>`;

                                    return `
                                        <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-xl transition duration-300 hover:border-blue-300">
                                            <div class="flex items-center mb-4">
                                                <div class="h-16 w-16 rounded-full overflow-hidden bg-gray-200 mr-4 flex-shrink-0">
                                                    ${avatar}
                                                </div>
                                                <div class="flex-1">
                                                    <h3 class="text-xl font-bold text-gray-900">${c.full_name}</h3>
                                                    ${expertiseHtml}
                                                    <div class="flex items-center mt-4 space-x-3">
                                                        <div class="flex items-center">
                                                            <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                            </svg>
                                                            <span class="text-sm text-green-600 font-medium">Verified</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="space-y-2 mb-4">
                                                <div class="flex items-center text-gray-600">
                                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <span class="text-sm">${c.email ?? ''}</span>
                                                </div>
                                            </div>
                                            <div class="flex space-x-3">
                                                <a href="{{ route('login') }}"
                                                   class="flex-1 bg-blue-600 text-white text-center py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300 font-semibold">
                                                    Request Consultation
                                                </a>
                                                <button class="bg-gray-100 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-200 transition duration-300">
                                                    View Profile
                                                </button>
                                            </div>
                                        </div>
                                    `;
                                }).join('');
                            })
                            .catch(error => {
                                console.error('Error fetching consultants:', error);
                            });
                    }, 300); // debounce
                });
            }
        });
    </script>

</body>
</html>
