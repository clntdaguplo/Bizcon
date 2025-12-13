@extends('admin-folder.layout')

@section('title', 'Payments')
@section('page-title', 'Payment Approvals')

@section('content')
<div class="max-w-6xl mx-auto">
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    <form method="GET" class="mb-4 flex items-center gap-3">
        <label class="text-sm font-medium text-gray-700">Recent filter:</label>
        <select name="status" class="border rounded-md px-3 py-2 text-sm">
            <option value="all" {{ ($filter ?? 'all') === 'all' ? 'selected' : '' }}>All</option>
            <option value="approved" {{ ($filter ?? '') === 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ ($filter ?? '') === 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
        <button class="px-3 py-2 bg-gray-800 text-white rounded-md text-sm">Apply</button>
    </form>

    <div class="mb-8">
        <h3 class="text-xl font-semibold mb-3">Pending Payments ({{ $pending->count() }})</h3>
        @if($pending->count() > 0)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Method</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Proof</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submitted</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($pending as $sub)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $sub->user->name ?? 'Customer' }}</div>
                                    <div class="text-sm text-gray-500">{{ $sub->user->email ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ strtoupper($sub->payment_method ?? 'gcash') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($sub->proof_path)
                                        <a href="{{ asset('storage/'.$sub->proof_path) }}" target="_blank" class="text-blue-600 hover:underline">View proof</a>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $sub->created_at->format('M d, Y g:i A') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <form method="POST" action="{{ route('admin.payments.approve', $sub->id) }}">
                                            @csrf
                                            <button class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">Approve</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.payments.reject', $sub->id) }}">
                                            @csrf
                                            <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Reject</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-600">No pending payments.</p>
        @endif
    </div>

    <div>
        <h3 class="text-xl font-semibold mb-3">Recent Decisions ({{ $recent->count() }})</h3>
        @if($recent->count() > 0)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Method</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Proof</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Expires</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Updated</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recent as $sub)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $sub->user->name ?? 'Customer' }}</div>
                                    <div class="text-sm text-gray-500">{{ $sub->user->email ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ strtoupper($sub->payment_method ?? 'gcash') }}
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
                                        $statusColor = $sub->payment_status === 'approved' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-semibold rounded {{ $statusColor }}">
                                        {{ ucfirst($sub->payment_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($sub->expires_at)
                                        <div>{{ $sub->expires_at->format('M d, Y') }}</div>
                                        @if($sub->expires_at->isFuture())
                                            <div class="text-xs text-green-600">Expires in {{ $sub->expires_at->diffForHumans() }}</div>
                                        @else
                                            <div class="text-xs text-red-600">Expired {{ $sub->expires_at->diffForHumans() }}</div>
                                        @endif
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $sub->updated_at->diffForHumans() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-600">No recent approvals yet.</p>
        @endif
    </div>
</div>
@endsection

