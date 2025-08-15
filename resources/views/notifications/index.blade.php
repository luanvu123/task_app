@extends('layouts.app')

@section('title', 'Thông báo')

@section('content')
<div class="container-xxl">
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0">Thông báo</h3>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-sm" id="markAllReadBtn">
                        <i class="icofont-check-alt"></i> Đánh dấu tất cả đã đọc
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if($notifications->count() > 0)
                        <div class="notifications-list">
                            @foreach($notifications as $notification)
                                <div class="notification-item border-bottom py-3 {{ !$notification->is_read ? 'unread' : '' }}"
                                     data-id="{{ $notification->id }}">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            @if($notification->fromUser)
                                                <img class="avatar rounded-circle"
                                                     src="{{ $notification->fromUser->image_url }}"
                                                     alt="{{ $notification->fromUser->name }}"
                                                     width="40" height="40">
                                            @else
                                                <div class="avatar rounded-circle no-thumbnail bg-{{ $notification->badge_color }} d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="{{ $notification->icon }} text-white"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1 fw-bold">{{ $notification->title }}</h6>
                                                    <p class="mb-1 text-muted">{{ $notification->message }}</p>
                                                    <small class="text-muted">
                                                        @if($notification->fromUser)
                                                            Từ {{ $notification->fromUser->name }} •
                                                        @endif
                                                        {{ $notification->time_ago }}
                                                    </small>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    @if(!$notification->is_read)
                                                        <span class="badge bg-primary me-2">Mới</span>
                                                    @endif
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                                type="button" data-bs-toggle="dropdown">
                                                            <i class="icofont-ui-settings"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            @if(!$notification->is_read)
                                                                <li>
                                                                    <a class="dropdown-item mark-read-btn"
                                                                       href="#" data-id="{{ $notification->id }}">
                                                                        <i class="icofont-check"></i> Đánh dấu đã đọc
                                                                    </a>
                                                                </li>
                                                            @endif
                                                            @if($notification->url)
                                                                <li>
                                                                    <a class="dropdown-item" href="{{ $notification->url }}">
                                                                        <i class="icofont-external-link"></i> Xem chi tiết
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($notification->url)
                                                <div class="mt-2">
                                                    <a href="{{ $notification->url }}" class="btn btn-sm btn-outline-primary">
                                                        Xem chi tiết <i class="icofont-external-link ms-1"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="icofont-notification display-1 text-muted"></i>
                            <h4 class="mt-3">Không có thông báo</h4>
                            <p class="text-muted">Bạn chưa có thông báo nào.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mark all as read
    document.getElementById('markAllReadBtn').addEventListener('click', function() {
        if (confirm('Bạn có chắc chắn muốn đánh dấu tất cả thông báo là đã đọc?')) {
            fetch('{{ route("notifications.mark-all-read") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update UI
                    document.querySelectorAll('.notification-item.unread').forEach(item => {
                        item.classList.remove('unread');
                        const badge = item.querySelector('.badge.bg-primary');
                        if (badge) badge.remove();
                    });

                    // Show success message
                    showAlert('success', 'Đã đánh dấu tất cả thông báo là đã đọc');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('error', 'Có lỗi xảy ra. Vui lòng thử lại.');
            });
        }
    });

    // Mark individual as read
    document.querySelectorAll('.mark-read-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const notificationId = this.dataset.id;

            fetch(`{{ url('notifications') }}/${notificationId}/mark-read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update UI
                    const notificationItem = document.querySelector(`.notification-item[data-id="${notificationId}"]`);
                    if (notificationItem) {
                        notificationItem.classList.remove('unread');
                        const badge = notificationItem.querySelector('.badge.bg-primary');
                        if (badge) badge.remove();
                        this.closest('.dropdown-menu').querySelector('li').style.display = 'none';
                    }

                    showAlert('success', 'Đã đánh dấu thông báo là đã đọc');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('error', 'Có lỗi xảy ra. Vui lòng thử lại.');
            });
        });
    });

    function showAlert(type, message) {
        // Create alert element
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        // Insert at top of container
        const container = document.querySelector('.container-xxl');
        container.insertBefore(alertDiv, container.firstChild);

        // Auto remove after 5 seconds
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
});
</script>
@endpush

@push('styles')
<style>
.notification-item.unread {
    background-color: #f8f9fa;
}

.notification-item:hover {
    background-color: #e9ecef;
}

.notification-item:last-child {
    border-bottom: none !important;
}
</style>
@endpush
@endsection
