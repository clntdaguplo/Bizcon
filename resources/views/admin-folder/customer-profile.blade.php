@extends('admin-folder.layout')

@section('title', 'Customer Profile')
@section('page-title', 'Customer Profile')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Customer Profile</h2>
            <p class="text-gray-600">Detailed information for this customer</p>
        </div>
        <a href="{{ route('admin.customers') }}" class="inline-flex items-center px-4 py-2 rounded-md border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            Back to All Customers
        </a>
    </div>

    <!-- Profile Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center">
                <span class="text-2xl font-semibold text-green-700">{{ substr($customer->name, 0, 1) }}</span>
            </div>
            <div>
                <h3 class="text-xl font-semibold text-gray-900">{{ $customer->name }}</h3>
                <p class="text-sm text-gray-500">Customer ID: #{{ $customer->id }}</p>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-sm font-semibold text-gray-700 mb-2">Contact Information</h4>
                <dl class="space-y-2 text-sm text-gray-700">
                    <div class="flex justify-between">
                        <dt class="font-medium">Email</dt>
                        <dd class="text-gray-900">
                            <a href="mailto:{{ $customer->email }}" class="text-blue-600 hover:underline">
                                {{ $customer->email }}
                            </a>
                        </dd>
                    </div>
                </dl>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-gray-700 mb-2">Account Details</h4>
                <dl class="space-y-2 text-sm text-gray-700">
                    <div class="flex justify-between">
                        <dt class="font-medium">Role</dt>
                        <dd class="text-gray-900">{{ $customer->role ?? 'Customer' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-medium">Joined</dt>
                        <dd class="text-gray-900">{{ $customer->created_at?->format('M d, Y H:i') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-medium">Last Updated</dt>
                        <dd class="text-gray-900">{{ $customer->updated_at?->diffForHumans() }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection


