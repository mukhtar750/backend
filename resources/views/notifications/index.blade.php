@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <i class="bi bi-bell-fill text-2xl text-purple-600"></i>
                    <h1 class="text-2xl font-bold text-gray-900">Notifications</h1>
                </div>
                <div class="flex items-center space-x-3">
                    <button id="markAllRead" class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                        Mark all as read
                    </button>
                    <span id="unreadCount" class="bg-red-500 text-white text-xs px-2 py-1 rounded-full"></span>
                </div>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="divide-y divide-gray-200">
            @forelse($notifications as $notification)
                <div class="p-6 hover:bg-gray-50 transition-colors duration-200 {{ $notification->read_at ? 'opacity-75' : 'bg-blue-50' }}" 
                     data-notification-id="{{ $notification->id }}">
                    <div class="flex items-start space-x-4">
                        <!-- Icon -->
                        <div class="flex-shrink-0">
                            @if($notification->data['type'] === 'registration')
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="bi bi-person-plus text-green-600"></i>
                                </div>
                            @elseif($notification->data['type'] === 'approval')
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="bi bi-check-circle text-blue-600"></i>
                                </div>
                            @elseif($notification->data['type'] === 'rejection')
                                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                    <i class="bi bi-x-circle text-red-600"></i>
                                </div>
                            @else
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="bi bi-bell text-purple-600"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-semibold text-gray-900">
                                    {{ $notification->data['title'] }}
                                </h3>
                                <div class="flex items-center space-x-2">
                                    <span class="text-xs text-gray-500">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                    @if(!$notification->read_at)
                                        <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                    @endif
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ $notification->data['message'] }}
                            </p>
                            @if(isset($notification->data['action_url']))
                                <a href="{{ $notification->data['action_url'] }}" 
                                   class="inline-block mt-2 text-sm text-purple-600 hover:text-purple-800 font-medium">
                                    View Details →
                                </a>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center space-x-2">
                            @if(!$notification->read_at)
                                <button class="markAsRead text-xs text-gray-500 hover:text-gray-700" 
                                        data-id="{{ $notification->id }}">
                                    Mark as read
                                </button>
                            @endif
                            <button class="deleteNotification text-xs text-red-500 hover:text-red-700" 
                                    data-id="{{ $notification->id }}">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-bell text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No notifications</h3>
                    <p class="text-gray-500">You're all caught up! Check back later for new updates.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mark as read
    document.querySelectorAll('.markAsRead').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            fetch(`/notifications/${id}/mark-as-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const notification = this.closest('[data-notification-id]');
                    notification.classList.remove('bg-blue-50');
                    notification.classList.add('opacity-75');
                    this.remove();
                    updateUnreadCount();
                }
            });
        });
    });

    // Delete notification
    document.querySelectorAll('.deleteNotification').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            if (confirm('Are you sure you want to delete this notification?')) {
                fetch(`/notifications/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const notification = this.closest('[data-notification-id]');
                        notification.remove();
                        updateUnreadCount();
                    }
                });
            }
        });
    });

    // Mark all as read
    document.getElementById('markAllRead').addEventListener('click', function() {
        fetch('/notifications/mark-all-as-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelectorAll('[data-notification-id]').forEach(notification => {
                    notification.classList.remove('bg-blue-50');
                    notification.classList.add('opacity-75');
                });
                document.querySelectorAll('.markAsRead').forEach(button => button.remove());
                updateUnreadCount();
            }
        });
    });

    // Update unread count
    function updateUnreadCount() {
        fetch('/notifications/unread-count')
        .then(response => response.json())
        .then(data => {
            const countElement = document.getElementById('unreadCount');
            if (data.count > 0) {
                countElement.textContent = data.count;
                countElement.style.display = 'inline';
            } else {
                countElement.style.display = 'none';
            }
        });
    }

    // Initial count
    updateUnreadCount();
});
</script>
@endsection 