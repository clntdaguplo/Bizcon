@extends('customer-folder.layout')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
        <div class="max-w-3xl mx-auto">
            <div class="bg-white p-8 rounded-xl shadow-md">
                <h1 class="text-3xl font-bold mb-6">My Profile</h1>

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="flex items-center space-x-6">
                        <div class="h-24 w-24 rounded-full overflow-hidden bg-gray-200 flex-shrink-0 border border-gray-300">
                            @if($user->avatar_path)
                                <img src="{{ asset('storage/'.$user->avatar_path) }}" alt="{{ $user->name }}" class="h-full w-full object-cover" id="avatar-preview">
                            @else
                                <div class="h-full w-full flex items-center justify-center text-3xl font-semibold text-gray-600" id="avatar-placeholder">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="avatar">Profile Photo</label>
                            <input type="file" name="avatar" id="avatar" accept="image/*" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF, or WebP. Max size 2MB.</p>
                            @error('avatar')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required />
                            @error('name')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" value="{{ $user->email }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-100" disabled />
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Save Changes</button>
                        <a href="{{ route('dashboard.customer') }}" class="text-gray-600 hover:underline">Back to Dashboard</a>
                    </div>
                </form>
            </div>
        </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('avatar')?.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (!file) {
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                const preview = document.getElementById('avatar-preview');
                const placeholder = document.getElementById('avatar-placeholder');

                if (preview) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                } else if (placeholder) {
                    placeholder.innerHTML = '';
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Avatar preview';
                    img.className = 'h-full w-full object-cover';
                    placeholder.replaceWith(img);
                }
            };
            reader.readAsDataURL(file);
        });
    </script>
@endpush


