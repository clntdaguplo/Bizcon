@extends('customer-folder.layout')

@section('title', 'Consultants')
@section('page-title', 'All Consultants')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Our Expert Consultants</h1>
                    <p class="text-gray-600">Discover our verified professionals ready to help your business succeed</p>
                </div>
                <div class="mt-4 lg:mt-0">
                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Verified Consultants</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Form -->
            <form method="GET" action="{{ route('customer.consultants') }}" class="mb-6">
                <div class="flex flex-col sm:flex-row gap-3">
                    <input type="text" name="q" id="live-search" value="{{ $query ?? '' }}" 
                           placeholder="Search by expertise, name, or email..." 
                           class="flex-1 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           autocomplete="off">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300 font-semibold">
                        Search Consultants
                    </button>
                </div>
            </form>

            @if(isset($query) && $query)
                <div class="text-center mb-4">
                    <p class="text-gray-600">Search results for: <span class="font-semibold text-gray-900">"{{ $query }}"</span></p>
                    <a href="{{ route('customer.consultants') }}" class="text-blue-600 hover:underline text-sm">Clear search</a>
                </div>
            @endif
        </div>

        <!-- Consultants Grid -->
        <div class="bg-white rounded-xl shadow p-6">
            <div id="consultants-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($consultants as $c)
                    <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-xl transition duration-300 hover:border-blue-300">
                        <!-- Consultant Avatar and Basic Info -->
                        <div class="flex items-center mb-4">
                            <div class="h-16 w-16 rounded-full overflow-hidden bg-gray-200 mr-4 flex-shrink-0">
                                @if($c->avatar_path)
                                    <img src="{{ asset('storage/'.$c->avatar_path) }}" 
                                         alt="{{ $c->full_name }}" 
                                         class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full flex items-center justify-center text-gray-500 text-2xl font-bold">
                                        {{ substr($c->full_name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-gray-900">{{ $c->full_name }}</h3>
                                <p class="text-blue-600 font-semibold">{{ $c->expertise }}</p>
                                <div class="flex items-center mt-2 space-x-3">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-sm text-green-600 font-medium">Verified</span>
                                    </div>
                                    @if($c->average_rating)
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= round($c->average_rating))
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
                                <span class="text-sm">{{ $c->email }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-3">
                            @if(Auth::user()->isTrialExhausted())
                                <button disabled 
                                   class="flex-1 bg-gray-200 text-gray-400 cursor-not-allowed text-center py-2 px-4 rounded-lg font-semibold border border-gray-300">
                                    Trial Exhausted
                                </button>
                            @else
                                <a href="{{ route('customer.consultants.request', $c->id) }}" 
                                   class="flex-1 bg-blue-600 text-white text-center py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300 font-semibold">
                                    Request Consultation
                                </a>
                            @endif
                            <button class="bg-gray-100 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-200 transition duration-300">
                                View Profile
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16">
                        <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">No Consultants Available</h3>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">
                            We're currently building our team of expert consultants. Check back soon!
                        </p>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $consultants->links() }}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const requestButtons = document.querySelectorAll('a[href*="/consultants/request/"]');
        const searchInput = document.getElementById('live-search');
        const grid = document.getElementById('consultants-grid');
        const originalGridHtml = grid ? grid.innerHTML : '';
        let searchTimer = null;

        // Confirm before requesting consultation
        requestButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                if (confirm('Are you sure you want to request this consultation?')) {
                    window.location.href = this.href;
                }
            });
        });

        // Live search (autocomplete-style)
        if (searchInput && grid) {
            searchInput.addEventListener('input', function () {
                const q = this.value.trim();

                clearTimeout(searchTimer);
                searchTimer = setTimeout(() => {
                    if (q.length < 2) {
                        // Restore original server-rendered list when search is cleared/very short
                        grid.innerHTML = originalGridHtml;
                        return;
                    }

                    fetch(`{{ route('customer.consultants.api.all') }}?q=${encodeURIComponent(q)}`)
                        .then(response => response.json())
                        .then(data => {
                            if (!data.success) return;

                            const consultants = data.data || [];
                            if (!consultants.length) {
                                grid.innerHTML = `
                                    <div class="col-span-full text-center py-10 text-gray-500">
                                        No consultants match "<span class="font-semibold">${q}</span>".
                                    </div>
                                `;
                                return;
                            }

                            grid.innerHTML = consultants.map(c => {
                                const expertiseList = c.expertise
                                    ? c.expertise.split(',').map(item => item.trim()).filter(Boolean)
                                    : [];
                                const expertiseHtml = expertiseList.length
                                    ? `<ul class="mt-1 text-xs text-gray-600 space-y-0.5 list-disc list-inside">
                                            ${expertiseList.map(item => `<li>${item}</li>`).join('')}
                                       </ul>`
                                    : `<p class="text-xs text-gray-500 mt-1">No expertise listed</p>`;

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
                                            ${@json(Auth::user()->isTrialExhausted()) 
                                                ? `<button disabled class="flex-1 bg-gray-200 text-gray-400 cursor-not-allowed text-center py-2 px-4 rounded-lg font-semibold border border-gray-300">Trial Exhausted</button>`
                                                : `<a href="/customer/consultants/${c.id}/request" class="flex-1 bg-blue-600 text-white text-center py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300 font-semibold">Request Consultation</a>`
                                            }
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
@endsection
