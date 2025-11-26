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
                            <span>{{ $consultants->total() }} Verified Consultants</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Form -->
            <form method="GET" action="{{ route('customer.consultants') }}" class="mb-6">
                <div class="flex flex-col sm:flex-row gap-3">
                    <input type="text" name="q" value="{{ $query ?? '' }}" 
                           placeholder="Search by expertise, name, or email..." 
                           class="flex-1 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
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
                                <div class="flex items-center mt-1">
                                    <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm text-green-600 font-medium">Verified</span>
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
                            @if($c->phone_number)
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <span class="text-sm">{{ $c->phone_number }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-3">
                            <a href="{{ route('customer.consultants.request', $c->id) }}" 
                               class="flex-1 bg-blue-600 text-white text-center py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300 font-semibold">
                                Request Consultation                            </a>
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

        requestButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                // Prevent the link from navigating immediately
                event.preventDefault();
                
                // Show a confirmation dialog
                if (confirm('Are you sure you want to request this consultation?')) {
                    window.location.href = this.href;
                }
            });
        });
    });
    // AJAX functionality for fetching consultants
    function fetchAllConsultants() {
        fetch('{{ route("customer.consultants.api.all") }}')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Total consultants:', data.total);
                    console.log('Consultants data:', data.data);
                    // You can use this data for dynamic updates
                }
            })
            .catch(error => {
                console.error('Error fetching consultants:', error);
            });
    }

    // Fetch consultant statistics
    function fetchConsultantStats() {
        fetch('{{ route("customer.consultants.api.stats") }}')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Consultant statistics:', data.stats);
                    // Update UI with statistics if needed
                }
            })
            .catch(error => {
                console.error('Error fetching stats:', error);
            });
    }

    // Auto-refresh functionality (optional)
    // setInterval(fetchAllConsultants, 30000); // Refresh every 30 seconds
</script>
@endsection
