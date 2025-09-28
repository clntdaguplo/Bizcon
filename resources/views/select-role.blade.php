@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">

        {{-- Flash success message --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Flash error message --}}
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <h2 class="text-2xl font-bold mb-6 text-center">Select Your Role</h2>

        <form method="POST" action="{{ route('role.save') }}">
            @csrf

            {{-- Role selection dropdown --}}
            <div class="mb-6">
                <label for="role" class="block text-gray-700 font-medium mb-2">Choose your role:</label>
                <select name="role" id="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-400" required>
                    <option value="" disabled selected>Select a role</option>
                    <option value="Customer">Customer</option>
                    <option value="Consultant">Consultant</option>
                </select>
                @error('role')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Submit button --}}
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                Save Role
            </button>
        </form>
    </div>
</div>
@endsection