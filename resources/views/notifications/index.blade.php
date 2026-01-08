<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Notifier</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-8 text-blue-600">Laravel Notifier Dashboard</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Send Notifications Card -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Send Notifications</h2>
                
                <div class="space-y-4">
                    <div class="p-4 bg-blue-50 rounded">
                        <h3 class="font-medium mb-2">Welcome Notification</h3>
                        <button onclick="sendWelcomeNotification()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            <i class="fas fa-envelope mr-2"></i>Send Welcome Email
                        </button>
                    </div>
                    
                    <div class="p-4 bg-green-50 rounded">
                        <h3 class="font-medium mb-2">Order Shipped Notification</h3>
                        <button onclick="sendOrderNotification()" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                            <i class="fas fa-shipping-fast mr-2"></i>Send Order Shipped
                        </button>
                    </div>
                    
                    <div class="p-4 bg-purple-50 rounded">
                        <h3 class="font-medium mb-2">Broadcast Notification</h3>
                        <button onclick="broadcastNotification()" class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600">
                            <i class="fas fa-bullhorn mr-2"></i>Broadcast to All Users
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- User Management Card -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4">User Management</h2>
                
                <div class="mb-6">
                    <h3 class="font-medium mb-2">Create Test User</h3>
                    <form id="createUserForm" class="space-y-3">
                        <input type="text" id="userName" placeholder="Name" class="w-full p-2 border rounded">
                        <input type="email" id="userEmail" placeholder="Email" class="w-full p-2 border rounded">
                        <input type="password" id="userPassword" placeholder="Password" class="w-full p-2 border rounded">
                        <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800">
                            Create User
                        </button>
                    </form>
                </div>
                
                <div>
                    <h3 class="font-medium mb-2">Select User for Notifications</h3>
                    <select id="userIdSelect" class="w-full p-2 border rounded">
                        <option value="">Loading users...</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Notifications Display -->
        <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">User Notifications</h2>
                <button onclick="loadUserNotifications()" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                    <i class="fas fa-sync-alt mr-2"></i>Refresh
                </button>
            </div>
            
            <div id="notificationsContainer" class="space-y-3">
                <p class="text-gray-500 text-center py-4">Select a user and click refresh to load notifications</p>
            </div>
        </div>
        
        <!-- Response Message -->
        <div id="responseMessage" class="fixed bottom-4 right-4 p-4 rounded-lg shadow-lg hidden"></div>
    </div>
    
    <script>
        let currentUserId = null;
        
        // Load users on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadUsers();
        });
        
        // Load users from API
        async function loadUsers() {
            try {
                const response = await fetch('/api/users');
                const data = await response.json();
                
                const select = document.getElementById('userIdSelect');
                select.innerHTML = '<option value="">Select a user</option>';
                
                data.users.forEach(user => {
                    const option = document.createElement('option');
                    option.value = user.id;
                    option.textContent = `${user.name} (${user.email})`;
                    select.appendChild(option);
                });
                
                select.addEventListener('change', function() {
                    currentUserId = this.value;
                });
            } catch (error) {
                console.error('Error loading users:', error);
            }
        }
        
        // Create user form handler
        document.getElementById('createUserForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const userData = {
                name: document.getElementById('userName').value,
                email: document.getElementById('userEmail').value,
                password: document.getElementById('userPassword').value,
            };
            
            try {
                const response = await fetch('/api/users', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(userData)
                });
                
                const data = await response.json();
                showResponse('User created successfully!', 'success');
                loadUsers();
                
                // Clear form
                document.getElementById('createUserForm').reset();
            } catch (error) {
                showResponse('Error creating user', 'error');
            }
        });
        
        // Send welcome notification
        async function sendWelcomeNotification() {
            if (!currentUserId) {
                showResponse('Please select a user first', 'error');
                return;
            }
            
            try {
                const response = await fetch(`/api/notifications/welcome/${currentUserId}`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                    },
                });
                
                const data = await response.json();
                showResponse(data.message, 'success');
                loadUserNotifications();
            } catch (error) {
                showResponse('Error sending notification', 'error');
            }
        }
        
        // Send order shipped notification
        async function sendOrderNotification() {
            if (!currentUserId) {
                showResponse('Please select a user first', 'error');
                return;
            }
            
            try {
                const response = await fetch(`/api/notifications/order-shipped/${currentUserId}`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                    },
                });
                
                const data = await response.json();
                showResponse(data.message, 'success');
                loadUserNotifications();
            } catch (error) {
                showResponse('Error sending notification', 'error');
            }
        }
        
        // Broadcast notification
        async function broadcastNotification() {
            try {
                const response = await fetch('/api/notifications/broadcast', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                    },
                });
                
                const data = await response.json();
                showResponse(data.message, 'success');
                loadUserNotifications();
            } catch (error) {
                showResponse('Error broadcasting notification', 'error');
            }
        }
        
        // Load user notifications
        async function loadUserNotifications() {
            if (!currentUserId) {
                showResponse('Please select a user first', 'error');
                return;
            }
            
            try {
                const response = await fetch(`/api/notifications/user/${currentUserId}`);
                const data = await response.json();
                
                const container = document.getElementById('notificationsContainer');
                
                if (data.notifications.data.length === 0) {
                    container.innerHTML = '<p class="text-gray-500 text-center py-4">No notifications found</p>';
                    return;
                }
                
                container.innerHTML = '';
                
                data.notifications.data.forEach(notification => {
                    const notificationElement = document.createElement('div');
                    notificationElement.className = `p-4 rounded border-l-4 ${notification.read_at ? 'bg-gray-50 border-gray-300' : 'bg-blue-50 border-blue-500'}`;
                    
                    const data = notification.data;
                    const icon = getIcon(data.icon || 'bell');
                    const readClass = notification.read_at ? 'text-gray-500' : 'font-semibold';
                    
                    notificationElement.innerHTML = `
                        <div class="flex justify-between items-start">
                            <div class="flex items-center">
                                <i class="${icon} mr-3 text-lg"></i>
                                <div>
                                    <h3 class="${readClass}">${data.title}</h3>
                                    <p class="text-gray-600">${data.message}</p>
                                    <p class="text-sm text-gray-500 mt-1">
                                        ${new Date(notification.created_at).toLocaleString()}
                                        ${notification.read_at ? '• Read' : '• Unread'}
                                    </p>
                                </div>
                            </div>
                            <div class="space-x-2">
                                ${!notification.read_at ? 
                                    `<button onclick="markAsRead('${notification.id}')" class="text-blue-500 hover:text-blue-700">
                                        <i class="fas fa-check"></i>
                                    </button>` : ''
                                }
                                <button onclick="deleteNotification('${notification.id}')" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    `;
                    
                    container.appendChild(notificationElement);
                });
            } catch (error) {
                console.error('Error loading notifications:', error);
            }
        }
        
        // Mark notification as read
        async function markAsRead(notificationId) {
            try {
                const response = await fetch(`/api/notifications/mark-as-read/${currentUserId}/${notificationId}`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                    },
                });
                
                const data = await response.json();
                showResponse(data.message, 'success');
                loadUserNotifications();
            } catch (error) {
                showResponse('Error marking as read', 'error');
            }
        }
        
        // Delete notification
        async function deleteNotification(notificationId) {
            try {
                const response = await fetch(`/api/notifications/delete/${currentUserId}/${notificationId}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                    },
                });
                
                const data = await response.json();
                showResponse(data.message, 'success');
                loadUserNotifications();
            } catch (error) {
                showResponse('Error deleting notification', 'error');
            }
        }
        
        // Helper function to get icon class
        function getIcon(iconName) {
            const icons = {
                'user-plus': 'fas fa-user-plus',
                'truck': 'fas fa-truck',
                'bell': 'fas fa-bell',
                'shopping-cart': 'fas fa-shopping-cart',
                'credit-card': 'fas fa-credit-card',
                'info': 'fas fa-info-circle',
            };
            
            return icons[iconName] || 'fas fa-bell';
        }
        
        // Show response message
        function showResponse(message, type) {
            const responseDiv = document.getElementById('responseMessage');
            responseDiv.textContent = message;
            responseDiv.className = `fixed bottom-4 right-4 p-4 rounded-lg shadow-lg ${type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'}`;
            responseDiv.classList.remove('hidden');
            
            setTimeout(() => {
                responseDiv.classList.add('hidden');
            }, 3000);
        }
    </script>
</body>
</html>