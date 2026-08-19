<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Laravel Notifier</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>


<body class="bg-gray-100">

    <div class="container mx-auto px-4 py-8">


        <!-- ========================================================= -->
        <!-- PAGE HEADER -->
        <!-- ========================================================= -->

        <div class="mb-8 text-center">

            <h1 class="text-3xl font-bold text-blue-600">
                Laravel Notifier Dashboard
            </h1>

            <p class="text-gray-500 mt-2">
                Manage notifications, preferences and notification analytics
            </p>

        </div>



        <!-- ========================================================= -->
        <!-- ANALYTICS -->
        <!-- ========================================================= -->

        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">

            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-3">

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
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">

                    <i class="fas fa-chart-bar mr-2"></i>

                    Refresh

                </button>

            </div>



            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">


                <!-- Total -->

                <div class="bg-blue-50 rounded-lg p-5">

                    <p class="text-gray-500">
                        Total Notifications
                    </p>

                    <p
                        id="totalNotifications"
                        class="text-3xl font-bold text-blue-600 mt-2">
                        0
                    </p>

                </div>



                <!-- Unread -->

                <div class="bg-yellow-50 rounded-lg p-5">

                    <p class="text-gray-500">
                        Unread Notifications
                    </p>

                    <p
                        id="unreadNotifications"
                        class="text-3xl font-bold text-yellow-600 mt-2">
                        0
                    </p>

                </div>



                <!-- Read -->

                <div class="bg-green-50 rounded-lg p-5">

                    <p class="text-gray-500">
                        Read Notifications
                    </p>

                    <p
                        id="readNotifications"
                        class="text-3xl font-bold text-green-600 mt-2">
                        0
                    </p>

                </div>

            </div>



            <!-- Notification Types -->

            <div class="mt-6">

                <h3 class="font-semibold mb-3">
                    Notifications by Type
                </h3>

                <div
                    id="notificationTypeStats"
                    class="space-y-2">

                    <p class="text-gray-500">
                        Loading analytics...
                    </p>

                </div>

            </div>

        </div>



        <!-- ========================================================= -->
        <!-- MAIN GRID -->
        <!-- ========================================================= -->

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">


            <!-- ===================================================== -->
            <!-- SEND NOTIFICATIONS -->
            <!-- ===================================================== -->

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
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">

                            <i class="fas fa-envelope mr-2"></i>

                            Send Welcome

                        </button>

                    </div>



                    <!-- Order -->

                    <div class="p-4 bg-green-50 rounded">

                        <h3 class="font-medium mb-2">
                            Order Shipped Notification
                        </h3>

                        <p class="text-sm text-gray-600 mb-3">
                            Sends order tracking information.
                        </p>

                        <button
                            onclick="sendOrderNotification()"
                            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">

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
                            class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600">

                            <i class="fas fa-bullhorn mr-2"></i>

                            Broadcast

                        </button>

                    </div>

                </div>

            </div>



            <!-- ===================================================== -->
            <!-- USER MANAGEMENT -->
            <!-- ===================================================== -->

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
                        class="space-y-3">

                        <input
                            type="text"
                            id="userName"
                            placeholder="Name"
                            class="w-full p-2 border rounded"
                            required>


                        <input
                            type="email"
                            id="userEmail"
                            placeholder="Email"
                            class="w-full p-2 border rounded"
                            required>


                        <input
                            type="password"
                            id="userPassword"
                            placeholder="Password"
                            class="w-full p-2 border rounded"
                            required>


                        <button
                            type="submit"
                            class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800">

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
                        class="w-full p-2 border rounded">

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


                        <label
                            class="flex items-center justify-between p-3 bg-gray-50 rounded">

                            <span>

                                <i class="fas fa-user-plus mr-2 text-blue-500"></i>

                                Welcome Notifications

                            </span>


                            <input
                                type="checkbox"
                                id="welcomePreference"
                                class="w-5 h-5"
                                checked>

                        </label>



                        <label
                            class="flex items-center justify-between p-3 bg-gray-50 rounded">

                            <span>

                                <i class="fas fa-truck mr-2 text-green-500"></i>

                                Order Shipped Notifications

                            </span>


                            <input
                                type="checkbox"
                                id="orderShippedPreference"
                                class="w-5 h-5"
                                checked>

                        </label>



                        <label
                            class="flex items-center justify-between p-3 bg-gray-50 rounded">

                            <span>

                                <i class="fas fa-credit-card mr-2 text-purple-500"></i>

                                Invoice/System Notifications

                            </span>


                            <input
                                type="checkbox"
                                id="invoicePaidPreference"
                                class="w-5 h-5"
                                checked>

                        </label>

                    </div>



                    <button
                        onclick="saveNotificationPreferences()"
                        class="mt-4 bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">

                        <i class="fas fa-save mr-2"></i>

                        Save Preferences

                    </button>

                </div>

            </div>

        </div>



        <!-- ========================================================= -->
        <!-- NOTIFICATIONS -->
        <!-- ========================================================= -->

        <div class="mt-8 bg-white rounded-lg shadow-lg p-6">


            <!-- Header -->

            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center mb-6 gap-4">

                <div>

                    <h2 class="text-xl font-semibold">

                        User Notifications

                        <span
                            id="notificationCountBadge"
                            class="ml-2 bg-blue-100 text-blue-700 text-sm px-2 py-1 rounded-full">
                            0
                        </span>

                    </h2>

                    <p class="text-sm text-gray-500 mt-1">

                        Search, filter and manage selected user's notifications.

                    </p>

                </div>


                <div class="flex flex-wrap gap-2">

                    <button
                        onclick="markAllAsRead()"
                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">

                        <i class="fas fa-check-double mr-2"></i>

                        Mark All Read

                    </button>


                    <button
                        onclick="exportNotifications()"
                        class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">

                        <i class="fas fa-download mr-2"></i>

                        Export CSV

                    </button>


                    <button
                        onclick="loadUserNotifications()"
                        class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">

                        <i class="fas fa-sync-alt mr-2"></i>

                        Refresh

                    </button>

                </div>

            </div>



            <!-- ===================================================== -->
            <!-- SEARCH + FILTERS -->
            <!-- ===================================================== -->

            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-6">


                <!-- Search -->

                <div class="md:col-span-2 relative">

                    <i
                        class="fas fa-search absolute left-3 top-3 text-gray-400"></i>


                    <input
                        type="text"
                        id="notificationSearch"
                        placeholder="Search notifications..."
                        class="w-full p-2 pl-10 border rounded"
                        oninput="applyNotificationFilters()">

                </div>



                <!-- Status -->

                <select
                    id="notificationStatusFilter"
                    class="p-2 border rounded"
                    onchange="applyNotificationFilters()">

                    <option value="all">
                        All Status
                    </option>

                    <option value="unread">
                        Unread
                    </option>

                    <option value="read">
                        Read
                    </option>

                </select>



                <!-- Type -->

                <select
                    id="notificationTypeFilter"
                    class="p-2 border rounded"
                    onchange="applyNotificationFilters()">

                    <option value="all">
                        All Types
                    </option>

                </select>

            </div>



            <!-- Sort -->

            <div class="flex flex-wrap justify-between items-center mb-4">


                <div class="text-sm text-gray-500">

                    Showing

                    <span
                        id="filteredNotificationCount"
                        class="font-semibold text-gray-700">
                        0
                    </span>

                    notifications

                </div>


                <div>

                    <select
                        id="notificationSort"
                        class="p-2 border rounded text-sm"
                        onchange="applyNotificationFilters()">

                        <option value="newest">
                            Newest First
                        </option>

                        <option value="oldest">
                            Oldest First
                        </option>

                    </select>

                </div>

            </div>



            <!-- Auto Refresh -->

            <div class="flex items-center justify-between bg-gray-50 p-3 rounded mb-4">

                <div class="flex items-center">

                    <i class="fas fa-sync-alt text-blue-500 mr-2"></i>

                    <span class="text-sm">
                        Auto refresh notifications
                    </span>

                </div>


                <label class="relative inline-flex items-center cursor-pointer">

                    <input
                        type="checkbox"
                        id="autoRefreshToggle"
                        class="sr-only peer">

                    <div
                        class="w-11 h-6 bg-gray-300 rounded-full peer
                    peer-checked:bg-blue-500
                    after:content-['']
                    after:absolute
                    after:top-[2px]
                    after:left-[2px]
                    after:bg-white
                    after:rounded-full
                    after:h-5
                    after:w-5
                    after:transition-all
                    peer-checked:after:translate-x-full"></div>

                </label>

            </div>



            <!-- Notifications Container -->

            <div
                id="notificationsContainer"
                class="space-y-3">

                <p class="text-gray-500 text-center py-4">

                    Select a user to load notifications.

                </p>

            </div>


        </div>



        <!-- ========================================================= -->
        <!-- RESPONSE MESSAGE -->
        <!-- ========================================================= -->

        <div
            id="responseMessage"
            class="fixed bottom-4 right-4 p-4 rounded-lg shadow-lg hidden z-50"></div>


    </div>



    <script>
        let currentUserId = null;

        let allNotifications = [];

        let filteredNotifications = [];

        let autoRefreshInterval = null;



        /*
        |--------------------------------------------------------------------------
        | PAGE INITIALIZATION
        |--------------------------------------------------------------------------
        */

        document.addEventListener('DOMContentLoaded', function() {

            loadUsers();

            loadAnalytics();

        });



        /*
        |--------------------------------------------------------------------------
        | LOAD USERS
        |--------------------------------------------------------------------------
        */

        async function loadUsers() {
            try {

                const response = await fetch('/api/users');

                const data = await response.json();

                const select =
                    document.getElementById('userIdSelect');

                select.innerHTML =
                    '<option value="">Select a user</option>';


                data.users.forEach(user => {

                    const option =
                        document.createElement('option');

                    option.value = user.id;

                    option.textContent =
                        `${user.name} (${user.email})`;

                    select.appendChild(option);

                });


            } catch (error) {

                console.error(error);

                showResponse(
                    'Unable to load users.',
                    'error'
                );

            }
        }



        /*
        |--------------------------------------------------------------------------
        | USER SELECTION
        |--------------------------------------------------------------------------
        */

        document
            .getElementById('userIdSelect')
            .addEventListener('change', function() {

                currentUserId = this.value;

                if (currentUserId) {

                    loadNotificationPreferences();

                    loadUserNotifications();

                } else {

                    allNotifications = [];

                    renderNotifications([]);

                }

            });



        /*
        |--------------------------------------------------------------------------
        | CREATE USER
        |--------------------------------------------------------------------------
        */

        document
            .getElementById('createUserForm')
            .addEventListener('submit', async function(e) {

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

                    const response =
                        await fetch('/api/users', {

                            method: 'POST',

                            headers: {

                                'Content-Type': 'application/json',

                                'Accept': 'application/json',

                            },

                            body: JSON.stringify(userData),

                        });


                    const data =
                        await response.json();


                    if (!response.ok) {

                        showResponse(
                            data.message ||
                            'Unable to create user.',
                            'error'
                        );

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
        | SEND WELCOME
        |--------------------------------------------------------------------------
        */

        async function sendWelcomeNotification() {

            if (!currentUserId) {

                showResponse(
                    'Please select a user first.',
                    'error'
                );

                return;

            }


            try {

                const response =
                    await fetch(
                        `/api/notifications/welcome/${currentUserId}`, {
                            method: 'POST',

                            headers: {
                                'Accept': 'application/json',
                            },
                        }
                    );


                const data =
                    await response.json();


                if (!response.ok) {

                    showResponse(
                        data.message ||
                        'Unable to send notification.',
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
        | SEND ORDER
        |--------------------------------------------------------------------------
        */

        async function sendOrderNotification() {

            if (!currentUserId) {

                showResponse(
                    'Please select a user first.',
                    'error'
                );

                return;

            }


            try {

                const response =
                    await fetch(
                        `/api/notifications/order-shipped/${currentUserId}`, {
                            method: 'POST',

                            headers: {
                                'Accept': 'application/json',
                            },
                        }
                    );


                const data =
                    await response.json();


                if (!response.ok) {

                    showResponse(
                        data.message ||
                        'Unable to send notification.',
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
        | BROADCAST
        |--------------------------------------------------------------------------
        */

        async function broadcastNotification() {

            if (
                !confirm(
                    'Send broadcast notification to all users?'
                )
            ) {

                return;

            }


            try {

                const response =
                    await fetch(
                        '/api/notifications/broadcast', {

                            method: 'POST',

                            headers: {
                                'Accept': 'application/json',
                            },

                        }
                    );


                const data =
                    await response.json();


                if (!response.ok) {

                    showResponse(
                        data.message ||
                        'Unable to broadcast notification.',
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
        | LOAD PREFERENCES
        |--------------------------------------------------------------------------
        */

        async function loadNotificationPreferences() {

            if (!currentUserId) {
                return;
            }


            try {

                const response =
                    await fetch(
                        `/api/notifications/preferences/${currentUserId}`
                    );


                const data =
                    await response.json();


                if (!response.ok) {

                    showResponse(
                        data.message ||
                        'Unable to load preferences.',
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



        /*
        |--------------------------------------------------------------------------
        | SAVE PREFERENCES
        |--------------------------------------------------------------------------
        */

        async function saveNotificationPreferences() {

            if (!currentUserId) {

                showResponse(
                    'Please select a user first.',
                    'error'
                );

                return;

            }


            try {

                const response =
                    await fetch(
                        `/api/notifications/preferences/${currentUserId}`, {

                            method: 'PUT',

                            headers: {

                                'Content-Type': 'application/json',

                                'Accept': 'application/json',

                            },

                            body: JSON.stringify({

                                welcome_enabled: document
                                    .getElementById(
                                        'welcomePreference'
                                    )
                                    .checked,

                                order_shipped_enabled: document
                                    .getElementById(
                                        'orderShippedPreference'
                                    )
                                    .checked,

                                invoice_paid_enabled: document
                                    .getElementById(
                                        'invoicePaidPreference'
                                    )
                                    .checked,

                            }),

                        }
                    );


                const data =
                    await response.json();


                if (!response.ok) {

                    showResponse(
                        data.message ||
                        'Unable to save preferences.',
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
        | LOAD USER NOTIFICATIONS
        |--------------------------------------------------------------------------
        */

        async function loadUserNotifications() {

            if (!currentUserId) {

                showResponse(
                    'Please select a user first.',
                    'error'
                );

                return;

            }


            try {

                const response =
                    await fetch(
                        `/api/notifications/user/${currentUserId}`
                    );


                const data =
                    await response.json();


                if (!response.ok) {

                    showResponse(
                        data.message ||
                        'Unable to load notifications.',
                        'error'
                    );

                    return;

                }


                allNotifications =
                    data.notifications.data || [];


                updateTypeFilter();

                applyNotificationFilters();


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
        | UPDATE TYPE FILTER
        |--------------------------------------------------------------------------
        */

        function updateTypeFilter() {

            const select =
                document.getElementById(
                    'notificationTypeFilter'
                );


            const currentValue =
                select.value;


            const types = [
                ...new Set(

                    allNotifications.map(
                        notification =>
                        notification.type || 'Unknown'
                    )

                )
            ];


            select.innerHTML = `
        <option value="all">
            All Types
        </option>
    `;


            types.forEach(type => {

                const option =
                    document.createElement('option');

                option.value = type;

                option.textContent =
                    getNotificationTypeName(type);

                select.appendChild(option);

            });


            if (
                types.includes(currentValue)
            ) {

                select.value = currentValue;

            }

        }



        /*
        |--------------------------------------------------------------------------
        | FILTER + SEARCH + SORT
        |--------------------------------------------------------------------------
        */

        function applyNotificationFilters() {

            const search =
                document
                .getElementById(
                    'notificationSearch'
                )
                .value
                .toLowerCase()
                .trim();


            const status =
                document
                .getElementById(
                    'notificationStatusFilter'
                )
                .value;


            const type =
                document
                .getElementById(
                    'notificationTypeFilter'
                )
                .value;


            const sort =
                document
                .getElementById(
                    'notificationSort'
                )
                .value;


            filteredNotifications =
                allNotifications.filter(
                    notification => {


                        const notificationData =
                            parseNotificationData(
                                notification
                            );


                        const title =
                            (
                                notificationData.title ||
                                ''
                            ).toLowerCase();


                        const message =
                            (
                                notificationData.message ||
                                ''
                            ).toLowerCase();


                        const typeName =
                            (
                                notification.type ||
                                ''
                            ).toLowerCase();


                        const matchesSearch = !search ||
                            title.includes(search) ||
                            message.includes(search) ||
                            typeName.includes(search);


                        const matchesStatus =
                            status === 'all' ||
                            (
                                status === 'read' &&
                                notification.read_at
                            ) ||
                            (
                                status === 'unread' &&
                                !notification.read_at
                            );


                        const matchesType =
                            type === 'all' ||
                            notification.type === type;


                        return (
                            matchesSearch &&
                            matchesStatus &&
                            matchesType
                        );

                    }
                );


            filteredNotifications.sort(
                (a, b) => {

                    const dateA =
                        new Date(
                            a.created_at
                        ).getTime();


                    const dateB =
                        new Date(
                            b.created_at
                        ).getTime();


                    return sort === 'newest' ?
                        dateB - dateA :
                        dateA - dateB;

                }
            );


            document
                .getElementById(
                    'filteredNotificationCount'
                )
                .textContent =
                filteredNotifications.length;


            document
                .getElementById(
                    'notificationCountBadge'
                )
                .textContent =
                allNotifications.length;


            renderNotifications(
                filteredNotifications
            );

        }



        /*
        |--------------------------------------------------------------------------
        | RENDER NOTIFICATIONS
        |--------------------------------------------------------------------------
        */

        function renderNotifications(
            notifications
        ) {

            const container =
                document.getElementById(
                    'notificationsContainer'
                );


            if (
                !notifications ||
                notifications.length === 0
            ) {

                container.innerHTML = `

            <div class="text-center py-10">

                <i class="fas fa-bell-slash text-gray-300 text-4xl mb-3"></i>

                <p class="text-gray-500">
                    No notifications found.
                </p>

            </div>

        `;

                return;

            }


            container.innerHTML = '';


            notifications.forEach(
                notification => {


                    const notificationData =
                        parseNotificationData(
                            notification
                        );


                    const icon =
                        getIcon(
                            notificationData.icon ||
                            'bell'
                        );


                    const isRead = !!notification.read_at;


                    const readClass =
                        isRead ?
                        'text-gray-500' :
                        'font-semibold';


                    const background =
                        isRead ?
                        'bg-gray-50 border-gray-300' :
                        'bg-blue-50 border-blue-500';


                    const notificationElement =
                        document.createElement(
                            'div'
                        );


                    notificationElement.className =
                        `p-4 rounded border-l-4 ${background}`;


                    notificationElement.innerHTML = `

                <div class="flex justify-between items-start gap-4">

                    <div class="flex items-start">

                        <i
                            class="${icon} mr-3 text-lg mt-1"
                        ></i>


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
                                    isRead
                                        ? ' • Read'
                                        : ' • Unread'
                                }

                            </p>

                        </div>

                    </div>



                    <div class="flex gap-3">

                        ${
                            !isRead

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

                }
            );

        }



        /*
        |--------------------------------------------------------------------------
        | PARSE NOTIFICATION DATA
        |--------------------------------------------------------------------------
        */

        function parseNotificationData(
            notification
        ) {

            try {

                if (
                    typeof notification.data ===
                    'string'
                ) {

                    return JSON.parse(
                        notification.data
                    );

                }


                return notification.data || {};

            } catch (error) {

                return {};

            }

        }



        /*
        |--------------------------------------------------------------------------
        | MARK AS READ
        |--------------------------------------------------------------------------
        */

        async function markAsRead(
            notificationId
        ) {

            try {

                const response =
                    await fetch(
                        `/api/notifications/mark-as-read/${currentUserId}/${notificationId}`, {

                            method: 'POST',

                            headers: {
                                'Accept': 'application/json',
                            },

                        }
                    );


                const data =
                    await response.json();


                if (!response.ok) {

                    showResponse(
                        data.message ||
                        'Unable to mark notification as read.',
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
        | MARK ALL AS READ
        |--------------------------------------------------------------------------
        */

        async function markAllAsRead() {

            if (!currentUserId) {

                showResponse(
                    'Please select a user first.',
                    'error'
                );

                return;

            }


            try {

                const response =
                    await fetch(
                        `/api/notifications/mark-all-read/${currentUserId}`, {

                            method: 'POST',

                            headers: {
                                'Accept': 'application/json',
                            },

                        }
                    );


                const data =
                    await response.json();


                if (!response.ok) {

                    showResponse(
                        data.message ||
                        'Unable to mark notifications as read.',
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
        | DELETE NOTIFICATION
        |--------------------------------------------------------------------------
        */

        async function deleteNotification(
            notificationId
        ) {

            if (
                !confirm(
                    'Delete this notification?'
                )
            ) {

                return;

            }


            try {

                const response =
                    await fetch(
                        `/api/notifications/delete/${currentUserId}/${notificationId}`, {

                            method: 'DELETE',

                            headers: {
                                'Accept': 'application/json',
                            },

                        }
                    );


                const data =
                    await response.json();


                if (!response.ok) {

                    showResponse(
                        data.message ||
                        'Unable to delete notification.',
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
        | ANALYTICS
        |--------------------------------------------------------------------------
        */

        async function loadAnalytics() {

            try {

                const response =
                    await fetch(
                        '/api/notifications/analytics'
                    );


                const data =
                    await response.json();


                if (!response.ok) {

                    showResponse(
                        data.message ||
                        'Unable to load analytics.',
                        'error'
                    );

                    return;

                }


                document
                    .getElementById(
                        'totalNotifications'
                    )
                    .textContent =
                    data.total_notifications;


                document
                    .getElementById(
                        'unreadNotifications'
                    )
                    .textContent =
                    data.unread_notifications;


                document
                    .getElementById(
                        'readNotifications'
                    )
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
                        getNotificationTypeName(
                            item.type
                        );


                    const element =
                        document.createElement(
                            'div'
                        );


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


                    container.appendChild(
                        element
                    );

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
        | AUTO REFRESH
        |--------------------------------------------------------------------------
        */

        document
            .getElementById(
                'autoRefreshToggle'
            )
            .addEventListener(
                'change',
                function() {


                    if (this.checked) {

                        startAutoRefresh();

                        showResponse(
                            'Auto refresh enabled.',
                            'success'
                        );

                    } else {

                        stopAutoRefresh();

                        showResponse(
                            'Auto refresh disabled.',
                            'success'
                        );

                    }

                }
            );



        function startAutoRefresh() {

            stopAutoRefresh();


            autoRefreshInterval =
                setInterval(
                    async function() {

                            if (currentUserId) {

                                await loadUserNotifications();

                            }

                            await loadAnalytics();

                        },
                        30000
                );

        }



        function stopAutoRefresh() {

            if (autoRefreshInterval) {

                clearInterval(
                    autoRefreshInterval
                );

                autoRefreshInterval = null;

            }

        }



        /*
        |--------------------------------------------------------------------------
        | EXPORT CSV
        |--------------------------------------------------------------------------
        */

        function exportNotifications() {

            if (
                !filteredNotifications ||
                filteredNotifications.length === 0
            ) {

                showResponse(
                    'No notifications available to export.',
                    'error'
                );

                return;

            }


            let csv =
                'Title,Message,Type,Status,Created At\n';


            filteredNotifications.forEach(
                notification => {


                    const data =
                        parseNotificationData(
                            notification
                        );


                    const title =
                        cleanCsvValue(
                            data.title || ''
                        );


                    const message =
                        cleanCsvValue(
                            data.message || ''
                        );


                    const type =
                        cleanCsvValue(
                            getNotificationTypeName(
                                notification.type || ''
                            )
                        );


                    const status =
                        notification.read_at ?
                        'Read' :
                        'Unread';


                    const createdAt =
                        new Date(
                            notification.created_at
                        ).toLocaleString();


                    csv +=
                        `"${title}","${message}","${type}","${status}","${createdAt}"\n`;

                }
            );


            const blob =
                new Blob(
                    [csv], {
                        type: 'text/csv;charset=utf-8;'
                    }
                );


            const url =
                URL.createObjectURL(
                    blob
                );


            const link =
                document.createElement(
                    'a'
                );


            link.href = url;

            link.download =
                'notifications.csv';


            document
                .body
                .appendChild(link);


            link.click();


            document
                .body
                .removeChild(link);


            URL.revokeObjectURL(url);


            showResponse(
                'Notifications exported successfully.',
                'success'
            );

        }



        function cleanCsvValue(
            value
        ) {

            return String(value)
                .replace(/"/g, '""')
                .replace(/\r?\n/g, ' ');

        }



        /*
        |--------------------------------------------------------------------------
        | GET NOTIFICATION TYPE NAME
        |--------------------------------------------------------------------------
        */

        function getNotificationTypeName(
            type
        ) {

            if (!type) {

                return 'Unknown';

            }


            return type
                .split('\\')
                .pop();

        }



        /*
        |--------------------------------------------------------------------------
        | ICONS
        |--------------------------------------------------------------------------
        */

        function getIcon(
            iconName
        ) {

            const icons = {

                'user-plus': 'fas fa-user-plus',

                'truck': 'fas fa-truck',

                'bell': 'fas fa-bell',

                'shopping-cart': 'fas fa-shopping-cart',

                'credit-card': 'fas fa-credit-card',

                'info': 'fas fa-info-circle',

            };


            return icons[iconName] ||
                'fas fa-bell';

        }



        /*
        |--------------------------------------------------------------------------
        | HTML ESCAPE
        |--------------------------------------------------------------------------
        */

        function escapeHtml(
            value
        ) {

            const div =
                document.createElement(
                    'div'
                );


            div.textContent =
                value ?? '';


            return div.innerHTML;

        }



        /*
        |--------------------------------------------------------------------------
        | RESPONSE MESSAGE
        |--------------------------------------------------------------------------
        */

        function showResponse(
            message,
            type
        ) {

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


            setTimeout(
                () => {

                    responseDiv.classList.add(
                        'hidden'
                    );

                },
                3000
            );

        }

        async function restoreNotification(notificationId) {

            if (!currentUserId) {
                showResponse(
                    'Please select a user first.',
                    'error'
                );
                return;
            }

            if (!confirm('Restore this notification?')) {
                return;
            }

            try {

                const response = await fetch(
                    `/api/notifications/restore/${currentUserId}/${notificationId}`, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        }
                    }
                );

                const data = await response.json();

                if (!response.ok) {

                    showResponse(
                        data.message || 'Unable to restore notification.',
                        'error'
                    );

                    return;
                }

                showResponse(
                    data.message || 'Notification restored successfully.',
                    'success'
                );

                await loadUserNotifications();
                await loadAnalytics();

            } catch (error) {

                console.error(error);

                showResponse(
                    'Error restoring notification.',
                    'error'
                );
            }
        }
    </script>



</body>

</html>