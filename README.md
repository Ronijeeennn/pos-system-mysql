# Basic POS System (CodeIgniter 4 + MySQL)

A basic Point-of-Sale system built with **CodeIgniter 4.7**. Customer and user accounts are stored in
**MySQL** and managed through CodeIgniter Models. You can list, create, and edit both kinds of account,
and upload a profile picture (avatar) for users.

- **Live demo:** _paste your hosted URL here_
- **Repository:** _paste your repository URL here_

## Features

- Customer Accounts: list, **New Customer** form, **Edit** form (full name and a valid email are required)
- User Accounts: list, **New User** form, **Edit** form (username is required and unique, full name is required)
- Avatar upload on the user edit form: JPG or PNG, up to 2 MB, saved as a 200 x 200 square thumbnail
  in `public/uploads/avatars/`; only the file name is stored in the database
- A placeholder image is shown for users without an avatar
- Server-side validation with error messages next to each field, plus CSRF protection on every form

## Requirements

- PHP 8.2 or newer with the `intl`, `mbstring`, `mysqlnd` and **`gd`** extensions enabled
  (GD creates the avatar thumbnails)
- MySQL 5.7+ / MariaDB 10.4+ (XAMPP, Laragon, or similar)
- [Composer](https://getcomposer.org/) (only needed if the `vendor/` folder is missing)

## Setup

1. **Install dependencies** (skip if `vendor/` already exists):
   ```
   composer install
   ```
2. **Create the database.** Import the export in phpMyAdmin (Import tab), or from a terminal:
   ```
   mysql -u root -p < database/pos_system.sql
   ```
   This creates `pos_system` with the `customers` and `users` tables and 6 sample rows in each.
   The `users` table already includes the `avatar` column.

   **Upgrading a database that came from the previous lab?** Do not re-import (that would erase your data).
   Select your database and run `database/tfa3_add_avatar.sql` instead; it only adds the `avatar` column.
3. **Configure the environment.** Copy `.env.example` to `.env` and adjust the `database.default.*`
   values if your MySQL username or password is different.
4. **Make sure `public/uploads/avatars/` is writable** (it is by default on a local machine).
5. **Run the app:**
   ```
   php spark serve
   ```
   Then open <http://localhost:8080>.

## Database schema

```sql
CREATE TABLE customers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  phone VARCHAR(20),
  created_at DATETIME NOT NULL
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  full_name VARCHAR(100) NOT NULL,
  avatar VARCHAR(255) NULL,        -- file name only, e.g. user_3_a1b2c3d4e5f6.jpg
  created_at DATETIME NOT NULL
);
```

## Routes

| URL | Method | Page / action |
|---|---|---|
| `/` | GET | Home |
| `/about` | GET | About |
| `/customers` | GET | Customer Accounts list |
| `/customers/new` | GET | New Customer form |
| `/customers/create` | POST | Validates and inserts a customer |
| `/customers/edit/{id}` | GET | Edit Customer form (pre-filled) |
| `/customers/update/{id}` | POST | Validates and updates a customer |
| `/users` | GET | User Accounts list (with avatars) |
| `/users/new` | GET | New User form |
| `/users/create` | POST | Validates and inserts a user |
| `/users/edit/{id}` | GET | Edit User form (pre-filled, with avatar upload) |
| `/users/update/{id}` | POST | Validates, prepares the avatar thumbnail, and updates a user |

## Project structure (the parts that matter for these activities)

| Path | Purpose |
|---|---|
| `.env` | Database connection settings (not committed; see `.env.example`) |
| `app/Config/Routes.php` | All routes |
| `app/Config/Filters.php` | Turns on CSRF protection for all form submissions |
| `app/Models/CustomerModel.php`, `app/Models/UserModel.php` | Table access and **validation rules** |
| `app/Controllers/Customers.php`, `app/Controllers/Users.php` | List, new/create, edit/update (and avatar handling) |
| `app/Views/customers/`, `app/Views/users/` | `index.php` (list) and `form.php` (shared New/Edit form) |
| `public/uploads/avatars/` | Saved avatar thumbnails (not committed to Git) |
| `public/images/avatar-placeholder.svg` | Shown when a user has no avatar |
| `database/pos_system.sql` | Full database export (database, tables, sample data) |
| `database/pos_system_hosting.sql` | Same export without `CREATE DATABASE`/`USE`, for hosts that give you a ready-made database |
| `database/tfa3_add_avatar.sql` | Adds only the `avatar` column to an existing database |
