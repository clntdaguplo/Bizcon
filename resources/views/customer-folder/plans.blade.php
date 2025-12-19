@extends('customer-folder.layout')

@section('title', 'Choose a Plan')
@section('page-title', 'Subscription Plans')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
            Choose the Right Plan for Your Growth
        </h2>
        <p class="mt-4 text-xl text-gray-600">
            Select a subscription that fits your consultation needs and unlock premium features.
        </p>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 bg-green-100 border-l-4 border-green-500 text-green-800 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-8 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded shadow-sm">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Pricing Tiers -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- Free Tier -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden flex flex-col transition-transform hover:scale-105">
            <div class="p-6 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">Free</h3>
                <p class="mt-4 flex items-baseline">
                    <span class="text-4xl font-extrabold tracking-tight text-gray-900">₱0</span>
                    <span class="ml-1 text-xl font-semibold text-gray-500">/mo</span>
                </p>
                <p class="mt-1 text-sm text-gray-500 italic">Limited access</p>
            </div>
            <div class="p-6 flex-1 flex flex-col">
                <ul class="space-y-4 mb-8">
                    <li class="flex items-start">
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span class="ml-3 text-sm text-gray-600">Limited Info Access</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span class="ml-3 text-sm text-gray-600">Standard Notifications</span>
                    </li>
                    <li class="flex items-start opacity-50">
                        <svg class="flex-shrink-0 h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                        <span class="ml-3 text-sm text-gray-500 line-through">Report Export</span>
                    </li>
                    <li class="flex items-start opacity-50">
                        <svg class="flex-shrink-0 h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                        <span class="ml-3 text-sm text-gray-500 line-through">Rating & Feedback</span>
                    </li>
                </ul>
                <form method="POST" action="{{ route('customer.plans.choose') }}" class="mt-auto">
                    @csrf
                    <input type="hidden" name="plan_type" value="Free">
                    <button type="submit" 
                            class="w-full bg-gray-200 text-gray-800 px-4 py-2 rounded-lg font-bold hover:bg-gray-300 transition disabled:opacity-50"
                            @if(!$isFreeAvailable) disabled @endif>
                        {{ $isFreeAvailable ? 'Activate Free' : 'Already Used' }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Weekly Tier -->
        <div class="bg-white rounded-2xl shadow-lg border-2 border-blue-500 overflow-hidden flex flex-col transition-transform hover:scale-105 relative">
            <div class="absolute top-0 right-0 bg-blue-500 text-white text-[10px] font-bold px-4 py-1 rounded-bl-lg uppercase tracking-wider">
                Popular
            </div>
            <div class="p-6 bg-blue-50 border-b border-blue-100">
                <h3 class="text-lg font-bold text-blue-900">Weekly</h3>
                <p class="mt-4 flex items-baseline text-blue-900">
                    <span class="text-4xl font-extrabold tracking-tight">₱299</span>
                    <span class="ml-1 text-xl font-semibold">/week</span>
                </p>
                <p class="mt-1 text-sm text-blue-600">Perfect for quick needs</p>
            </div>
            <div class="p-6 flex-1 flex flex-col">
                <ul class="space-y-4 mb-8">
                    <li class="flex items-start">
                        <svg class="flex-shrink-0 h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span class="ml-3 text-sm text-gray-700">Full Info Access</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="flex-shrink-0 h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span class="ml-3 text-sm text-gray-700">Rating & Feedback</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="flex-shrink-0 h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span class="ml-3 text-sm text-gray-700">Report Export (Wk/Mo)</span>
                    </li>
                    <li class="flex items-start opacity-50">
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-3 text-sm text-gray-500">Standard Support</span>
                    </li>
                </ul>
                <button type="button" onclick="openPaymentModal('Weekly', 299)" 
                        class="mt-auto w-full bg-blue-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-700 transition">
                    Get Weekly
                </button>
            </div>
        </div>

        <!-- Quarterly Tier -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden flex flex-col transition-transform hover:scale-105">
            <div class="p-6 bg-purple-50 border-b border-purple-100">
                <h3 class="text-lg font-bold text-purple-900">Quarterly</h3>
                <p class="mt-4 flex items-baseline text-purple-900">
                    <span class="text-4xl font-extrabold tracking-tight">₱999</span>
                    <span class="ml-1 text-xl font-semibold">/3mo</span>
                </p>
                <p class="mt-1 text-sm text-purple-600">Save 15% vs Weekly</p>
            </div>
            <div class="p-6 flex-1 flex flex-col">
                <ul class="space-y-4 mb-8">
                    <li class="flex items-start">
                        <svg class="flex-shrink-0 h-5 w-5 text-purple-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span class="ml-3 text-sm text-gray-700">All Weekly Features</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="flex-shrink-0 h-5 w-5 text-purple-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span class="ml-3 text-sm text-gray-700">Higher Export Limits</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="flex-shrink-0 h-5 w-5 text-purple-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span class="ml-3 text-sm text-gray-700">Priority Support</span>
                    </li>
                </ul>
                <button type="button" onclick="openPaymentModal('Quarterly', 999)" 
                        class="mt-auto w-full bg-purple-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-purple-700 transition">
                    Get Quarterly
                </button>
            </div>
        </div>

        <!-- Annual Tier -->
        <div class="bg-white rounded-2xl shadow-lg border-2 border-amber-500 overflow-hidden flex flex-col transition-transform hover:scale-105">
            <div class="p-6 bg-amber-50 border-b border-amber-100">
                <h3 class="text-lg font-bold text-amber-900">Annual</h3>
                <p class="mt-4 flex items-baseline text-amber-900">
                    <span class="text-4xl font-extrabold tracking-tight">₱3,499</span>
                    <span class="ml-1 text-xl font-semibold">/year</span>
                </p>
                <p class="mt-1 text-sm text-amber-600">Ultimate Value - Save 50%</p>
            </div>
            <div class="p-6 flex-1 flex flex-col">
                <ul class="space-y-4 mb-8">
                    <li class="flex items-start">
                        <svg class="flex-shrink-0 h-5 w-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span class="ml-3 text-sm text-gray-700">All Quarterly Features</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="flex-shrink-0 h-5 w-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span class="ml-3 text-sm text-gray-700">Unlimited Data / Export</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="flex-shrink-0 h-5 w-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span class="ml-3 text-sm text-gray-700">Premium Support</span>
                    </li>
                </ul>
                <button type="button" onclick="openPaymentModal('Annual', 3499)" 
                        class="mt-auto w-full bg-amber-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-amber-700 transition">
                    Get Annual
                </button>
            </div>
        </div>
    </div>

    <!-- Current Plan Summary -->
    <div class="mt-16 bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
        <h3 class="text-2xl font-bold text-gray-900 mb-6">Current Subscription Status</h3>
        @if($current)
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <p class="text-sm text-gray-500 uppercase font-bold tracking-wider">Active Plan</p>
                    <div class="flex items-center gap-3">
                        <span class="text-2xl font-extrabold text-blue-600">{{ $current->plan_type }}</span>
                        @php
                            $statusColor = match($current->payment_status) {
                                'approved', 'not_required' => 'bg-green-100 text-green-800',
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'rejected' => 'bg-red-100 text-red-800',
                                default => 'bg-gray-100 text-gray-800'
                            };
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusColor }}">
                            {{ ucfirst($current->payment_status) }}
                        </span>
                    </div>
                </div>

                @if($current->expires_at)
                <div class="space-y-2">
                    <p class="text-sm text-gray-500 uppercase font-bold tracking-wider">Expires On</p>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="font-bold text-gray-900">{{ $current->expires_at->format('M j, Y') }}</span>
                        @php $days = $current->days_remaining; @endphp
                        @if($days !== null)
                            <span class="text-xs px-2 py-1 rounded bg-blue-50 text-blue-700 font-bold">
                                {{ $days }} days left
                            </span>
                        @endif
                    </div>
                </div>
                @endif
                
                <div>
                     <a href="{{ route('customer.dashboard') }}" class="text-blue-600 font-bold hover:underline">Go to Dashboard →</a>
                </div>
            </div>
        @else
            <div class="text-center py-8">
                <div class="bg-gray-50 rounded-xl p-6 inline-block">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-gray-600">You don't have an active subscription yet.</p>
                    <p class="text-sm text-gray-500 mt-1">Select one of the plans above to start booking consultations.</p>
                </div>
            </div>
        @endif
    </div>

    <!-- History -->
    <div class="mt-12 overflow-hidden">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Subscription History</h3>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Plan</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Payment</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($history as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $item->created_at->format('M j, Y') }}</td>
                        <td class="px-6 py-4"><span class="font-bold text-gray-900">{{ $item->plan_type }}</span></td>
                        <td class="px-6 py-4">
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="uppercase">{{ $item->payment_method }}</span>
                                @if($item->proof_path)
                                <a href="{{ asset('storage/'.$item->proof_path) }}" target="_blank" class="ml-2 text-blue-500 hover:text-blue-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ match($item->payment_status){'approved', 'not_required'=>'text-green-600 bg-green-50', 'pending'=>'text-yellow-600 bg-yellow-50', default=>'text-red-600 bg-red-50'} }}">
                                {{ $item->payment_status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-400 italic">No history found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Dynamic Payment Modal -->
<div id="payment-modal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden p-4">
    <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 w-full max-w-lg overflow-hidden relative">
        <button type="button" onclick="closePaymentModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        
        <div class="p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-1">Upgrade to <span id="modal-plan-name" class="text-blue-600">Plan</span></h3>
            <p class="text-gray-600 mb-6">Complete your payment of <span id="modal-plan-price" class="font-bold text-gray-900">₱0</span></p>
            
            <form method="POST" action="{{ route('customer.plans.choose') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <input type="hidden" name="plan_type" id="input-plan-type">
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Select Payment Method</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="payment_method" value="gcash" class="peer sr-only" required checked>
                            <div class="p-4 border-2 border-gray-100 rounded-xl peer-checked:border-blue-500 peer-checked:bg-blue-50 transition text-center">
                                <span class="font-bold text-gray-900">GCash</span>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="payment_method" value="paymaya" class="peer sr-only" required>
                            <div class="p-4 border-2 border-gray-100 rounded-xl peer-checked:border-pink-500 peer-checked:bg-pink-50 transition text-center">
                                <span class="font-bold text-gray-900">Maya</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 text-center">
                    <p class="text-sm text-gray-600 mb-4 font-medium uppercase">Scan to Pay</p>
                    <img src="{{ asset('images/gcash-qr-instapay.jpg') }}" alt="QR Code" class="mx-auto w-48 h-48 object-contain rounded-lg shadow-sm border border-white">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Upload Payment Receipt</label>
                    <div class="relative group">
                        <input type="file" name="proof" accept="image/*" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                    </div>
                    <p class="mt-2 text-xs text-gray-400 italic">Please capture a screenshot of the successful transaction.</p>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-xl font-extrabold text-lg shadow-xl hover:bg-blue-700 transition-all hover:shadow-2xl">
                    Submit Payment Proof
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openPaymentModal(planName, price) {
        document.getElementById('modal-plan-name').textContent = planName;
        document.getElementById('modal-plan-price').textContent = '₱' + price.toLocaleString();
        document.getElementById('input-plan-type').value = planName;
        document.getElementById('payment-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closePaymentModal() {
        document.getElementById('payment-modal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal on escape key
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closePaymentModal();
    });
</script>
@endsection
