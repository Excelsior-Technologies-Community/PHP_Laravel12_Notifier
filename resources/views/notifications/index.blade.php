<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Laravel Notifier</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    >
</head>

<body class="bg-gray-100">

<div class="container mx-auto px-4 py-8">

    <!-- Page Header -->
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-blue-600">
            Laravel Notifier Dashboard
        </h1>

        <p class="text-gray-500 mt-2">
            Manage notifications, preferences and notification analytics
        </p>
    </div>


    <!-- Analytics -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-8">

        <div class="flex justify-between items-center mb-6">

            <div>
                <h2 class="text-xl font-semibold">
                    Notification Analytics
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Overview of notification activity
                </p>
            </div>

            <button
                onclick="loadAnalytics()"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
            >
                <i class="fas fa-chart-bar mr-2"></i>
                Refresh
            </button>

        </div>


        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div class="bg-blue-50 rounded-lg p-5">
                <p class="text-gray-500">
                    Total Notifications
                </p>

                <p
                    id="totalNotifications"
                    class="text-3xl font-bold text-blue-600 mt-2"
                >
                    0
                </p>
            </div>


            <div class="bg-yellow-50 rounded-lg p-5">
                <p class="text-gray-500">
                    Unread Notifications
                </p>

                <p
                    id="unreadNotifications"
                    class="text-3xl font-bold text-yellow-600 mt-2"
                >
                    0
                </p>
            </div>


            <div class="bg-green-50 rounded-lg p-5">
                <p class="text-gray-500">
                    Read Notifications
                </p>

                <p
                    id="readNotifications"
                    class="text-3xl font-bold text-green-600 mt-2"
                >
                    0
                </p>
            </div>

        </div>


        <div class="mt-6">

            <h3 class="font-semibold mb-3">
                Notifications by Type
            </h3>

            <div
                id="notificationTypeStats"
                class="space-y-2"
            >
                <p class="text-gray-500">
                    Loading analytics...
                </p>
            </div>

        </div>

    </div>


    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">


        <!-- Send Notifications -->
        <div class="bg-white rounded-lg shadow-lg p-6">

            <h2 class="text-xl font-semibold mb-4">
                Send Notifications
            </h2>


            <div class="space-y-4">


                <!-- Welcome -->
                <div class="p-4 bg-blue-50 rounded">

                    <h3 class="font-medium mb-2">
                        Welcome Notification
                    </h3>

                    <p class="text-sm text-gray-600 mb-3">
                        Sends a welcome email and database notification.
                    </p>

                    <button
                        onclick="sendWelcomeNotification()"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                    >
                        <i class="fas fa-envelope mr-2"></i>
                        Send Welcome
                    </button>

                </div>


                <!-- Order Shipped -->
                <div class="p-4 bg-green-50 rounded">

                    <h3 class="font-medium mb-2">
                        Order Shipped Notification
                    </h3>

                    <p class="text-sm text-gray-600 mb-3">
                        Sends order tracking information.
                    </p>

                    <button
                        onclick="sendOrderNotification()"
                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
                    >
                        <i class="fas fa-shipping-fast mr-2"></i>
                        Send Order Shipped
                    </button>

                </div>


                <!-- Broadcast -->
                <div class="p-4 bg-purple-50 rounded">

                    <h3 class="font-medium mb-2">
                        Broadcast Notification
                    </h3>

                    <p class="text-sm text-gray-600 mb-3">
                        Send a system notification to all eligible users.
                    </p>

                    <button
                        onclick="broadcastNotification()"
                        class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600"
                    >
                        <i class="fas fa-bullhorn mr-2"></i>
                        Broadcast
                    </button>

                </div>

            </div>

        </div>


        <!-- User Management -->
        <div class="bg-white rounded-lg shadow-lg p-6">

            <h2 class="text-xl font-semibold mb-4">
                User Management
            </h2>


            <!-- Create User -->
            <div class="mb-6">

                <h3 class="font-medium mb-2">
                    Create Test User
                </h3>

                <form
                    id="createUserForm"
                    class="space-y-3"
                >

                    <input
                        type="text"
                        id="userName"
                        placeholder="Name"
                        class="w-full p-2 border rounded"
                        required
                    >

                    <input
                        type="email"
                        id="userEmail"
                        placeholder="Email"
                        class="w-full p-2 border rounded"
                        required
                    >

                    <input
                        type="password"
                        id="userPassword"
                        placeholder="Password"
                        class="w-full p-2 border rounded"
                        required
                    >

                    <button
                        type="submit"
                        class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800"
                    >
                        Create User
                    </button>

                </form>

            </div>


            <!-- User Selection -->
            <div>

                <h3 class="font-medium mb-2">
                    Select User
                </h3>

                <select
                    id="userIdSelect"
                    class="w-full p-2 border rounded"
                >
                    <option value="">
                        Loading users...
                    </option>
                </select>

            </div>


            <!-- Preferences -->
            <div class="mt-6 border-t pt-6">

                <h3 class="font-medium mb-3">
                    Notification Preferences
                </h3>


                <div class="space-y-3">


                    <!-- Welcome -->
                    <label class="flex items-center justify-between p-3 bg-gray-50 rounded">

                        <span>
                            <i class="fas fa-user-plus mr-2 text-blue-500"></i>
                            Welcome Notifications
                        </span>

                        <input
                            type="checkbox"
                            id="welcomePreference"
                            class="w-5 h-5"
                            checked
                        >

                    </label>


                    <!-- Order -->
                    <label class="flex items-center justify-between p-3 bg-gray-50 rounded">

                        <span>
                            <i class="fas fa-truck mr-2 text-green-500"></i>
                            Order Shipped Notifications
                        </span>

                        <input
                            type="checkbox"
                            id="orderShippedPreference"
                            class="w-5 h-5"
                            checked
                        >

                    </label>


                    <!-- Invoice -->
                    <label class="flex items-center justify-between p-3 bg-gray-50 rounded">

                        <span>
                            <i class="fas fa-credit-card mr-2 text-purple-500"></i>
                            Invoice/System Notifications
                        </span>

                        <input
                            type="checkbox"
                            id="invoicePaidPreference"
                            class="w-5 h-5"
                            checked
                        >

                    </label>

                </div>


                <button
                    onclick="saveNotificationPreferences()"
                    class="mt-4 bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600"
                >
                    <i class="fas fa-save mr-2"></i>
                    Save Preferences
                </button>

            </div>

        </div>

    </div>


    <!-- Notifications -->
    <div class="mt-8 bg-white rounded-lg shadow-lg p-6">

        <div class="flex justify-between items-center mb-4">

            <div>
                <h2 class="text-xl font-semibold">
                    User Notifications
                </h2>

                <p class="text-sm text-gray-500">
                    View and manage selected user's notifications.
                </p>
            </div>

            <div class="space-x-2">

                <button
                    onclick="markAllAsRead()"
                    class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
                >
                    <i class="fas fa-check-double mr-2"></i>
                    Mark All Read
                </button>

                <button
                    onclick="loadUserNotifications()"
                    class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300"
                >
                    <i class="fas fa-sync-alt mr-2"></i>
                    Refresh
                </button>

            </div>

        </div>


        <div
            id="notificationsContainer"
            class="space-y-3"
        >
            <p class="text-gray-500 text-center py-4">
                Select a user to load notifications.
            </p>
        </div>

    </div>


    <!-- Response Message -->
    <div
        id="responseMessage"
        class="fixed bottom-4 right-4 p-4 rounded-lg shadow-lg hidden z-50"
    ></div>

</div>


<script>

let currentUserId = null;


/*
|--------------------------------------------------------------------------
| Page Initialization
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', function () {

    loadUsers();
    loadAnalytics();

});


/*
|--------------------------------------------------------------------------
| Users
|--------------------------------------------------------------------------
*/

async function loadUsers()
{
    try {

        const response = await fetch('/api/users');

        const data = await response.json();

        const select = document.getElementById('userIdSelect');

        select.innerHTML = '<option value="">Select a user</option>';

        data.users.forEach(user => {

            const option = document.createElement('option');

            option.value = user.id;

            option.textContent =
                `${user.name} (${user.email})`;

            select.appendChild(option);

        });

    } catch (error) {

        console.error('Error loading users:', error);

        showResponse(
            'Unable to load users.',
            'error'
        );

    }
}


/*
|--------------------------------------------------------------------------
| User Selection
|--------------------------------------------------------------------------
*/

document
    .getElementById('userIdSelect')
    .addEventListener('change', function () {

        currentUserId = this.value;

        if (currentUserId) {

            loadNotificationPreferences();

            loadUserNotifications();

        }

    });


/*
|--------------------------------------------------------------------------
| Create User
|--------------------------------------------------------------------------
*/

document
    .getElementById('createUserForm')
    .addEventListener('submit', async function (e) {

        e.preventDefault();

        const userData = {

            name: document
                .getElementById('userName')
                .value,

            email: document
                .getElementById('userEmail')
                .value,

            password: document
                .getElementById('userPassword')
                .value,

        };


        try {

            const response = await fetch('/api/users', {

                method: 'POST',

                headers: {

                    'Content-Type': 'application/json',

                    'Accept': 'application/json',

                },

                body: JSON.stringify(userData),

            });


            const data = await response.json();


            if (!response.ok) {

                const message =
                    data.message ||
                    'Unable to create user.';

                showResponse(message, 'error');

                return;

            }


            showResponse(
                data.message,
                'success'
            );


            document
                .getElementById('createUserForm')
                .reset();


            await loadUsers();


        } catch (error) {

            console.error(error);

            showResponse(
                'Error creating user.',
                'error'
            );

        }

    });


/*
|--------------------------------------------------------------------------
| Welcome Notification
|--------------------------------------------------------------------------
*/

async function sendWelcomeNotification()
{
    if (!currentUserId) {

        showResponse(
            'Please select a user first.',
            'error'
        );

        return;

    }


    try {

        const response = await fetch(
            `/api/notifications/welcome/${currentUserId}`,
            {
                method: 'POST',

                headers: {
                    'Accept': 'application/json',
                },
            }
        );


        const data = await response.json();


        if (!response.ok) {

            showResponse(
                data.message || 'Unable to send notification.',
                'error'
            );

            return;

        }


        showResponse(
            data.message,
            'success'
        );


        await loadUserNotifications();

        await loadAnalytics();


    } catch (error) {

        console.error(error);

        showResponse(
            'Error sending notification.',
            'error'
        );

    }
}


/*
|--------------------------------------------------------------------------
| Order Notification
|--------------------------------------------------------------------------
*/

async function sendOrderNotification()
{
    if (!currentUserId) {

        showResponse(
            'Please select a user first.',
            'error'
        );

        return;

    }


    try {

        const response = await fetch(
            `/api/notifications/order-shipped/${currentUserId}`,
            {
                method: 'POST',

                headers: {
                    'Accept': 'application/json',
                },
            }
        );


        const data = await response.json();


        if (!response.ok) {

            showResponse(
                data.message || 'Unable to send notification.',
                'error'
            );

            return;

        }


        showResponse(
            data.message,
            'success'
        );


        await loadUserNotifications();

        await loadAnalytics();


    } catch (error) {

        console.error(error);

        showResponse(
            'Error sending notification.',
            'error'
        );

    }
}


/*
|--------------------------------------------------------------------------
| Broadcast
|--------------------------------------------------------------------------
*/

async function broadcastNotification()
{
    try {

        const response = await fetch(
            '/api/notifications/broadcast',
            {
                method: 'POST',

                headers: {
                    'Accept': 'application/json',
                },
            }
        );


        const data = await response.json();


        if (!response.ok) {

            showResponse(
                data.message || 'Unable to broadcast notification.',
                'error'
            );

            return;

        }


        showResponse(
            data.message,
            'success'
        );


        await loadUserNotifications();

        await loadAnalytics();


    } catch (error) {

        console.error(error);

        showResponse(
            'Error broadcasting notification.',
            'error'
        );

    }
}


/*
|--------------------------------------------------------------------------
| Notification Preferences
|--------------------------------------------------------------------------
*/

async function loadNotificationPreferences()
{
    if (!currentUserId) {
        return;
    }


    try {

        const response = await fetch(
            `/api/notifications/preferences/${currentUserId}`
        );


        const data = await response.json();


        if (!response.ok) {

            showResponse(
                data.message || 'Unable to load preferences.',
                'error'
            );

            return;

        }


        const preferences =
            data.preferences;


        document
            .getElementById('welcomePreference')
            .checked =
                preferences.welcome_enabled;


        document
            .getElementById('orderShippedPreference')
            .checked =
                preferences.order_shipped_enabled;


        document
            .getElementById('invoicePaidPreference')
            .checked =
                preferences.invoice_paid_enabled;


    } catch (error) {

        console.error(error);

        showResponse(
            'Error loading notification preferences.',
            'error'
        );

    }
}


async function saveNotificationPreferences()
{
    if (!currentUserId) {

        showResponse(
            'Please select a user first.',
            'error'
        );

        return;

    }


    try {

        const response = await fetch(
            `/api/notifications/preferences/${currentUserId}`,
            {

                method: 'PUT',

                headers: {

                    'Content-Type': 'application/json',

                    'Accept': 'application/json',

                },

                body: JSON.stringify({

                    welcome_enabled:
                        document
                            .getElementById('welcomePreference')
                            .checked,

                    order_shipped_enabled:
                        document
                            .getElementById('orderShippedPreference')
                            .checked,

                    invoice_paid_enabled:
                        document
                            .getElementById('invoicePaidPreference')
                            .checked,

                }),

            }
        );


        const data = await response.json();


        if (!response.ok) {

            showResponse(
                data.message || 'Unable to save preferences.',
                'error'
            );

            return;

        }


        showResponse(
            data.message,
            'success'
        );


    } catch (error) {

        console.error(error);

        showResponse(
            'Error saving notification preferences.',
            'error'
        );

    }
}


/*
|--------------------------------------------------------------------------
| User Notifications
|--------------------------------------------------------------------------
*/

async function loadUserNotifications()
{
    if (!currentUserId) {

        showResponse(
            'Please select a user first.',
            'error'
        );

        return;

    }


    try {

        const response = await fetch(
            `/api/notifications/user/${currentUserId}`
        );


        const data = await response.json();


        if (!response.ok) {

            showResponse(
                data.message || 'Unable to load notifications.',
                'error'
            );

            return;

        }


        const container =
            document.getElementById(
                'notificationsContainer'
            );


        if (
            !data.notifications.data ||
            data.notifications.data.length === 0
        ) {

            container.innerHTML = `
                <p class="text-gray-500 text-center py-4">
                    No notifications found.
                </p>
            `;

            return;

        }


        container.innerHTML = '';


        data.notifications.data.forEach(notification => {

            const notificationData =
                typeof notification.data === 'string'
                    ? JSON.parse(notification.data)
                    : notification.data;


            const icon =
                getIcon(
                    notificationData.icon || 'bell'
                );


            const readClass =
                notification.read_at
                    ? 'text-gray-500'
                    : 'font-semibold';


            const notificationElement =
                document.createElement('div');


            notificationElement.className =
                `p-4 rounded border-l-4 ${
                    notification.read_at
                        ? 'bg-gray-50 border-gray-300'
                        : 'bg-blue-50 border-blue-500'
                }`;


            notificationElement.innerHTML = `

                <div class="flex justify-between items-start">

                    <div class="flex items-center">

                        <i class="${icon} mr-3 text-lg"></i>

                        <div>

                            <h3 class="${readClass}">
                                ${escapeHtml(
                                    notificationData.title ||
                                    'Notification'
                                )}
                            </h3>

                            <p class="text-gray-600">
                                ${escapeHtml(
                                    notificationData.message ||
                                    ''
                                )}
                            </p>

                            <p class="text-sm text-gray-500 mt-1">

                                ${new Date(
                                    notification.created_at
                                ).toLocaleString()}

                                ${
                                    notification.read_at
                                        ? ' • Read'
                                        : ' • Unread'
                                }

                            </p>

                        </div>

                    </div>


                    <div class="space-x-2">

                        ${
                            !notification.read_at

                                ? `

                                    <button
                                        onclick="markAsRead('${notification.id}')"
                                        class="text-blue-500 hover:text-blue-700"
                                        title="Mark as read"
                                    >
                                        <i class="fas fa-check"></i>
                                    </button>

                                  `

                                : ''
                        }


                        <button
                            onclick="deleteNotification('${notification.id}')"
                            class="text-red-500 hover:text-red-700"
                            title="Delete"
                        >
                            <i class="fas fa-trash"></i>
                        </button>

                    </div>

                </div>

            `;


            container.appendChild(
                notificationElement
            );

        });


    } catch (error) {

        console.error(error);

        showResponse(
            'Error loading notifications.',
            'error'
        );

    }
}


/*
|--------------------------------------------------------------------------
| Mark Notification As Read
|--------------------------------------------------------------------------
*/

async function markAsRead(notificationId)
{
    try {

        const response = await fetch(
            `/api/notifications/mark-as-read/${currentUserId}/${notificationId}`,
            {

                method: 'POST',

                headers: {
                    'Accept': 'application/json',
                },

            }
        );


        const data = await response.json();


        if (!response.ok) {

            showResponse(
                data.message || 'Unable to mark notification as read.',
                'error'
            );

            return;

        }


        showResponse(
            data.message,
            'success'
        );


        await loadUserNotifications();

        await loadAnalytics();


    } catch (error) {

        console.error(error);

        showResponse(
            'Error marking notification as read.',
            'error'
        );

    }
}


/*
|--------------------------------------------------------------------------
| Mark All As Read
|--------------------------------------------------------------------------
*/

async function markAllAsRead()
{
    if (!currentUserId) {

        showResponse(
            'Please select a user first.',
            'error'
        );

        return;

    }


    try {

        const response = await fetch(
            `/api/notifications/mark-all-read/${currentUserId}`,
            {

                method: 'POST',

                headers: {
                    'Accept': 'application/json',
                },

            }
        );


        const data = await response.json();


        if (!response.ok) {

            showResponse(
                data.message || 'Unable to mark notifications as read.',
                'error'
            );

            return;

        }


        showResponse(
            data.message,
            'success'
        );


        await loadUserNotifications();

        await loadAnalytics();


    } catch (error) {

        console.error(error);

        showResponse(
            'Error marking notifications as read.',
            'error'
        );

    }
}


/*
|--------------------------------------------------------------------------
| Delete Notification
|--------------------------------------------------------------------------
*/

async function deleteNotification(notificationId)
{
    if (!confirm('Delete this notification?')) {
        return;
    }


    try {

        const response = await fetch(
            `/api/notifications/delete/${currentUserId}/${notificationId}`,
            {

                method: 'DELETE',

                headers: {
                    'Accept': 'application/json',
                },

            }
        );


        const data = await response.json();


        if (!response.ok) {

            showResponse(
                data.message || 'Unable to delete notification.',
                'error'
            );

            return;

        }


        showResponse(
            data.message,
            'success'
        );


        await loadUserNotifications();

        await loadAnalytics();


    } catch (error) {

        console.error(error);

        showResponse(
            'Error deleting notification.',
            'error'
        );

    }
}


/*
|--------------------------------------------------------------------------
| Analytics
|--------------------------------------------------------------------------
*/

async function loadAnalytics()
{
    try {

        const response = await fetch(
            '/api/notifications/analytics'
        );


        const data = await response.json();


        if (!response.ok) {

            showResponse(
                data.message || 'Unable to load analytics.',
                'error'
            );

            return;

        }


        document
            .getElementById('totalNotifications')
            .textContent =
                data.total_notifications;


        document
            .getElementById('unreadNotifications')
            .textContent =
                data.unread_notifications;


        document
            .getElementById('readNotifications')
            .textContent =
                data.read_notifications;


        const container =
            document.getElementById(
                'notificationTypeStats'
            );


        if (
            !data.by_type ||
            data.by_type.length === 0
        ) {

            container.innerHTML = `
                <p class="text-gray-500">
                    No notification data available.
                </p>
            `;

            return;

        }


        container.innerHTML = '';


        data.by_type.forEach(item => {

            const notificationName =
                item.type
                    .split('\\')
                    .pop();


            const element =
                document.createElement('div');


            element.className =
                'flex justify-between items-center p-3 bg-gray-50 rounded';


            element.innerHTML = `

                <span>
                    ${escapeHtml(notificationName)}
                </span>

                <span class="font-semibold">
                    ${item.total}
                </span>

            `;


            container.appendChild(element);

        });


    } catch (error) {

        console.error(error);

        showResponse(
            'Error loading notification analytics.',
            'error'
        );

    }
}


/*
|--------------------------------------------------------------------------
| Icons
|--------------------------------------------------------------------------
*/

function getIcon(iconName)
{
    const icons = {

        'user-plus':
            'fas fa-user-plus',

        'truck':
            'fas fa-truck',

        'bell':
            'fas fa-bell',

        'shopping-cart':
            'fas fa-shopping-cart',

        'credit-card':
            'fas fa-credit-card',

        'info':
            'fas fa-info-circle',

    };


    return icons[iconName]
        || 'fas fa-bell';
}


/*
|--------------------------------------------------------------------------
| HTML Escape
|--------------------------------------------------------------------------
*/

function escapeHtml(value)
{
    const div =
        document.createElement('div');

    div.textContent =
        value ?? '';

    return div.innerHTML;
}


/*
|--------------------------------------------------------------------------
| Response Message
|--------------------------------------------------------------------------
*/

function showResponse(message, type)
{
    const responseDiv =
        document.getElementById(
            'responseMessage'
        );


    responseDiv.textContent =
        message;


    responseDiv.className =
        `fixed bottom-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
            type === 'success'
                ? 'bg-green-500 text-white'
                : 'bg-red-500 text-white'
        }`;


    setTimeout(() => {

        responseDiv.classList.add(
            'hidden'
        );

    }, 3000);
}

</script>

</body>

</html>