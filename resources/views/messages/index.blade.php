@extends('layouts.app')

@section('content')
    <div class="body d-flex">
        <div class="container-xxl p-0">
            <div class="row g-0">
                <div class="col-12 d-flex">
                    <!-- Sidebar Chat List -->
                    <div class="card card-chat border-right border-top-0 border-bottom-0 w380">
                        <div class="px-4 py-3 py-md-4">
                            <!-- Search Box -->
                            <div class="input-group mb-3">
                                <input type="text" id="searchInput" class="form-control mb-1" placeholder="Tìm kiếm...">
                            </div>

                            <!-- Tabs Navigation -->
                            <div class="nav nav-pills justify-content-between text-center" role="tablist">
                                <a class="flex-fill rounded border-0 nav-link active" data-bs-toggle="tab"
                                    href="#chat-recent" role="tab" aria-selected="true">Chat</a>
                                <a class="flex-fill rounded border-0 nav-link" data-bs-toggle="tab" href="#chat-groups"
                                    role="tab" aria-selected="false">Nhóm</a>
                                <a class="flex-fill rounded border-0 nav-link" data-bs-toggle="tab" href="#chat-contact"
                                    role="tab" aria-selected="false">Liên hệ</a>
                            </div>
                        </div>

                        <div class="tab-content border-top">
                            <!-- Recent Chats Tab -->
                            <div class="tab-pane fade show active" id="chat-recent" role="tabpanel">
                                <ul class="list-unstyled list-group list-group-custom list-group-flush mb-0" id="recentChatList">
                                    @forelse($conversations as $conversation)
                                        <li class="list-group-item px-md-4 py-3 py-md-4 {{ $currentConversation && $currentConversation->id == $conversation->id ? 'active' : '' }}">
                                            <a href="{{ route('messages.index', ['conversation_id' => $conversation->id]) }}" class="d-flex">
                                                @if($conversation->type === 'private')
                                                    @php
                                                        $otherUser = $conversation->participants->where('id', '!=', $currentUser->id)->first();
                                                    @endphp
                                                    @if($otherUser)
                                                        @if($otherUser->image)
                                                            <img class="avatar rounded-circle" src="{{ asset('storage/' . $otherUser->image) }}" alt="">
                                                        @else
                                                            <div class="avatar rounded-circle no-thumbnail">
                                                                {{ strtoupper(substr($otherUser->name, 0, 2)) }}
                                                            </div>
                                                        @endif
                                                        <div class="flex-fill ms-3 text-truncate">
                                                            <h6 class="d-flex justify-content-between mb-0">
                                                                <span>{{ $otherUser->name }}</span>
                                                                <small class="msg-time">
                                                                    {{ $conversation->last_message_at ? $conversation->last_message_at->format('H:i') : '' }}
                                                                </small>
                                                            </h6>
                                                            <span class="text-muted">
                                                                {{ $conversation->lastMessage ? Str::limit($conversation->lastMessage->content, 50) : 'Chưa có tin nhắn' }}
                                                            </span>
                                                        </div>
                                                    @else
                                                        <div class="avatar rounded-circle no-thumbnail">U</div>
                                                        <div class="flex-fill ms-3 text-truncate">
                                                            <h6 class="d-flex justify-content-between mb-0">
                                                                <span>Cuộc trò chuyện</span>
                                                                <small class="msg-time">
                                                                    {{ $conversation->last_message_at ? $conversation->last_message_at->format('H:i') : '' }}
                                                                </small>
                                                            </h6>
                                                            <span class="text-muted">
                                                                {{ $conversation->lastMessage ? Str::limit($conversation->lastMessage->content, 50) : 'Chưa có tin nhắn' }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="avatar rounded-circle no-thumbnail">{{ strtoupper(substr($conversation->title ?: 'G', 0, 2)) }}</div>
                                                    <div class="flex-fill ms-3 text-truncate">
                                                        <h6 class="d-flex justify-content-between mb-0">
                                                            <span>{{ $conversation->title ?: 'Nhóm chat' }}</span>
                                                            <small class="msg-time">
                                                                {{ $conversation->last_message_at ? $conversation->last_message_at->format('H:i') : '' }}
                                                            </small>
                                                        </h6>
                                                        <span class="text-muted">
                                                            {{ $conversation->lastMessage ? $conversation->lastMessage->user->name . ': ' . Str::limit($conversation->lastMessage->content, 40) : 'Chưa có tin nhắn' }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </a>
                                        </li>
                                    @empty
                                        <li class="list-group-item px-md-4 py-3 py-md-4 text-center text-muted">
                                            Chưa có cuộc trò chuyện nào
                                        </li>
                                    @endforelse
                                </ul>
                            </div>

                            <!-- Groups Tab -->
                            <div class="tab-pane fade" id="chat-groups" role="tabpanel">
                                <div class="px-4 py-3">
                                    <button class="btn btn-primary btn-sm w-100 mb-3" data-bs-toggle="modal" data-bs-target="#createGroupModal">
                                        <i class="fa fa-plus"></i> Tạo nhóm mới
                                    </button>
                                </div>
                                <ul class="list-unstyled list-group list-group-custom list-group-flush mb-0">
                                    @forelse($groupConversations as $group)
                                        <li class="list-group-item px-md-4 py-3 py-md-4">
                                            <a href="{{ route('messages.index', ['conversation_id' => $group->id]) }}" class="d-flex">
                                                <div class="avatar rounded-circle no-thumbnail">{{ strtoupper(substr($group->title ?: 'G', 0, 2)) }}</div>
                                                <div class="flex-fill ms-3 text-truncate">
                                                    <h6 class="d-flex justify-content-between mb-0">
                                                        <span>{{ $group->title ?: 'Nhóm chat' }}</span>
                                                        <small class="msg-time">
                                                            {{ $group->last_message_at ? $group->last_message_at->format('d/m') : '' }}
                                                        </small>
                                                    </h6>
                                                    <span class="text-muted">{{ $group->participants->count() }} thành viên</span>
                                                </div>
                                            </a>
                                        </li>
                                    @empty
                                        <li class="list-group-item px-md-4 py-3 py-md-4 text-center text-muted">
                                            Chưa có nhóm chat nào
                                        </li>
                                    @endforelse
                                </ul>
                            </div>

                            <!-- Contacts Tab -->
                            <div class="tab-pane fade" id="chat-contact" role="tabpanel">
                                <div class="px-4 py-3">
                                    <small class="text-muted">Chọn người dùng để bắt đầu trò chuyện</small>
                                </div>
                                <ul class="list-unstyled list-group list-group-custom list-group-flush mb-0">
                                    @forelse($users as $user)
                                        <li class="list-group-item px-md-4 py-3 py-md-4">
                                            <form method="POST" action="{{ route('messages.start_conversation') }}" class="d-inline w-100">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <button type="submit" class="btn btn-link p-0 d-flex w-100 text-decoration-none">
                                                    @if($user->image)
                                                        <img class="avatar rounded-circle" src="{{ asset('storage/' . $user->image) }}" alt="">
                                                    @else
                                                        <div class="avatar rounded-circle no-thumbnail">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                                                    @endif
                                                    <div class="flex-fill ms-3 text-truncate text-start">
                                                        <div class="d-flex justify-content-between mb-0">
                                                            <h6 class="mb-0 text-dark">{{ $user->name }}</h6>
                                                            <div class="text-muted">
                                                                <i class="fa fa-comment text-primary"></i>
                                                            </div>
                                                        </div>
                                                        <span class="text-muted">{{ $user->email }}</span>
                                                    </div>
                                                </button>
                                            </form>
                                        </li>
                                    @empty
                                        <li class="list-group-item px-md-4 py-3 py-md-4 text-center text-muted">
                                            Không có người dùng nào
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Main Chat Area -->
                    <div class="card card-chat-body border-0 w-100 px-4 px-md-5 py-3 py-md-4">
                        @if($currentConversation)
                            <!-- Chat Header -->
                            <div class="chat-header d-flex justify-content-between align-items-center border-bottom pb-3">
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('messages.index') }}" title="Quay lại"><i class="icofont-arrow-left fs-4"></i></a>
                                    @if($currentConversation->type === 'private')
                                        @php
                                            $otherUser = $currentConversation->participants->where('id', '!=', $currentUser->id)->first();
                                        @endphp
                                        @if($otherUser)
                                            @if($otherUser->image)
                                                <img class="avatar rounded" src="{{ asset('storage/' . $otherUser->image) }}" alt="avatar">
                                            @else
                                                <div class="avatar rounded no-thumbnail">{{ strtoupper(substr($otherUser->name, 0, 2)) }}</div>
                                            @endif
                                            <div class="ms-3">
                                                <h6 class="mb-0">{{ $otherUser->name }}</h6>
                                                <small class="text-muted">{{ $otherUser->status === 'active' ? 'Đang hoạt động' : 'Không hoạt động' }}</small>
                                            </div>
                                        @else
                                            <div class="avatar rounded no-thumbnail">U</div>
                                            <div class="ms-3">
                                                <h6 class="mb-0">Cuộc trò chuyện</h6>
                                                <small class="text-muted">Không xác định</small>
                                            </div>
                                        @endif
                                    @else
                                        <div class="avatar rounded no-thumbnail">{{ strtoupper(substr($currentConversation->title ?: 'G', 0, 2)) }}</div>
                                        <div class="ms-3">
                                            <h6 class="mb-0">{{ $currentConversation->title ?: 'Nhóm chat' }}</h6>
                                            <small class="text-muted">{{ $currentConversation->participants->count() }} thành viên</small>
                                        </div>
                                    @endif
                                </div>
                                <div class="d-flex">
                                    @if($currentConversation->type === 'group')
                                        <a class="nav-link py-2 px-3 text-muted" href="#" data-bs-toggle="modal" data-bs-target="#addParticipantsModal"><i class="fa fa-user-plus"></i></a>
                                        <a class="nav-link py-2 px-3 text-muted" href="#" onclick="leaveGroup({{ $currentConversation->id }})"><i class="fa fa-sign-out"></i></a>
                                    @endif
                                    <a class="nav-link py-2 px-3 text-muted d-none d-lg-block" href="javascript:void(0);"><i class="fa fa-gear"></i></a>
                                    <a class="nav-link py-2 px-3 text-muted d-none d-lg-block" href="javascript:void(0);"><i class="fa fa-info-circle"></i></a>
                                </div>
                            </div>

                            <!-- Messages Area -->
                            <ul class="chat-history list-unstyled mb-0 py-lg-5 py-md-4 py-3 flex-grow-1" id="messagesList">
                                @forelse($messages as $message)
                                    <li class="mb-3 d-flex {{ $message->user_id == $currentUser->id ? 'flex-row-reverse' : 'flex-row' }} align-items-end">
                                        <div class="max-width-70 {{ $message->user_id == $currentUser->id ? 'text-right' : '' }}">
                                            @if($message->user_id != $currentUser->id)
                                                <div class="user-info mb-1">
                                                    @if($message->user->image)
                                                        <img src="{{ $message->user->image ? asset('storage/' . $message->user->image) : asset('assets/images/lg/avatar3.jpg') }}" alt="avatar" class="avatar sm rounded-circle me-1">
                                                    @else
                                                        <div class="avatar sm rounded-circle me-1 no-thumbnail">{{ strtoupper(substr($message->user->name, 0, 1)) }}</div>
                                                    @endif
                                                    <span class="text-muted small">{{ $message->created_at->format('H:i, d/m') }}</span>
                                                </div>
                                            @else
                                                <div class="user-info mb-1">
                                                    <span class="text-muted small">{{ $message->created_at->format('H:i, d/m') }}</span>
                                                </div>
                                            @endif

                                            <div class="card border-0 p-3 {{ $message->user_id == $currentUser->id ? 'bg-primary text-light' : '' }}">
                                                @if($message->type === 'system')
                                                    <div class="message text-center text-muted font-italic">
                                                        <small>{{ $message->content }}</small>
                                                    </div>
                                                @else
                                                    @if($currentConversation->type === 'group' && $message->user_id != $currentUser->id)
                                                        <small class="d-block mb-1 {{ $message->user_id == $currentUser->id ? 'text-light' : 'text-primary' }}">{{ $message->user->name }}</small>
                                                    @endif
                                                    <div class="message">{!! $message->formatted_content !!}</div>
                                                @endif
                                            </div>
                                        </div>
                                        @if($message->type !== 'system')
                                            <!-- More options -->
                                            <div class="btn-group">
                                                <a href="#" class="nav-link py-2 px-3 text-muted" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                                <ul class="dropdown-menu border-0 shadow">
                                                    @if($message->user_id == $currentUser->id)
                                                        <li><a class="dropdown-item" href="#">Sửa</a></li>
                                                    @endif
                                                    <li><a class="dropdown-item" href="#">Trả lời</a></li>
                                                    @if($message->user_id == $currentUser->id)
                                                        <li><a class="dropdown-item text-danger" href="#">Xóa</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        @endif
                                    </li>
                                @empty
                                    <li class="text-center text-muted py-5">
                                        <i class="fa fa-comments fa-3x mb-3"></i>
                                        <p>Chưa có tin nhắn nào. Hãy bắt đầu cuộc trò chuyện!</p>
                                    </li>
                                @endforelse
                            </ul>

                            <!-- Message Input -->
                            <div class="chat-message">
                                <form id="messageForm" method="POST" action="{{ route('messages.send') }}">
                                    @csrf
                                    <input type="hidden" name="conversation_id" value="{{ $currentConversation->id }}">
                                    <div class="input-group">
                                        <textarea
                                            class="form-control"
                                            name="content"
                                            id="messageInput"
                                            placeholder="Nhập tin nhắn..."
                                            rows="1"
                                            required></textarea>
                                        <button type="submit" class="btn btn-primary">
                                           <i class="icofont-airplane-alt"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <!-- No conversation selected -->
                            <div class="d-flex align-items-center justify-content-center h-100 flex-column">
                                <i class="fa fa-comments fa-5x text-muted mb-4"></i>
                                <h4 class="text-muted">Chọn một cuộc trò chuyện để bắt đầu</h4>
                                <p class="text-muted">Chọn từ danh sách bên trái hoặc bắt đầu cuộc trò chuyện mới</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Group Modal -->
    <div class="modal fade" id="createGroupModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('messages.create_group') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tạo nhóm chat mới</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="groupTitle" class="form-label">Tên nhóm</label>
                            <input type="text" class="form-control" id="groupTitle" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Thành viên</label>
                            @foreach($users as $user)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="participants[]" value="{{ $user->id }}" id="user{{ $user->id }}">
                                    <label class="form-check-label" for="user{{ $user->id }}">
                                        {{ $user->name }} ({{ $user->email }})
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Tạo nhóm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Participants Modal -->
    @if($currentConversation && $currentConversation->type === 'group')
    <div class="modal fade" id="addParticipantsModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('messages.add_participants', $currentConversation->id) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm thành viên</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @php
                            $existingParticipants = $currentConversation->participants->pluck('id')->toArray();
                            $availableUsers = $users->whereNotIn('id', $existingParticipants);
                        @endphp
                        @if($availableUsers->count() > 0)
                            @foreach($availableUsers as $user)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="participants[]" value="{{ $user->id }}" id="addUser{{ $user->id }}">
                                    <label class="form-check-label" for="addUser{{ $user->id }}">
                                        {{ $user->name }} ({{ $user->email }})
                                    </label>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">Không có người dùng nào để thêm vào nhóm.</p>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        @if($availableUsers->count() > 0)
                            <button type="submit" class="btn btn-primary">Thêm thành viên</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-resize textarea
    const messageInput = document.getElementById('messageInput');
    if (messageInput) {
        messageInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });

        // Send message on Enter (but not Shift+Enter)
        messageInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                document.getElementById('messageForm').submit();
            }
        });
    }

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const chatItems = document.querySelectorAll('#recentChatList .list-group-item');

            chatItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                if (text.includes(query)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }

    // Auto-scroll to bottom of messages
    const messagesList = document.getElementById('messagesList');
    if (messagesList) {
        messagesList.scrollTop = messagesList.scrollHeight;
    }

    // Polling for new messages (simple implementation)
    @if($currentConversation)
    let lastMessageId = {{ $messages->last() ? $messages->last()->id : 0 }};

    setInterval(function() {
        fetch(`{{ route('messages.get_messages', $currentConversation->id) }}?last_message_id=${lastMessageId}`)
            .then(response => response.json())
            .then(data => {
                if (data.messages && data.messages.length > 0) {
                    data.messages.forEach(message => {
                        appendMessage(message);
                        lastMessageId = Math.max(lastMessageId, message.id);
                    });
                    messagesList.scrollTop = messagesList.scrollHeight;
                }
            })
            .catch(error => console.error('Error fetching messages:', error));
    }, 3000); // Check every 3 seconds
    @endif
});

function appendMessage(message) {
    const messagesList = document.getElementById('messagesList');
    const isOwn = message.user_id == {{ $currentUser->id }};

    const messageHTML = `
        <li class="mb-3 d-flex ${isOwn ? 'flex-row-reverse' : 'flex-row'} align-items-end">
            <div class="max-width-70 ${isOwn ? 'text-right' : ''}">
                ${!isOwn ? `
                    <div class="user-info mb-1">
                        <div class="avatar sm rounded-circle me-1 no-thumbnail">${message.user.name.charAt(0).toUpperCase()}</div>
                        <span class="text-muted small">${new Date(message.created_at).toLocaleTimeString('vi-VN', {hour: '2-digit', minute:'2-digit'})}</span>
                    </div>
                ` : `
                    <div class="user-info mb-1">
                        <span class="text-muted small">${new Date(message.created_at).toLocaleTimeString('vi-VN', {hour: '2-digit', minute:'2-digit'})}</span>
                    </div>
                `}
                <div class="card border-0 p-3 ${isOwn ? 'bg-primary text-light' : ''}">
                    @if($currentConversation && $currentConversation->type === 'group')
                        ${!isOwn ? `<small class="d-block mb-1 text-primary">${message.user.name}</small>` : ''}
                    @endif
                    <div class="message">${message.content.replace(/\n/g, '<br>')}</div>
                </div>
            </div>
        </li>
    `;

    messagesList.insertAdjacentHTML('beforeend', messageHTML);
}

function leaveGroup(conversationId) {
    if (confirm('Bạn có chắc chắn muốn rời khỏi nhóm chat này?')) {
        fetch(`/messages/${conversationId}/leave`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = "{{ route('messages.index') }}";
            } else {
                alert('Có lỗi xảy ra khi rời khỏi nhóm');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra');
        });
    }
}
</script>

<style>
.w380 {
    width: 380px !important;
    min-width: 380px;
}

.max-width-70 {
    max-width: 70%;
}

.chat-history {
    max-height: 60vh;
    overflow-y: auto;
}

.avatar.sm {
    width: 32px;
    height: 32px;
    line-height: 32px;
    font-size: 14px;
}

.no-thumbnail {
    background: #f8f9fa;
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 500;
}

.list-group-item.active {
    background-color: #e3f2fd;
    border-color: #2196f3;
}

#messageInput {
    resize: none;
    min-height: 38px;
    max-height: 120px;
}

.chat-message {
    border-top: 1px solid #dee2e6;
    padding-top: 1rem;
}

@media (max-width: 768px) {
    .w380 {
        width: 100% !important;
        min-width: auto;
    }

    .max-width-70 {
        max-width: 85%;
    }
}
</style>
@endsection



