@extends('admin_layout')
@section('admin_messages')
<style>
    .chat-shell {
        background: linear-gradient(180deg, #fff7ed 0%, #ffffff 18%);
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 24px 50px rgba(15, 23, 42, 0.08);
    }
    .chat-sidebar {
        border-right: 1px solid #e5e7eb;
        background: #fff;
        height: 72vh;
        overflow-y: auto;
    }
    .chat-thread {
        height: 72vh;
        display: flex;
        flex-direction: column;
        background:
            radial-gradient(circle at top right, rgba(255, 237, 213, 0.9), transparent 38%),
            linear-gradient(180deg, #fffaf5 0%, #ffffff 100%);
    }
    .chat-thread-body {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
    }
    .chat-conversation-item {
        display: block;
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #0f172a;
        text-decoration: none;
    }
    .chat-conversation-item.active,
    .chat-conversation-item:hover {
        background: #fff7ed;
        color: #c2410c;
    }
    .chat-bubble-row {
        display: flex;
        margin-bottom: 14px;
    }
    .chat-bubble-row.is-admin {
        justify-content: flex-end;
    }
    .chat-bubble {
        max-width: 72%;
        padding: 12px 16px;
        border-radius: 20px;
        box-shadow: 0 12px 26px rgba(15, 23, 42, 0.08);
    }
    .chat-bubble-row.is-user .chat-bubble {
        background: #fff;
        border-bottom-left-radius: 8px;
    }
    .chat-bubble-row.is-admin .chat-bubble {
        background: linear-gradient(135deg, #f97316, #fb923c);
        color: #fff;
        border-bottom-right-radius: 8px;
    }
    .chat-meta {
        display: block;
        font-size: 11px;
        opacity: 0.75;
        margin-top: 6px;
    }
    .chat-compose {
        border-top: 1px solid #e5e7eb;
        padding: 16px;
        background: #fff;
    }
    .chat-empty {
        padding: 80px 24px;
        text-align: center;
        color: #64748b;
    }
</style>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Nhắn tin khách hàng</h1>
            <p class="mb-0 text-muted">Theo dõi và phản hồi hội thoại giữa admin và người dùng theo thời gian thực kiểu polling.</p>
        </div>
    </div>

    <div class="chat-shell">
        <div class="row no-gutters">
            <div class="col-lg-4 col-xl-3">
                <div class="chat-sidebar" id="adminConversationList">
                    @forelse($conversations as $conversation)
                        <a href="{{ url('/admin-messages?user_id=' . $conversation->id) }}"
                            class="chat-conversation-item {{ (int) $selectedUserId === (int) $conversation->id ? 'active' : '' }}"
                            data-user-id="{{ $conversation->id }}">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <strong>{{ $conversation->name }}</strong>
                                @if((int) $conversation->unread_count > 0)
                                    <span class="badge badge-danger">{{ $conversation->unread_count }}</span>
                                @endif
                            </div>
                            <div class="small text-muted mb-1">{{ $conversation->email }}</div>
                            <div class="small text-truncate">{{ $conversation->latest_message_text }}</div>
                        </a>
                    @empty
                        <div class="chat-empty">Chưa có khách hàng nào nhắn tin.</div>
                    @endforelse
                </div>
            </div>
            <div class="col-lg-8 col-xl-9">
                <div class="chat-thread">
                    <div class="p-4 border-bottom bg-white" id="adminChatHeader">
                        @if($selectedUser)
                            <h4 class="mb-1">{{ $selectedUser->name }}</h4>
                            <div class="text-muted">{{ $selectedUser->email }}</div>
                        @else
                            <h4 class="mb-1">Chưa có hội thoại</h4>
                            <div class="text-muted">Khi người dùng nhắn tin, cuộc trò chuyện sẽ xuất hiện ở đây.</div>
                        @endif
                    </div>
                    <div class="chat-thread-body" id="adminChatBody">
                        @if($selectedUser)
                            @foreach($messages as $message)
                                <div class="chat-bubble-row {{ $message['sender_type'] === 'admin' ? 'is-admin' : 'is-user' }}">
                                    <div class="chat-bubble">
                                        <div>{{ $message['message_text'] }}</div>
                                        <span class="chat-meta">{{ $message['created_at'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="chat-empty">Chọn một khách hàng để xem hội thoại.</div>
                        @endif
                    </div>
                    <div class="chat-compose">
                        @if($selectedUser)
                            <form id="adminChatForm">
                                @csrf
                                <div class="input-group">
                                    <input type="text" class="form-control" id="adminChatInput" placeholder="Nhập phản hồi cho khách hàng..." maxlength="2000">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">Gửi</button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="text-muted">Chưa thể gửi tin nhắn vì chưa có khách hàng nào được chọn.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($selectedUser)
<script>
    (function () {
        var selectedUserId = {{ (int) $selectedUserId }};
        var chatBody = document.getElementById('adminChatBody');
        var chatHeader = document.getElementById('adminChatHeader');
        var form = document.getElementById('adminChatForm');
        var input = document.getElementById('adminChatInput');
        var conversationList = document.getElementById('adminConversationList');
        var pollingTimer = null;

        function escapeHtml(text) {
            return (text || '').replace(/[&<>"']/g, function (char) {
                return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[char];
            });
        }

        function renderMessages(messages) {
            if (!messages.length) {
                chatBody.innerHTML = '<div class="chat-empty">Chưa có tin nhắn nào.</div>';
                return;
            }

            chatBody.innerHTML = messages.map(function (message) {
                var isAdmin = message.sender_type === 'admin';
                return '<div class="chat-bubble-row ' + (isAdmin ? 'is-admin' : 'is-user') + '">' +
                    '<div class="chat-bubble">' +
                        '<div>' + escapeHtml(message.message_text) + '</div>' +
                        '<span class="chat-meta">' + escapeHtml(message.created_at) + '</span>' +
                    '</div>' +
                '</div>';
            }).join('');

            chatBody.scrollTop = chatBody.scrollHeight;
        }

        function renderConversations(conversations) {
            if (!conversations.length) {
                return;
            }

            conversationList.innerHTML = conversations.map(function (conversation) {
                return '<a href="/admin-messages?user_id=' + conversation.id + '" class="chat-conversation-item ' + (Number(conversation.id) === selectedUserId ? 'active' : '') + '" data-user-id="' + conversation.id + '">' +
                    '<div class="d-flex justify-content-between align-items-start mb-1">' +
                        '<strong>' + escapeHtml(conversation.name) + '</strong>' +
                        (Number(conversation.unread_count) > 0 ? '<span class="badge badge-danger">' + conversation.unread_count + '</span>' : '') +
                    '</div>' +
                    '<div class="small text-muted mb-1">' + escapeHtml(conversation.email) + '</div>' +
                    '<div class="small text-truncate">' + escapeHtml(conversation.latest_message_text) + '</div>' +
                '</a>';
            }).join('');
        }

        function loadConversation() {
            fetch('/admin-messages/' + selectedUserId, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(function (response) { return response.json(); })
                .then(function (data) {
                    chatHeader.innerHTML = '<h4 class="mb-1">' + escapeHtml(data.user.name) + '</h4><div class="text-muted">' + escapeHtml(data.user.email) + '</div>';
                    renderMessages(data.messages || []);
                    renderConversations(data.conversations || []);
                });
        }

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            var message = input.value.trim();
            if (!message) {
                return;
            }

            fetch('/admin-messages/' + selectedUserId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message_text: message })
            })
                .then(function (response) { return response.json(); })
                .then(function (data) {
                    input.value = '';
                    renderMessages(data.messages || []);
                    renderConversations(data.conversations || []);
                });
        });

        pollingTimer = setInterval(loadConversation, 4000);

        window.addEventListener('beforeunload', function () {
            if (pollingTimer) {
                clearInterval(pollingTimer);
            }
        });

        renderMessages(@json($messages));
    })();
</script>
@endif
@endsection
