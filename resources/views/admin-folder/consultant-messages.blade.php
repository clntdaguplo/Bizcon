@extends('admin-folder.layout')

@section('title', 'Messages with Consultant')
@section('page-title', 'Messages with ' . $consultant->full_name)

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.consultants.show', $consultant->id) }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 bg-white rounded-lg border border-gray-300 hover:bg-gray-50 hover:text-gray-900 transition shadow-sm hover:shadow">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Profile
        </a>
    </div>

    <!-- Consultant Info Card -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 mb-6">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center">
                @if($consultant->avatar_path)
                    <img src="{{ asset('storage/'.$consultant->avatar_path) }}" alt="{{ $consultant->full_name }}" class="w-full h-full object-cover">
                @else
                    <span class="text-2xl font-bold text-gray-600">{{ substr($consultant->full_name ?? $consultant->user->name, 0, 1) }}</span>
                @endif
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $consultant->full_name ?? $consultant->user->name }}</h2>
                <p class="text-gray-600">{{ $consultant->email ?? $consultant->user->email }}</p>
            </div>
        </div>
    </div>

    <!-- Messages Container -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
            <div class="flex items-center">
                <div class="bg-white bg-opacity-20 p-2 rounded-lg mr-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Messages</h3>
                    <p class="text-blue-100 text-sm">Communication with consultant</p>
                </div>
            </div>
        </div>
        
        <div id="chat-messages" class="p-6 bg-gray-50" style="min-height: 400px; max-height: 600px; overflow-y: auto;">
            <div class="space-y-4">
                @if($messages->count() > 0)
                    @foreach($messages as $msg)
                        @if($msg->sender_type === 'admin')
                            <!-- Admin Message (Right Side) -->
                            <div class="flex items-start justify-end">
                                <div class="flex items-start space-x-3 max-w-[75%] flex-row-reverse">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center flex-shrink-0 shadow-md">
                                        <span class="text-white font-semibold text-sm">{{ substr($msg->sender->name ?? 'Admin', 0, 1) }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="bg-purple-600 text-white rounded-2xl rounded-tr-none px-4 py-3 shadow-md">
                                            <div class="flex items-center mb-1">
                                                <span class="text-sm font-semibold text-purple-100">You (Admin)</span>
                                                <span class="mx-2 text-purple-300">•</span>
                                                <span class="text-xs text-purple-200">{{ $msg->created_at->format('M j, g:i A') }}</span>
                                            </div>
                                            <p class="text-white leading-relaxed whitespace-pre-wrap">{{ $msg->message }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Consultant Message (Left Side) -->
                            <div class="flex items-start justify-start">
                                <div class="flex items-start space-x-3 max-w-[75%]">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center flex-shrink-0 shadow-md">
                                        <span class="text-white font-semibold text-sm">{{ substr($msg->sender->name ?? 'Consultant', 0, 1) }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="bg-white rounded-2xl rounded-tl-none px-4 py-3 shadow-sm border border-gray-200">
                                            <div class="flex items-center mb-1">
                                                <span class="text-sm font-semibold text-gray-900">{{ $msg->sender->name ?? 'Consultant' }}</span>
                                                <span class="mx-2 text-gray-400">•</span>
                                                <span class="text-xs text-gray-500">{{ $msg->created_at->format('M j, g:i A') }}</span>
                                            </div>
                                            <p class="text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $msg->message }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <p class="text-gray-600 font-medium">No messages yet</p>
                        <p class="text-gray-500 text-sm mt-1">Start a conversation with the consultant</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Message Input Form -->
        <div class="border-t border-gray-200 bg-white p-4">
            <form id="message-form" onsubmit="sendMessage(event, {{ $consultant->id }})" class="flex gap-2">
                @csrf
                <input type="text" 
                       id="message-input"
                       name="message" 
                       placeholder="Type your message..." 
                       required
                       class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="submit" 
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function sendMessage(event, consultantId) {
        event.preventDefault();
        
        const form = document.getElementById('message-form');
        const input = document.getElementById('message-input');
        const message = input.value.trim();
        
        if (!message) return;
        
        const formData = new FormData(form);
        const chatContainer = document.getElementById('chat-messages');
        
        // Disable form while sending
        form.querySelector('button[type="submit"]').disabled = true;
        
        fetch('{{ route("admin.consultants.messages.store", ":id") }}'.replace(':id', consultantId), {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': formData.get('_token'),
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.error || 'Failed to send message');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                input.value = '';
                loadMessages(consultantId);
            } else {
                alert(data.error || 'Failed to send message. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(error.message || 'Failed to send message. Please try again.');
        })
        .finally(() => {
            form.querySelector('button[type="submit"]').disabled = false;
        });
    }
    
    function loadMessages(consultantId) {
        fetch('{{ route("admin.consultants.messages.index", ":id") }}'.replace(':id', consultantId))
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const chatContainer = document.getElementById('chat-messages');
                    const messagesDiv = chatContainer.querySelector('.space-y-4');
                    
                    messagesDiv.innerHTML = '';
                    
                    if (data.messages && data.messages.length > 0) {
                        data.messages.forEach(msg => {
                            const isAdmin = msg.sender_type === 'admin';
                            const senderName = isAdmin ? 'You (Admin)' : (msg.sender?.name || 'Consultant');
                            const senderInitial = senderName.charAt(0).toUpperCase();
                            const time = new Date(msg.created_at).toLocaleString('en-US', { 
                                month: 'short', 
                                day: 'numeric', 
                                hour: 'numeric', 
                                minute: '2-digit',
                                hour12: true 
                            });
                            
                            if (isAdmin) {
                                messagesDiv.innerHTML += `
                                    <div class="flex items-start justify-end">
                                        <div class="flex items-start space-x-3 max-w-[75%] flex-row-reverse">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center flex-shrink-0 shadow-md">
                                                <span class="text-white font-semibold text-sm">${senderInitial}</span>
                                            </div>
                                            <div class="flex-1">
                                                <div class="bg-purple-600 text-white rounded-2xl rounded-tr-none px-4 py-3 shadow-md">
                                                    <div class="flex items-center mb-1">
                                                        <span class="text-sm font-semibold text-purple-100">${senderName}</span>
                                                        <span class="mx-2 text-purple-300">•</span>
                                                        <span class="text-xs text-purple-200">${time}</span>
                                                    </div>
                                                    <p class="text-white leading-relaxed whitespace-pre-wrap">${msg.message}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            } else {
                                messagesDiv.innerHTML += `
                                    <div class="flex items-start justify-start">
                                        <div class="flex items-start space-x-3 max-w-[75%]">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center flex-shrink-0 shadow-md">
                                                <span class="text-white font-semibold text-sm">${senderInitial}</span>
                                            </div>
                                            <div class="flex-1">
                                                <div class="bg-white rounded-2xl rounded-tl-none px-4 py-3 shadow-sm border border-gray-200">
                                                    <div class="flex items-center mb-1">
                                                        <span class="text-sm font-semibold text-gray-900">${senderName}</span>
                                                        <span class="mx-2 text-gray-400">•</span>
                                                        <span class="text-xs text-gray-500">${time}</span>
                                                    </div>
                                                    <p class="text-gray-800 leading-relaxed whitespace-pre-wrap">${msg.message}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            }
                        });
                    } else {
                        messagesDiv.innerHTML = `
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <p class="text-gray-600 font-medium">No messages yet</p>
                                <p class="text-gray-500 text-sm mt-1">Start a conversation with the consultant</p>
                            </div>
                        `;
                    }
                    
                    // Auto-scroll to bottom
                    chatContainer.scrollTop = chatContainer.scrollHeight;
                }
            })
            .catch(error => {
                console.error('Error loading messages:', error);
            });
    }
    
    // Auto-scroll chat to bottom on load
    document.addEventListener('DOMContentLoaded', function() {
        const chatContainer = document.getElementById('chat-messages');
        if (chatContainer) {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
        
        // Auto-refresh messages every 5 seconds
        setInterval(() => {
            loadMessages({{ $consultant->id }});
        }, 5000);
    });
</script>
@endsection

