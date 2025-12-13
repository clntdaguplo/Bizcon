@extends('customer-folder.layout')

@section('title', 'Choose a Plan')
@section('page-title', 'Subscription Plans')

@section('content')
<div class="max-w-4xl mx-auto">
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="border border-gray-200 rounded-xl p-6 bg-white shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-xl font-semibold">Free Trial</h3>
                <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">20 mins</span>
            </div>
            <p class="text-gray-600 mb-4">Try a one-time 20-minute consultation. No payment needed.</p>
            <form method="POST" action="{{ route('customer.plans.choose') }}">
                @csrf
                <input type="hidden" name="plan_type" value="free_trial">
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-60"
                    @if(!$trialAvailable) disabled @endif>
                    @if($trialAvailable)
                        Activate Free Trial
                    @else
                        Already used
                    @endif
                </button>
            </form>
        </div>

        <div class="border border-indigo-200 rounded-xl p-6 bg-white shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-xl font-semibold">Subscription Plan</h3>
            </div>
            <form method="POST" action="{{ route('customer.plans.choose') }}" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <input type="hidden" name="plan_type" value="pro">
                <div>
                    <label class="block text-sm font-medium mb-1">Payment method</label>
                    <select name="payment_method" class="w-full border rounded-md px-3 py-2" required>
                        <option value="">Select a method</option>
                        <option value="gcash">GCash (upload proof)</option>
                        <option value="paymaya">PayMaya (upload proof)</option>
                    </select>
                </div>
                <div>
                    <button type="button" onclick="openGcashModal()" class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-10v.01M12 21c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8z"/>
                        </svg>
                        Pay via GCash
                    </button>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Payment proof (for GCash)</label>
                    <input type="file" name="proof" accept="image/*" class="w-full text-sm" required>
                </div>
                <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    Submit Payment
                </button>
            </form>
        </div>
    </div>

    <div class="mt-8">
        <h4 class="text-lg font-semibold mb-3">Current status</h4>
        @if($current)
            <div class="border border-gray-200 bg-white rounded-xl p-4 shadow-sm">
                <p class="font-medium flex items-center gap-2">
                    {{ $current->plan_type === 'pro' ? 'Subscriber' : 'Plan: ' . ucfirst(str_replace('_', ' ', $current->plan_type)) }}
                    @php
                        $badgeColor = match($current->payment_status) {
                            'approved', 'not_required' => 'bg-green-100 text-green-800',
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'rejected' => 'bg-red-100 text-red-800',
                            default => 'bg-gray-100 text-gray-800'
                        };
                        $statusText = str_replace('_', ' ', $current->payment_status);
                    @endphp
                    <span class="text-xs px-2 py-1 rounded {{ $badgeColor }}">
                        {{ ucfirst($statusText) }}
                    </span>
                </p>
                <p class="text-sm text-gray-600">Status: {{ ucfirst($current->status) }}</p>
                @if($current->plan_type === 'pro' && $current->days_remaining !== null)
                    @php
                        $days = $current->days_remaining;
                        $badgeColor = match(true) {
                            $days <= 0 => 'bg-red-100 text-red-800',
                            $days <= 3 => 'bg-yellow-100 text-yellow-800',
                            $days <= 7 => 'bg-green-100 text-green-800',
                            default => 'bg-blue-100 text-blue-800'
                        };
                    @endphp
                    <p class="text-sm text-gray-600 mt-2">
                        Days remaining: 
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold {{ $badgeColor }}">
                            {{ $days }}
                        </span>
                    </p>
                @endif
            </div>
        @else
            <p class="text-gray-600">No active plan yet.</p>
        @endif
    </div>

    <div class="mt-8">
        <h4 class="text-lg font-semibold mb-3">Payment history</h4>
        @if($history && $history->count() > 0)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Plan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Method</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Proof</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($history as $sub)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $sub->created_at->format('M d, Y g:i A') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $sub->plan_type === 'pro' ? 'Subscriber' : 'Free trial' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ strtoupper($sub->payment_method ?? 'N/A') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($sub->proof_path)
                                        <a href="{{ asset('storage/'.$sub->proof_path) }}" target="_blank" class="text-blue-600 hover:underline">View proof</a>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColor = match($sub->payment_status) {
                                            'approved', 'not_required' => 'bg-green-100 text-green-800',
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        };
                                        $statusText = str_replace('_', ' ', $sub->payment_status);
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-semibold rounded {{ $statusColor }}">
                                        {{ ucfirst($statusText) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-600">No payment history yet.</p>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openGcashModal() {
        const modal = document.getElementById('gcash-modal');
        if (modal) modal.classList.remove('hidden');
    }
    function closeGcashModal() {
        const modal = document.getElementById('gcash-modal');
        if (modal) modal.classList.add('hidden');
    }
</script>

<!-- GCash QR Modal -->
<div id="gcash-modal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 w-full max-w-md p-6 relative">
        <button type="button" onclick="closeGcashModal()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <div class="text-center space-y-3">
            <h3 class="text-lg font-semibold text-gray-900">Pay with GCash</h3>
            <p class="text-sm text-gray-600">Scan the QR code below to complete your payment.</p>
            <div class="border border-gray-200 rounded-xl p-4 bg-gray-50">
                <img src="{{ asset('images/gcash-qr-instapay.jpg') }}" alt="GCash QR Code" class="mx-auto w-full max-w-xs h-auto object-contain">
                <p class="text-xs text-gray-500 mt-3">Scan with GCash or any InstaPay scanner.</p>
            </div>
        </div>
    </div>
</div>
@endsection

