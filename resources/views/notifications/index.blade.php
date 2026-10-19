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


<body class="bg-gray-100 min-h-screen">

    <!-- Top Sticky Bar with Real-time Floating Bell Dropdown -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-gray-200 shadow-sm">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white shadow-md">
                    <i class="fas fa-bolt text-lg"></i>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-gray-800 leading-tight">Laravel Notifier <span class="text-xs font-semibold bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full ml-1">v12 Pro</span></h1>
                    <p class="text-xs text-gray-500">Real-time WebSockets & Multi-Channel Alert Studio</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <!-- Sound Toggle -->
                <button id="soundToggleBtn" onclick="toggleSound()" class="px-3 py-1.5 rounded-lg border text-xs font-medium flex items-center gap-1.5 transition-all bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100" title="Toggle audio chime on new notifications">
                    <i id="soundIcon" class="fas fa-volume-up"></i>
                    <span id="soundText" class="hidden sm:inline">Chime: ON</span>
                </button>

                <!-- Live Poll Status Indicator -->
                <div id="liveStatusBadge" class="hidden sm:flex items-center gap-1.5 text-xs text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                    <span>Live Stream Active</span>
                </div>

                <!-- Floating Bell Dropdown Trigger -->
                <div class="relative">
                    <button id="bellButton" onclick="toggleBellDropdown()" class="relative p-2.5 rounded-xl text-gray-600 hover:text-blue-600 hover:bg-gray-100 transition focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <i class="fas fa-bell text-xl"></i>
                        <span id="bellBadge" class="hidden absolute top-1 right-1 w-5 h-5 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-white animate-pulse">0</span>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="bellDropdown" class="hidden absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50 transition-all">
                        <div class="p-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-bell"></i>
                                <span class="font-semibold text-sm">Notifications</span>
                                <span id="bellDropdownBadge" class="text-xs bg-white/20 text-white px-2 py-0.5 rounded-full">0 new</span>
                            </div>
                            <button onclick="markAllAsRead()" class="text-xs text-white/90 hover:text-white underline">Mark all read</button>
                        </div>

                        <!-- Dropdown List Container -->
                        <div id="bellDropdownList" class="max-h-80 overflow-y-auto divide-y divide-gray-100">
                            <div class="p-6 text-center text-gray-400 text-xs">
                                <i class="fas fa-bell-slash text-2xl mb-1 text-gray-300"></i>
                                <p>Select a user to view live unread notifications.</p>
                            </div>
                        </div>

                        <div class="p-2.5 bg-gray-50 text-center border-t border-gray-100">
                            <a href="#notificationsContainer" onclick="closeBellDropdown()" class="text-xs font-medium text-blue-600 hover:text-blue-800">
                                View All in Main Table &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 py-8">

        <!-- ========================================================= -->
        <!-- PAGE HEADER -->
        <!-- ========================================================= -->

        <div class="mb-8 text-center">

            <h1 class="text-3xl font-bold text-gray-800">
                Laravel Notifier Dashboard
            </h1>

            <p class="text-gray-500 mt-2">
                Real-Time WebSockets • Visual Template Engine • Audience Segmentation & Bulk Actions
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



                    <!-- Broadcast with Audience Segmentation -->
                    <div class="p-4 bg-purple-50 rounded border border-purple-200">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-medium text-purple-900 flex items-center gap-2">
                                <i class="fas fa-bullhorn text-purple-600"></i>
                                Targeted Broadcast
                            </h3>
                            <span class="text-xs bg-purple-200 text-purple-800 px-2 py-0.5 rounded-full font-semibold">Audience Segments</span>
                        </div>
                        <p class="text-xs text-gray-600 mb-3">
                            Target notifications by user role or activity status instead of broadcasting blindly.
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Target Segment</label>
                                <select id="broadcastAudience" onchange="toggleAudienceOptions()" class="w-full p-1.5 text-xs border rounded bg-white">
                                    <option value="all">All Users</option>
                                    <option value="role">Target by Role</option>
                                    <option value="status">Target by Status</option>
                                </select>
                            </div>
                            <div id="audienceParamContainer" class="hidden">
                                <label id="audienceParamLabel" class="block text-xs font-medium text-gray-600 mb-1">Select Value</label>
                                <select id="audienceParamSelect" class="w-full p-1.5 text-xs border rounded bg-white">
                                    <!-- Dynamic -->
                                </select>
                            </div>
                        </div>

                        <button
                            onclick="broadcastNotification()"
                            class="bg-purple-600 text-white px-3 py-1.5 text-xs font-medium rounded hover:bg-purple-700 flex items-center gap-1.5 shadow">
                            <i class="fas fa-paper-plane"></i>
                            Send Segmented Broadcast
                        </button>
                    </div>

                    <!-- Visual Template Builder & Custom Notification Maker -->
                    <div class="p-4 bg-gradient-to-br from-amber-50 to-orange-50 rounded border border-amber-200">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-medium text-amber-900 flex items-center gap-2">
                                <i class="fas fa-palette text-amber-600"></i>
                                Visual Template Builder
                            </h3>
                            <span class="text-xs bg-amber-200 text-amber-800 px-2 py-0.5 rounded-full font-semibold">Dynamic Variables</span>
                        </div>
                        <p class="text-xs text-gray-600 mb-2">
                            Create custom notifications with live variable placeholders like <code class="bg-amber-100 text-amber-800 px-1 py-0.5 rounded font-mono text-[11px]">{user_name}</code>, <code class="bg-amber-100 text-amber-800 px-1 py-0.5 rounded font-mono text-[11px]">{order_id}</code>, <code class="bg-amber-100 text-amber-800 px-1 py-0.5 rounded font-mono text-[11px]">{amount}</code>.
                        </p>

                        <!-- Quick Template Presets -->
                        <div class="mb-3">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Quick Presets:</label>
                            <div class="flex flex-wrap gap-1">
                                <button type="button" onclick="applyPreset('festive')" class="text-[11px] bg-white border border-amber-300 text-amber-800 px-2 py-0.5 rounded hover:bg-amber-100 transition">🎉 Festive Offer</button>
                                <button type="button" onclick="applyPreset('security')" class="text-[11px] bg-white border border-red-300 text-red-800 px-2 py-0.5 rounded hover:bg-red-100 transition">🔒 Security Alert</button>
                                <button type="button" onclick="applyPreset('payment')" class="text-[11px] bg-white border border-emerald-300 text-emerald-800 px-2 py-0.5 rounded hover:bg-emerald-100 transition">💳 Payment Receipt</button>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div>
                                <input type="text" id="customTitle" placeholder="Notification Title e.g. Special Offer for {user_name}!" class="w-full p-2 text-xs border rounded bg-white font-medium" value="Special Offer for {user_name}!">
                            </div>
                            <div>
                                <textarea id="customMessage" rows="2" placeholder="Message content e.g. Dear {user_name}, you have a coupon for {order_id} worth {amount}." class="w-full p-2 text-xs border rounded bg-white">Dear {user_name}, your VIP discount code is active today! Order {order_id} gets flat 20% off on {amount}.</textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-[11px] text-gray-500 mb-0.5">Priority</label>
                                    <select id="customPriority" class="w-full p-1.5 text-xs border rounded bg-white">
                                        <option value="info">ℹ️ Info</option>
                                        <option value="success">✅ Success</option>
                                        <option value="warning">⚠️ Warning</option>
                                        <option value="critical">⚡ Critical</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[11px] text-gray-500 mb-0.5">Action Button Text</label>
                                    <input type="text" id="customActionText" placeholder="e.g. Claim Now" class="w-full p-1.5 text-xs border rounded bg-white" value="Claim Reward">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-[11px] text-gray-500 mb-0.5">Sample Order ID</label>
                                    <input type="text" id="customOrderId" placeholder="ORD-9999" class="w-full p-1.5 text-xs border rounded bg-white" value="ORD-7821">
                                </div>
                                <div>
                                    <label class="block text-[11px] text-gray-500 mb-0.5">Sample Amount</label>
                                    <input type="text" id="customAmount" placeholder="₹1,200" class="w-full p-1.5 text-xs border rounded bg-white" value="₹1,850">
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-1">
                                <label class="flex items-center gap-1.5 text-xs text-gray-600 cursor-pointer">
                                    <input type="checkbox" id="customSendEmail" class="rounded text-amber-600">
                                    <span>Also Send Email</span>
                                </label>

                                <div class="flex gap-2">
                                    <button onclick="sendCustomToSelectedUser()" class="bg-amber-600 text-white px-3 py-1.5 text-xs font-medium rounded hover:bg-amber-700 transition shadow">
                                        <i class="fas fa-paper-plane mr-1"></i> Send to Selected User
                                    </button>
                                    <button onclick="broadcastCustomTemplate()" class="bg-gray-800 text-white px-3 py-1.5 text-xs font-medium rounded hover:bg-black transition shadow" title="Broadcast custom template according to segment filter above">
                                        <i class="fas fa-users mr-1"></i> Broadcast Template
                                    </button>
                                </div>
                            </div>
                        </div>
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

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Role</label>
                                <select id="userRole" class="w-full p-2 border rounded text-sm bg-gray-50">
                                    <option value="user">User</option>
                                    <option value="customer">Customer</option>
                                    <option value="vendor">Vendor</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Audience Status</label>
                                <select id="userStatus" class="w-full p-2 border rounded text-sm bg-gray-50">
                                    <option value="active">Active</option>
                                    <option value="vip">VIP</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>

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


                <div class="flex flex-wrap gap-2 items-center">
                    <!-- Batch Action Buttons (Hidden when nothing selected) -->
                    <div id="batchActionToolbar" class="hidden flex items-center gap-2 bg-indigo-50 border border-indigo-200 px-3 py-1.5 rounded-lg">
                        <span class="text-xs font-semibold text-indigo-700">
                            <span id="selectedCountBadge">0</span> selected:
                        </span>
                        <button
                            onclick="executeBatchMarkAsRead()"
                            class="bg-emerald-600 text-white px-2.5 py-1 rounded text-xs hover:bg-emerald-700 font-medium flex items-center gap-1 shadow-sm">
                            <i class="fas fa-check"></i>
                            Mark Read
                        </button>
                        <button
                            onclick="executeBatchDelete()"
                            class="bg-red-600 text-white px-2.5 py-1 rounded text-xs hover:bg-red-700 font-medium flex items-center gap-1 shadow-sm">
                            <i class="fas fa-trash"></i>
                            Move to Trash
                        </button>
                    </div>

                    <button
                        onclick="markAllAsRead()"
                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 text-sm font-medium">

                        <i class="fas fa-check-double mr-2"></i>

                        Mark All Read

                    </button>


                    <button
                        onclick="exportNotifications()"
                        class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600 text-sm font-medium">

                        <i class="fas fa-download mr-2"></i>

                        Export CSV

                    </button>


                    <button
                        onclick="loadUserNotifications()"
                        class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300 text-sm font-medium">

                        <i class="fas fa-sync-alt mr-2"></i>

                        Refresh

                    </button>

                </div>

            </div>

            <!-- Batch Select All Bar -->
            <div class="flex items-center justify-between bg-gray-50 border border-gray-200 px-4 py-2.5 rounded-lg mb-4 text-xs text-gray-700">
                <label class="flex items-center gap-2 cursor-pointer select-none font-medium">
                    <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this.checked)" class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500">
                    <span>Select All Filtered Notifications</span>
                </label>
                <span class="text-gray-400">Click individual checkboxes below to batch-operate</span>
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

        // New Feature State Variables
        let soundEnabled = true;
        let lastPollTimestamp = null;
        let livePollInterval = null;
        let selectedNotificationIds = new Set();
        let loadedUsersList = [];

        /*
        |--------------------------------------------------------------------------
        | AUDIO SYNTHESIS / CHIME (Web Audio API)
        |--------------------------------------------------------------------------
        */
        function playChimeSound() {
            if (!soundEnabled) return;
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const now = ctx.currentTime;

                // Two-tone pleasant notification chime
                const osc1 = ctx.createOscillator();
                const gain1 = ctx.createGain();
                osc1.type = 'sine';
                osc1.frequency.setValueAtTime(587.33, now); // D5
                osc1.frequency.exponentialRampToValueAtTime(880, now + 0.15); // A5
                gain1.gain.setValueAtTime(0.15, now);
                gain1.gain.exponentialRampToValueAtTime(0.001, now + 0.45);

                osc1.connect(gain1);
                gain1.connect(ctx.destination);
                osc1.start(now);
                osc1.stop(now + 0.45);
            } catch (e) {
                console.log('Audio autoplay prevented or unsupported:', e);
            }
        }

        function toggleSound() {
            soundEnabled = !soundEnabled;
            const btn = document.getElementById('soundToggleBtn');
            const icon = document.getElementById('soundIcon');
            const text = document.getElementById('soundText');

            if (soundEnabled) {
                btn.className = "px-3 py-1.5 rounded-lg border text-xs font-medium flex items-center gap-1.5 transition-all bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100";
                icon.className = "fas fa-volume-up";
                text.textContent = "Chime: ON";
                playChimeSound();
                showResponse('Sound chime enabled.', 'success');
            } else {
                btn.className = "px-3 py-1.5 rounded-lg border text-xs font-medium flex items-center gap-1.5 transition-all bg-gray-100 text-gray-500 border-gray-300 hover:bg-gray-200";
                icon.className = "fas fa-volume-mute";
                text.textContent = "Chime: OFF";
                showResponse('Sound chime muted.', 'success');
            }
        }

        /*
        |--------------------------------------------------------------------------
        | FLOATING BELL DROPDOWN
        |--------------------------------------------------------------------------
        */
        function toggleBellDropdown() {
            const dropdown = document.getElementById('bellDropdown');
            dropdown.classList.toggle('hidden');
        }

        function closeBellDropdown() {
            document.getElementById('bellDropdown').classList.add('hidden');
        }

        document.addEventListener('click', function(e) {
            const bellBtn = document.getElementById('bellButton');
            const bellDropdown = document.getElementById('bellDropdown');
            if (!bellBtn.contains(e.target) && !bellDropdown.contains(e.target)) {
                bellDropdown.classList.add('hidden');
            }
        });

        /*
        |--------------------------------------------------------------------------
        | PAGE INITIALIZATION
        |--------------------------------------------------------------------------
        */

        document.addEventListener('DOMContentLoaded', function() {

            loadUsers();

            loadAnalytics();

            startLivePolling();

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

                loadedUsersList = data.users || [];

                const select =
                    document.getElementById('userIdSelect');

                select.innerHTML =
                    '<option value="">Select a user</option>';


                loadedUsersList.forEach(user => {

                    const option =
                        document.createElement('option');

                    option.value = user.id;

                    const roleBadge = user.role ? `[${user.role.toUpperCase()}]` : '';
                    const statusBadge = user.status ? `(${user.status})` : '';

                    option.textContent =
                        `${user.name} ${roleBadge} ${statusBadge} - ${user.email}`;

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

                selectedNotificationIds.clear();
                updateBatchToolbar();

                if (currentUserId) {

                    loadNotificationPreferences();

                    loadUserNotifications();

                    pollLiveNotifications();

                } else {

                    allNotifications = [];

                    renderNotifications([]);

                    renderBellDropdown(0, []);

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

                    role: document
                        .getElementById('userRole')
                        .value,

                    status: document
                        .getElementById('userStatus')
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
        | AUDIENCE SEGMENTATION CONTROLS
        |--------------------------------------------------------------------------
        */
        function toggleAudienceOptions() {
            const audience = document.getElementById('broadcastAudience').value;
            const container = document.getElementById('audienceParamContainer');
            const label = document.getElementById('audienceParamLabel');
            const select = document.getElementById('audienceParamSelect');

            if (audience === 'all') {
                container.classList.add('hidden');
            } else if (audience === 'role') {
                container.classList.remove('hidden');
                label.textContent = "Select Role";
                select.innerHTML = `
                    <option value="customer">Customer</option>
                    <option value="vendor">Vendor</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                `;
            } else if (audience === 'status') {
                container.classList.remove('hidden');
                label.textContent = "Select Audience Status";
                select.innerHTML = `
                    <option value="active">Active</option>
                    <option value="vip">VIP</option>
                    <option value="inactive">Inactive</option>
                `;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | TEMPLATE PRESETS
        |--------------------------------------------------------------------------
        */
        function applyPreset(preset) {
            const titleInput = document.getElementById('customTitle');
            const msgInput = document.getElementById('customMessage');
            const priorityInput = document.getElementById('customPriority');
            const actionTextInput = document.getElementById('customActionText');

            if (preset === 'festive') {
                titleInput.value = "Diwali Mega Offer for {user_name}! 🪔";
                msgInput.value = "Happy Diwali, {user_name}! Enjoy an exclusive 30% discount on order {order_id}. Valid for your role ({user_role}).";
                priorityInput.value = "success";
                actionTextInput.value = "Shop Now";
            } else if (preset === 'security') {
                titleInput.value = "Security Alert: Login from New Device";
                msgInput.value = "Hello {user_name}, a new login attempt was verified for {user_email} at {date}. Please secure your account if this was not you.";
                priorityInput.value = "critical";
                actionTextInput.value = "Review Security";
            } else if (preset === 'payment') {
                titleInput.value = "Payment Received: {amount} ✅";
                msgInput.value = "Dear {user_name}, we have received your payment of {amount} for {order_id}. Thank you for doing business with us!";
                priorityInput.value = "info";
                actionTextInput.value = "View Invoice";
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SEND CUSTOM TO SELECTED USER
        |--------------------------------------------------------------------------
        */
        async function sendCustomToSelectedUser() {
            if (!currentUserId) {
                showResponse('Please select a user first.', 'error');
                return;
            }

            const title = document.getElementById('customTitle').value.trim();
            const message = document.getElementById('customMessage').value.trim();
            const priority = document.getElementById('customPriority').value;
            const actionText = document.getElementById('customActionText').value.trim();
            const orderId = document.getElementById('customOrderId').value.trim();
            const amount = document.getElementById('customAmount').value.trim();
            const sendEmail = document.getElementById('customSendEmail').checked;

            if (!title || !message) {
                showResponse('Title and message are required.', 'error');
                return;
            }

            try {
                const response = await fetch(`/api/notifications/custom/${currentUserId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        title: title,
                        message: message,
                        priority: priority,
                        action_text: actionText,
                        action_url: '/orders/' + orderId,
                        send_email: sendEmail,
                        order_id: orderId,
                        amount: amount,
                    }),
                });

                const data = await response.json();

                if (!response.ok) {
                    showResponse(data.message || 'Unable to send custom notification.', 'error');
                    return;
                }

                showResponse(data.message, 'success');
                await loadUserNotifications();
                await loadAnalytics();
                pollLiveNotifications();

            } catch (error) {
                console.error(error);
                showResponse('Error sending custom notification.', 'error');
            }
        }

        /*
        |--------------------------------------------------------------------------
        | BROADCAST CUSTOM TEMPLATE (With Segmentation)
        |--------------------------------------------------------------------------
        */
        async function broadcastCustomTemplate() {
            const audience = document.getElementById('broadcastAudience').value;
            const paramVal = document.getElementById('audienceParamSelect') ? document.getElementById('audienceParamSelect').value : null;

            const title = document.getElementById('customTitle').value.trim();
            const message = document.getElementById('customMessage').value.trim();
            const priority = document.getElementById('customPriority').value;
            const actionText = document.getElementById('customActionText').value.trim();
            const orderId = document.getElementById('customOrderId').value.trim();
            const amount = document.getElementById('customAmount').value.trim();
            const sendEmail = document.getElementById('customSendEmail').checked;

            if (!title || !message) {
                showResponse('Title and message are required for broadcast template.', 'error');
                return;
            }

            const confirmMsg = audience === 'all'
                ? 'Broadcast this custom template to ALL users?'
                : `Broadcast this custom template to all users with ${audience}="${paramVal}"?`;

            if (!confirm(confirmMsg)) return;

            const payload = {
                audience: audience,
                role: audience === 'role' ? paramVal : null,
                status: audience === 'status' ? paramVal : null,
                title: title,
                message: message,
                priority: priority,
                action_text: actionText,
                action_url: '/orders/' + orderId,
                send_email: sendEmail,
                order_id: orderId,
                amount: amount,
            };

            try {
                const response = await fetch('/api/notifications/broadcast', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(payload),
                });

                const data = await response.json();

                if (!response.ok) {
                    showResponse(data.message || 'Unable to broadcast custom template.', 'error');
                    return;
                }

                showResponse(data.message, 'success');
                await loadUserNotifications();
                await loadAnalytics();
                pollLiveNotifications();

            } catch (error) {
                console.error(error);
                showResponse('Error broadcasting template.', 'error');
            }
        }

        /*
        |--------------------------------------------------------------------------
        | BROADCAST (Targeted Segmented Broadcast)
        |--------------------------------------------------------------------------
        */
        async function broadcastNotification() {
            const audience = document.getElementById('broadcastAudience').value;
            const paramVal = document.getElementById('audienceParamSelect') ? document.getElementById('audienceParamSelect').value : null;

            const confirmMsg = audience === 'all'
                ? 'Send broadcast notification to ALL users?'
                : `Send broadcast notification to users with ${audience}="${paramVal}"?`;

            if (!confirm(confirmMsg)) return;

            const payload = {
                audience: audience,
                role: audience === 'role' ? paramVal : null,
                status: audience === 'status' ? paramVal : null,
            };

            try {
                const response = await fetch('/api/notifications/broadcast', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(payload),
                });

                const data = await response.json();

                if (!response.ok) {
                    showResponse(data.message || 'Unable to broadcast notification.', 'error');
                    return;
                }

                showResponse(data.message, 'success');
                await loadUserNotifications();
                await loadAnalytics();
                pollLiveNotifications();

            } catch (error) {
                console.error(error);
                showResponse('Error broadcasting notification.', 'error');
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


                    const isChecked = selectedNotificationIds.has(notification.id);
                    const priority = notificationData.priority || 'info';

                    const priorityBadge = notificationData.type === 'custom_announcement' ? `
                        <span class="ml-2 text-[10px] font-semibold uppercase px-2 py-0.5 rounded-full ${
                            priority === 'critical' ? 'bg-red-100 text-red-700 border border-red-200' :
                            priority === 'warning'  ? 'bg-amber-100 text-amber-700 border border-amber-200' :
                            priority === 'success'  ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' :
                            'bg-blue-100 text-blue-700 border border-blue-200'
                        }">${priority}</span>
                    ` : '';

                    const actionBtn = (notificationData.action_text && notificationData.action_url) ? `
                        <div class="mt-2">
                            <a href="${escapeHtml(notificationData.action_url)}" target="_blank" class="inline-flex items-center gap-1 text-xs font-semibold bg-gray-900 text-white px-2.5 py-1 rounded hover:bg-black transition">
                                <span>${escapeHtml(notificationData.action_text)}</span>
                                <i class="fas fa-external-link-alt text-[10px]"></i>
                            </a>
                        </div>
                    ` : '';

                    notificationElement.innerHTML = `

                <div class="flex justify-between items-start gap-3">

                    <div class="flex items-start gap-3">

                        <!-- Batch Selection Checkbox -->
                        <div class="pt-1">
                            <input
                                type="checkbox"
                                class="notification-checkbox w-4 h-4 rounded text-blue-600 cursor-pointer"
                                data-id="${notification.id}"
                                ${isChecked ? 'checked' : ''}
                                onchange="handleItemCheckboxChange(this, '${notification.id}')"
                            >
                        </div>

                        <i
                            class="${icon} mr-1 text-lg mt-1 text-gray-700"
                        ></i>


                        <div>

                            <div class="flex items-center flex-wrap gap-1">
                                <h3 class="${readClass}">

                                    ${escapeHtml(
                                        notificationData.title ||
                                        'Notification'
                                    )}

                                </h3>
                                ${priorityBadge}
                            </div>


                            <p class="text-gray-600 text-sm mt-0.5">

                                ${escapeHtml(
                                    notificationData.message ||
                                    ''
                                )}

                            </p>

                            ${actionBtn}


                            <p class="text-xs text-gray-400 mt-1.5 flex items-center gap-2">

                                <span><i class="far fa-clock mr-1"></i>${new Date(
                                    notification.created_at
                                ).toLocaleString()}</span>

                                <span>•</span>

                                <span class="${isRead ? 'text-gray-400' : 'text-blue-600 font-semibold'}">
                                    ${
                                        isRead
                                            ? 'Read'
                                            : '● Unread'
                                    }
                                </span>

                            </p>

                        </div>

                    </div>



                    <div class="flex gap-2 items-center">

                        ${
                            !isRead

                                ? `

                                    <button
                                        onclick="markAsRead('${notification.id}')"
                                        class="p-1.5 rounded hover:bg-blue-100 text-blue-600 transition"
                                        title="Mark as read"
                                    >

                                        <i class="fas fa-check"></i>

                                    </button>

                                  `

                                : ''
                        }


                        <button
                            onclick="deleteNotification('${notification.id}')"
                            class="p-1.5 rounded hover:bg-red-100 text-red-500 transition"
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

        /*
        |--------------------------------------------------------------------------
        | BATCH SELECTION & ACTIONS
        |--------------------------------------------------------------------------
        */
        function handleItemCheckboxChange(checkbox, notificationId) {
            if (checkbox.checked) {
                selectedNotificationIds.add(notificationId);
            } else {
                selectedNotificationIds.delete(notificationId);
            }
            updateBatchToolbar();
        }

        function toggleSelectAll(checked) {
            const checkboxes = document.querySelectorAll('.notification-checkbox');
            checkboxes.forEach(cb => {
                cb.checked = checked;
                const id = cb.getAttribute('data-id');
                if (checked) {
                    selectedNotificationIds.add(id);
                } else {
                    selectedNotificationIds.delete(id);
                }
            });
            updateBatchToolbar();
        }

        function updateBatchToolbar() {
            const count = selectedNotificationIds.size;
            const toolbar = document.getElementById('batchActionToolbar');
            const badge = document.getElementById('selectedCountBadge');
            const selectAllCb = document.getElementById('selectAllCheckbox');

            if (badge) badge.textContent = count;

            if (toolbar) {
                if (count > 0) {
                    toolbar.classList.remove('hidden');
                } else {
                    toolbar.classList.add('hidden');
                }
            }

            if (selectAllCb) {
                const totalFiltered = filteredNotifications.length;
                selectAllCb.checked = totalFiltered > 0 && count === totalFiltered;
            }
        }

        async function executeBatchMarkAsRead() {
            if (!currentUserId) {
                showResponse('Please select a user first.', 'error');
                return;
            }

            const ids = Array.from(selectedNotificationIds);
            if (ids.length === 0) {
                showResponse('Please select at least one notification.', 'error');
                return;
            }

            try {
                const response = await fetch(`/api/notifications/batch-mark-as-read/${currentUserId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ notification_ids: ids }),
                });

                const data = await response.json();

                if (!response.ok) {
                    showResponse(data.message || 'Batch action failed.', 'error');
                    return;
                }

                showResponse(data.message, 'success');
                selectedNotificationIds.clear();
                updateBatchToolbar();

                await loadUserNotifications();
                await loadAnalytics();
                pollLiveNotifications();

            } catch (error) {
                console.error(error);
                showResponse('Error running batch mark as read.', 'error');
            }
        }

        async function executeBatchDelete() {
            if (!currentUserId) {
                showResponse('Please select a user first.', 'error');
                return;
            }

            const ids = Array.from(selectedNotificationIds);
            if (ids.length === 0) {
                showResponse('Please select at least one notification.', 'error');
                return;
            }

            if (!confirm(`Move ${ids.length} selected notification(s) to trash?`)) {
                return;
            }

            try {
                const response = await fetch(`/api/notifications/batch-delete/${currentUserId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ notification_ids: ids }),
                });

                const data = await response.json();

                if (!response.ok) {
                    showResponse(data.message || 'Batch delete failed.', 'error');
                    return;
                }

                showResponse(data.message, 'success');
                selectedNotificationIds.clear();
                updateBatchToolbar();

                await loadUserNotifications();
                await loadAnalytics();
                pollLiveNotifications();

            } catch (error) {
                console.error(error);
                showResponse('Error running batch delete.', 'error');
            }
        }

        /*
        |--------------------------------------------------------------------------
        | REAL-TIME STREAMING & LONG-POLLING (Live Bell & Chime)
        |--------------------------------------------------------------------------
        */
        function startLivePolling() {
            if (livePollInterval) clearInterval(livePollInterval);

            // Fast interval (every 4 seconds) to simulate real-time socket events smoothly
            livePollInterval = setInterval(() => {
                if (currentUserId) {
                    pollLiveNotifications();
                }
            }, 4000);
        }

        async function pollLiveNotifications() {
            if (!currentUserId) return;

            try {
                let url = `/api/notifications/live-poll/${currentUserId}`;
                if (lastPollTimestamp) {
                    url += `?since=${encodeURIComponent(lastPollTimestamp)}`;
                }

                const response = await fetch(url);
                if (!response.ok) return;

                const data = await response.json();
                lastPollTimestamp = data.server_time;

                // Update Bell Badge and Dropdown
                renderBellDropdown(data.unread_count, data.recent_unread || []);

                // Detect new incoming notifications -> Play chime and show toast
                if (data.new_notifications && data.new_notifications.length > 0) {
                    playChimeSound();

                    data.new_notifications.forEach(item => {
                        const parsed = parseNotificationData(item);
                        showResponse(`🔔 New: ${parsed.title || 'Notification received!'}`, 'success');
                    });

                    // Auto-refresh main list and analytics if on screen
                    await loadUserNotifications();
                    await loadAnalytics();
                }

            } catch (err) {
                console.debug('Polling background tick:', err);
            }
        }

        function renderBellDropdown(unreadCount, recentList) {
            const bellBadge = document.getElementById('bellBadge');
            const dropdownBadge = document.getElementById('bellDropdownBadge');
            const dropdownList = document.getElementById('bellDropdownList');

            if (unreadCount > 0) {
                bellBadge.textContent = unreadCount > 99 ? '99+' : unreadCount;
                bellBadge.classList.remove('hidden');
                dropdownBadge.textContent = `${unreadCount} unread`;
            } else {
                bellBadge.classList.add('hidden');
                dropdownBadge.textContent = '0 unread';
            }

            if (!recentList || recentList.length === 0) {
                dropdownList.innerHTML = `
                    <div class="p-6 text-center text-gray-400 text-xs">
                        <i class="fas fa-check-circle text-2xl mb-1 text-emerald-400"></i>
                        <p>All caught up! No unread notifications.</p>
                    </div>
                `;
                return;
            }

            dropdownList.innerHTML = '';
            recentList.forEach(item => {
                const data = parseNotificationData(item);
                const icon = getIcon(data.icon || 'bell');
                const row = document.createElement('div');
                row.className = "p-3 hover:bg-blue-50/70 transition flex items-start gap-3 cursor-pointer group";

                row.innerHTML = `
                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 text-xs mt-0.5">
                        <i class="${icon}"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-800 truncate group-hover:text-blue-600">${escapeHtml(data.title || 'Notification')}</p>
                        <p class="text-[11px] text-gray-500 line-clamp-2 mt-0.5">${escapeHtml(data.message || '')}</p>
                        <p class="text-[10px] text-gray-400 mt-1">${new Date(item.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</p>
                    </div>
                    <button onclick="event.stopPropagation(); markAsRead('${item.id}')" title="Mark Read" class="text-gray-300 hover:text-emerald-600 text-xs p-1">
                        <i class="fas fa-check"></i>
                    </button>
                `;

                row.onclick = () => {
                    markAsRead(item.id);
                };

                dropdownList.appendChild(row);
            });
        }
    </script>

</body>

</html>