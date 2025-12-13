@extends('consultant-folder.layout')

@section('title', 'Messages with Admin')
@section('page-title', 'Messages with Admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-6">
    @php
        $profile = \App\Models\ConsultantProfile::where('user_id', Auth::id())->first();
        $messages = collect([]);
        if ($profile && \Illuminate\Support\Facades\Schema::hasTable('admin_consultant_messages')) {
            $messages = \App\Models\AdminConsultantMessage::where('consultant_profile_id', $profile->id)
                ->with('sender')
                ->orderBy('created_at', 'asc')
                ->get();
        }
    @endphp

    <!-- Messages Container -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden flex flex-col" style="height: calc(100vh - 200px); min-height: 600px;">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 flex-shrink-0">
            <div class="flex items-center">
                <div class="bg-white bg-opacity-20 p-2 rounded-lg mr-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Messages</h3>
                    <p class="text-blue-100 text-sm">Communication with admin</p>
                </div>
            </div>
        </div>
        
        <!-- Admin Info Card Inside Messages Container -->
        <div class="bg-white border-b border-gray-200 px-6 py-3 flex-shrink-0">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-gray-900">BizConsult Admin</h2>
                    <p class="text-xs text-gray-600">Administration Team</p>
                </div>
            </div>
        </div>
        
        <!-- Messages Area -->
        <div id="chat-messages" class="flex-1 p-6 bg-gray-50 overflow-y-auto overflow-x-hidden">
            <div class="space-y-4">
                @if($messages->count() > 0)
                    @foreach($messages as $msg)
                        @if($msg->sender_type === 'admin')
                            <!-- Admin Message (Left Side) -->
                            <div class="flex items-start justify-start">
                                <div class="flex items-start space-x-3 max-w-[75%]">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center flex-shrink-0 shadow-md">
                                        <span class="text-white font-semibold text-sm">{{ substr($msg->sender->name ?? 'Admin', 0, 1) }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="bg-white rounded-2xl rounded-tl-none px-4 py-3 shadow-sm border border-gray-200">
                                            <div class="flex items-center mb-1">
                                                <span class="text-sm font-semibold text-gray-900">Admin</span>
                                                <span class="mx-2 text-gray-400">•</span>
                                                <span class="text-xs text-gray-500">{{ $msg->created_at->format('M j, g:i A') }}</span>
                                            </div>
                                            <p class="text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $msg->message }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Consultant Message (Right Side) -->
                            <div class="flex items-start justify-end">
                                <div class="flex items-start space-x-3 max-w-[75%] flex-row-reverse">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center flex-shrink-0 shadow-md">
                                        <span class="text-white font-semibold text-sm">{{ substr($msg->sender->name ?? 'You', 0, 1) }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="bg-blue-600 text-white rounded-2xl rounded-tr-none px-4 py-3 shadow-md">
                                            <div class="flex items-center mb-1">
                                                <span class="text-sm font-semibold text-blue-100">You</span>
                                                <span class="mx-2 text-blue-300">•</span>
                                                <span class="text-xs text-blue-200">{{ $msg->created_at->format('M j, g:i A') }}</span>
                                            </div>
                                            <p class="text-white leading-relaxed whitespace-pre-wrap">{{ $msg->message }}</p>
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
                        <p class="text-gray-500 text-sm mt-1">Start a conversation with the admin</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Message Input Form -->
        <div class="border-t border-gray-200 bg-white p-4 flex-shrink-0">
            <form id="message-form" onsubmit="sendMessage(event)" class="flex gap-2">
                @csrf
                <input type="text" 
                       id="message-input"
                       name="message" 
                       placeholder="Type your message..." 
                       required
                       class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="submit" 
                        class="bg-blue-600 text-white px-5 py-2.5 rounded-lg hover:bg-blue-700 transition font-medium flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    @php
        $profile = \App\Models\ConsultantProfile::where('user_id', Auth::id())->first();
        $consultantId = $profile ? $profile->id : null;
    @endphp

    function sendMessage(event) {
        event.preventDefault();
        
        const form = document.getElementById('message-form');
        const input = document.getElementById('message-input');
        const message = input.value.trim();
        
        if (!message) return;
        
        @if($consultantId)
        const consultantId = {{ $consultantId }};
        @else
        alert('Profile not found. Please complete your profile first.');
        return;
        @endif
        
        const formData = new FormData(form);
        const chatContainer = document.getElementById('chat-messages');
        
        // Disable form while sending
        form.querySelector('button[type="submit"]').disabled = true;
        
        fetch('{{ route("consultant.messages.admin.store", ":id") }}'.replace(':id', consultantId), {
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
                loadMessages();
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
    
    function loadMessages() {
        @if($consultantId)
        const consultantId = {{ $consultantId }};
        @else
        return;
        @endif
        
        fetch('{{ route("consultant.messages.admin.index", ":id") }}'.replace(':id', consultantId))
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const chatContainer = document.getElementById('chat-messages');
                    const messagesDiv = chatContainer.querySelector('.space-y-4');
                    
                    messagesDiv.innerHTML = '';
                    
                    if (data.messages && data.messages.length > 0) {
                        data.messages.forEach(msg => {
                            const isAdmin = msg.sender_type === 'admin';
                            const senderName = isAdmin ? 'Admin' : 'You';
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
                                    <div class="flex items-start justify-start">
                                        <div class="flex items-start space-x-3 max-w-[75%]">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center flex-shrink-0 shadow-md">
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
                            } else {
                                messagesDiv.innerHTML += `
                                    <div class="flex items-start justify-end">
                                        <div class="flex items-start space-x-3 max-w-[75%] flex-row-reverse">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center flex-shrink-0 shadow-md">
                                                <span class="text-white font-semibold text-sm">${senderInitial}</span>
                                            </div>
                                            <div class="flex-1">
                                                <div class="bg-blue-600 text-white rounded-2xl rounded-tr-none px-4 py-3 shadow-md">
                                                    <div class="flex items-center mb-1">
                                                        <span class="text-sm font-semibold text-blue-100">${senderName}</span>
                                                        <span class="mx-2 text-blue-300">•</span>
                                                        <span class="text-xs text-blue-200">${time}</span>
                                                    </div>
                                                    <p class="text-white leading-relaxed whitespace-pre-wrap">${msg.message}</p>
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
                                <p class="text-gray-500 text-sm mt-1">Start a conversation with the admin</p>
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
        @if($consultantId)
        setInterval(() => {
            loadMessages();
        }, 5000);
        @endif
    });
</script>
@endsection
