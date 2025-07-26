@php
    $unreadCount = auth()->check() ? auth()->user()->unreadNotifications()->count() : 0;
@endphp

<div x-data="notificationModal()" class="relative inline-block">
    <!-- Notification Badge -->
    <button @click="openModal()" class="relative text-gray-600 hover:text-gray-800 transition-colors">
        <i class="bi bi-bell-fill text-xl"></i>
        @if($unreadCount > 0)
            <span class="absolute -top-2 -right-2 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold text-white bg-red-500 rounded-full min-w-[18px]">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif
    </button>

    <!-- Modal Backdrop -->
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-50 z-40"
         @click="closeModal()"
         style="display: none;">
    </div>

    <!-- Modal -->
    <div x-show="isOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-95"
         class="fixed inset-0 z-50 overflow-y-auto"
         @click.away="closeModal()"
         style="display: none;">
        
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="relative inline-block w-full max-w-2xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                <!-- Header -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <i class="bi bi-bell-fill text-2xl text-purple-600"></i>
                        <h3 class="text-xl font-bold text-gray-900">Notifications</h3>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button @click="markAllAsRead()" class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                            Mark all as read
                        </button>
                        <button @click="closeModal()" class="text-gray-400 hover:text-gray-600">
                            <i class="bi bi-x-lg text-xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Notifications List -->
                <div class="max-h-96 overflow-y-auto">
                    <div x-show="notifications.length === 0" class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="bi bi-bell text-2xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No notifications</h3>
                        <p class="text-gray-500">You're all caught up! Check back later for new updates.</p>
                    </div>

                    <div x-show="notifications.length > 0" class="space-y-4">
                        <template x-for="notification in notifications" :key="notification.id">
                            <div class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors"
                                 :class="notification.read_at ? 'opacity-75' : 'bg-blue-50'">
                                <div class="flex items-start space-x-4">
                                    <!-- Icon -->
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center"
                                             :class="getIconClass(notification.data.type)">
                                            <i class="bi" :class="getIcon(notification.data.type)"></i>
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <h4 class="text-sm font-semibold text-gray-900" x-text="notification.data.title"></h4>
                                            <div class="flex items-center space-x-2">
                                                <span class="text-xs text-gray-500" x-text="formatTime(notification.created_at)"></span>
                                                <span x-show="!notification.read_at" class="w-2 h-2 bg-red-500 rounded-full"></span>
                                            </div>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1" x-text="notification.data.message"></p>
                                        <div x-show="notification.data.action_url" class="mt-2">
                                            <a :href="notification.data.action_url" 
                                               class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                                                View Details →
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex items-center space-x-2">
                                        <button x-show="!notification.read_at" 
                                                @click="markAsRead(notification.id)"
                                                class="text-xs text-gray-500 hover:text-gray-700">
                                            Mark as read
                                        </button>
                                        <button @click="deleteNotification(notification.id)"
                                                class="text-xs text-red-500 hover:text-red-700">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-6 flex justify-between items-center pt-4 border-t border-gray-200">
                    <span class="text-sm text-gray-500">
                        <span x-text="unreadCount"></span> unread notifications
                    </span>
                    <a href="/notifications" class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                        View all notifications →
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function notificationModal() {
    return {
        isOpen: false,
        notifications: [],
        unreadCount: {{ $unreadCount }},
        
        openModal() {
            this.isOpen = true;
            this.loadNotifications();
        },
        
        closeModal() {
            this.isOpen = false;
        },
        
        async loadNotifications() {
            try {
                const response = await fetch('/notifications/recent');
                const data = await response.json();
                this.notifications = data.notifications;
            } catch (error) {
                console.error('Error loading notifications:', error);
            }
        },
        
        async markAsRead(id) {
            try {
                const response = await fetch(`/notifications/${id}/mark-as-read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    }
                });
                
                if (response.ok) {
                    const notification = this.notifications.find(n => n.id === id);
                    if (notification) {
                        notification.read_at = new Date().toISOString();
                    }
                    this.updateUnreadCount();
                }
            } catch (error) {
                console.error('Error marking as read:', error);
            }
        },
        
        async markAllAsRead() {
            try {
                const response = await fetch('/notifications/mark-all-as-read', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    }
                });
                
                if (response.ok) {
                    this.notifications.forEach(n => n.read_at = new Date().toISOString());
                    this.updateUnreadCount();
                }
            } catch (error) {
                console.error('Error marking all as read:', error);
            }
        },
        
        async deleteNotification(id) {
            if (!confirm('Are you sure you want to delete this notification?')) return;
            
            try {
                const response = await fetch(`/notifications/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    }
                });
                
                if (response.ok) {
                    this.notifications = this.notifications.filter(n => n.id !== id);
                    this.updateUnreadCount();
                }
            } catch (error) {
                console.error('Error deleting notification:', error);
            }
        },
        
        async updateUnreadCount() {
            try {
                const response = await fetch('/notifications/unread-count');
                const data = await response.json();
                this.unreadCount = data.count;
            } catch (error) {
                console.error('Error updating unread count:', error);
            }
        },
        
        getIconClass(type) {
            const classes = {
                'registration': 'bg-green-100',
                'approval': 'bg-blue-100',
                'rejection': 'bg-red-100',
                'default': 'bg-purple-100'
            };
            return classes[type] || classes.default;
        },
        
        getIcon(type) {
            const icons = {
                'registration': 'bi-person-plus text-green-600',
                'approval': 'bi-check-circle text-blue-600',
                'rejection': 'bi-x-circle text-red-600',
                'default': 'bi-bell text-purple-600'
            };
            return icons[type] || icons.default;
        },
        
        formatTime(timestamp) {
            const date = new Date(timestamp);
            const now = new Date();
            const diffInMinutes = Math.floor((now - date) / (1000 * 60));
            
            if (diffInMinutes < 1) return 'Just now';
            if (diffInMinutes < 60) return `${diffInMinutes}m ago`;
            if (diffInMinutes < 1440) return `${Math.floor(diffInMinutes / 60)}h ago`;
            return `${Math.floor(diffInMinutes / 1440)}d ago`;
        }
    }
}

// Update notification count periodically only if notification component exists
const notificationComponent = document.querySelector('[x-data="notificationModal()"]');
if (notificationComponent) {
    setInterval(function() {
        fetch('/notifications/unread-count')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const badge = document.querySelector('[x-data="notificationModal()"] .absolute');
            if (data.count > 0) {
                if (badge) {
                    badge.textContent = data.count > 99 ? '99+' : data.count;
                    badge.style.display = 'inline-flex';
                } else {
                    const button = document.querySelector('[x-data="notificationModal()"] button');
                    if (button) {
                        const newBadge = document.createElement('span');
                        newBadge.className = 'absolute -top-2 -right-2 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold text-white bg-red-500 rounded-full min-w-[18px]';
                        newBadge.textContent = data.count > 99 ? '99+' : data.count;
                        button.appendChild(newBadge);
                    }
                }
            } else {
                if (badge) {
                    badge.style.display = 'none';
                }
            }
        })
        .catch(error => {
            // Silently handle errors to prevent console spam
            // console.error('Error updating notification count:', error);
        });
    }, 30000); // Update every 30 seconds
}
</script> 