# PHP_Laravel12_Notifier

A complete and beginner-friendly Laravel 12 project that demonstrates how to implement **Email and Database Notifications** using Laravel's built-in notification system. This project includes user management, multiple notification types, API-based notification handling, and an optional web dashboard.

---

## Features

* Laravel 12 notification system implementation
* Email + Database notifications
* Multiple notification types (Welcome, Order Shipped, Invoice Paid)
* API-based notification sending
* User notification listing
* Mark single / all notifications as read
* Delete notifications
* Optional web dashboard (Tailwind CSS)
* Clean and scalable structure

---

## Requirements

* PHP 8.1 or higher
* Laravel 12.x
* Composer
* MySQL
* Mailtrap (for email testing)

---

## Step 1: Create a New Laravel Project

```bash
composer create-project laravel/laravel LaravelNotifier
cd LaravelNotifier
composer require guzzlehttp/guzzle
```

---

## Step 2: Configure Database

Update `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_notifier
DB_USERNAME=root
DB_PASSWORD=
```

Create database `laravel_notifier`.

---

## Step 3: Create Notifications Table

```bash
php artisan make:migration create_notifications_table
php artisan migrate
```

Laravel stores notifications in this table using UUIDs.

---

## Step 4: Create Notification Classes

```bash
php artisan make:notification WelcomeNotification
php artisan make:notification OrderShippedNotification
php artisan make:notification InvoicePaidNotification
```

Each notification supports:

* `via()` for channels (mail, database)
* `toMail()` for email content
* `toArray()` for database storage

---

## Step 5: User Model Configuration

Ensure `Notifiable` trait is added:

```php
use Illuminate\Notifications\Notifiable;
```

This enables notification support for users.

---

## Step 6: Mail Configuration (Mailtrap)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME="Laravel Notifier"
```

---

## Step 7: Controllers

### NotificationController Responsibilities

* Send welcome notification
* Send order shipped notification
* Broadcast notifications
* Fetch user notifications
* Mark notification as read
* Mark all as read
* Delete notifications

### UserController Responsibilities

* Create test users
* List users

---

## Step 8: API Routes

Defined in `routes/api.php`:

* Create users
* Send notifications
* Fetch notifications
* Update notification status

---

## Step 9: Web Dashboard (Optional)

A simple Tailwind CSS dashboard:

* Create users
* Send notifications
* View notifications
* Mark as read
* Delete notifications

File:

```text
resources/views/notifications/index.blade.php
```

---

## Step 10: Web Route

```php
Route::get('/', function () {
    return view('notifications.index');
});
```

---

## Step 11: Run the Application

```bash
php artisan key:generate
php artisan migrate
php artisan serve
```

Visit:

```
http://localhost:8000
```
---
## Screenshot
<img width="1810" height="892" alt="image" src="https://github.com/user-attachments/assets/56a0cdc5-e817-49d7-8526-d8a1d8dd11e3" />
<img width="1880" height="965" alt="image" src="https://github.com/user-attachments/assets/a54fc6b2-4a14-4cfd-9e75-97efa2da007e" />
<img width="1514" height="858" alt="image" src="https://github.com/user-attachments/assets/f471dbd7-f855-464c-b13b-8740ef56c964" />



---

## Step 12: Testing Flow

1. Create a user
2. Select the user
3. Send notifications
4. View notifications
5. Mark read / delete

---

## Database Structure

### notifications table

* id (UUID)
* type
* notifiable_type
* notifiable_id
* data (JSON)
* read_at
* timestamps

---

## API Endpoints Summary

| Method | Endpoint                                   | Description          |
| ------ | ------------------------------------------ | -------------------- |
| POST   | /api/users                                 | Create user          |
| GET    | /api/users                                 | List users           |
| POST   | /api/notifications/welcome/{id}            | Welcome notification |
| POST   | /api/notifications/order-shipped/{id}      | Order shipped        |
| GET    | /api/notifications/user/{id}               | Get notifications    |
| POST   | /api/notifications/mark-as-read/{id}/{nid} | Mark read            |
| DELETE | /api/notifications/delete/{id}/{nid}       | Delete               |

---

## Possible Enhancements

* Real-time notifications (Pusher + Echo)
* SMS notifications (Twilio / Vonage)
* Scheduled notifications (Queues)
* Notification preferences per user
* Admin analytics dashboard

---

## Learning Outcomes

* Laravel Notification System
* Email + Database notifications
* REST API design
* UUID-based storage
* Clean MVC architecture

---

## License

MIT License

---

## Author

Mihir Mehta
Laravel Developer

---

This project is ideal for learning, interviews, MCA projects, and real-world notification workflows.
