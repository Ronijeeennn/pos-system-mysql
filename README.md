# Basic POS System (CodeIgniter 4 + MySQL)

A basic Point-of-Sale system built with **CodeIgniter 4.7**. Customer and user accounts are stored in
**MySQL** and managed through CodeIgniter Models. Only a **logged-in user** can open or change them.

- **Live demo:** _paste your hosted URL here_
- **Repository:** _paste your repository URL here_
- **Demo login (sample data only):** username `admin01`, password `Welcome123!`
  (all six sample users start with this password; change it from the Edit User form after deploying)

## Features

- **Authentication:** login page, session-based login state, logout button, and an `auth` filter that
  protects every Customer Accounts and User Accounts route (lists, New and Edit forms, and the handlers
  that receive the form data). Logged-out visitors are sent to the login page and, after logging in,
  returned to the page they asked for.
- **Passwords** are stored only as `password_hash()` hashes and checked with `password_verify()`.
  New users must be given a password (8 to 72 characters); on the Edit form a new password is optional.
- Customer Accounts: list, **New Customer** form, **Edit** form (full name and a valid email are required)
- User Accounts: list, **New User** form, **Edit** form (username is required and unique, full name is required)
- Avatar upload on the user edit form: JPG or PNG, up to 2 MB, saved as a 200 x 200 square thumbnail
  in `public/uploads/avatars/`; only the file name is stored in the database
- Server-side validation with error messages next to each field, plus CSRF protection on every form

## Requirements

- PHP 8.2 or newer with the `intl`, `mbstring`, `mysqlnd` and **`gd`** extensions enabled
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
   The `users` table already includes the `avatar` and `password` columns, and every sample user
   already has a hashed password.

   **Upgrading a database from the previous lab?** Do not re-import (that would erase your data).
   Select your database and run `database/tfa4_add_password.sql`. It adds the `password` column and gives
   every existing user a hashed starting password. The same result can be produced from code with
   `php spark db:seed UserPasswordSeeder`.
3. **Configure the environment.** Copy `.env.example` to `.env` and adjust the `database.default.*`
   values if your MySQL username or password is different.
4. **Make sure `public/uploads/avatars/` and `writable/` are writable** (they are by default locally).
5. **Run the app:**
   ```
   php spark serve
   ```
   Then open <http://localhost:8080> and log in.

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
  password VARCHAR(255) NOT NULL,  -- a password_hash() value, never plain text
  full_name VARCHAR(100) NOT NULL,
  avatar VARCHAR(255) NULL,        -- file name only, e.g. user_3_a1b2c3d4e5f6.jpg
  created_at DATETIME NOT NULL
);
```

## Routes

Routes marked **login** are behind the `auth` filter.

| URL | Method | Access | Page / action |
|---|---|---|---|
| `/` | GET | public | Home |
| `/about` | GET | public | About |
| `/login` | GET | public | Login form |
| `/login` | POST | public | Checks the password and starts the session |
| `/logout` | POST | public | Destroys the session, back to the login page |
| `/customers` | GET | login | Customer Accounts list |
| `/customers/new` | GET | login | New Customer form |
| `/customers/create` | POST | login | Validates and inserts a customer |
| `/customers/edit/{id}` | GET | login | Edit Customer form (pre-filled) |
| `/customers/update/{id}` | POST | login | Validates and updates a customer |
| `/users` | GET | login | User Accounts list (with avatars) |
| `/users/new` | GET | login | New User form |
| `/users/create` | POST | login | Validates and inserts a user (hashes the password) |
| `/users/edit/{id}` | GET | login | Edit User form (pre-filled, avatar upload, optional new password) |
| `/users/update/{id}` | POST | login | Validates, prepares the avatar thumbnail, and updates a user |

## Project structure (the parts that matter for these activities)

| Path | Purpose |
|---|---|
| `.env` | Database connection settings (not committed; see `.env.example`) |
| `app/Filters/AuthFilter.php` | The `auth` filter: lets only logged-in users through |
| `app/Config/Filters.php` | Registers the `auth` alias and turns on CSRF protection |
| `app/Config/Routes.php` | All routes; the protected ones sit inside one `filter => auth` group |
| `app/Controllers/Auth.php` | Login (`password_verify()`), session start, logout |
| `app/Models/UserModel.php` | Table access, validation rules, and `password_hash()` before save |
| `app/Controllers/Customers.php`, `app/Controllers/Users.php` | List, new/create, edit/update (and avatar handling) |
| `app/Views/auth/login.php` | The login form |
| `app/Views/customers/`, `app/Views/users/` | `index.php` (list) and `form.php` (shared New/Edit form) |
| `app/Database/Seeds/UserPasswordSeeder.php` | Gives users without a password a hashed starting password |
| `public/uploads/avatars/` | Saved avatar thumbnails (not committed to Git) |
| `database/pos_system.sql` | Full database export (database, tables, sample data, hashed passwords) |
| `database/pos_system_hosting.sql` | Same export without `CREATE DATABASE`/`USE`, for hosts that give you a ready-made database |
| `database/tfa4_add_password.sql` | Migration: adds `password` and hashes for existing users |
| `database/tfa3_add_avatar.sql` | Migration from the previous lab: adds the `avatar` column |
