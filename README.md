# Basic POS System (CodeIgniter 4 + MySQL)

A basic Point-of-Sale system built with **CodeIgniter 4.7**. The **Customer Accounts** and
**User Accounts** pages read their records from a **MySQL** database through CodeIgniter Models.

- **Live demo:** _paste your hosted URL here_
- **Repository:** https://github.com/Ronijeeennn/pos-system-mysql

## Requirements

- PHP 8.2 or newer (with the `intl`, `mbstring` and `mysqlnd` extensions enabled)
- MySQL 5.7+ / MariaDB 10.4+ (XAMPP, Laragon, or similar)
- [Composer](https://getcomposer.org/) (only needed if the `vendor/` folder is missing)

## Setup

1. **Install dependencies** (skip if `vendor/` already exists):
   ```
   composer install
   ```
2. **Create the database and tables.** Import the export in phpMyAdmin (Import tab), or from a terminal:
   ```
   mysql -u root -p < database/pos_system.sql
   ```
   This creates the `pos_system` database, the `customers` and `users` tables, and 6 sample rows in each.
3. **Configure the environment.** Copy `.env.example` to `.env` and adjust the `database.default.*`
   values if your MySQL username or password is different.
4. **Run the app:**
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
  created_at DATETIME NOT NULL
);
```

## Project structure (the parts that matter for this activity)

| Path | Purpose |
|---|---|
| `.env` | Database connection settings (not committed; see `.env.example`) |
| `app/Models/CustomerModel.php` | Model for the `customers` table |
| `app/Models/UserModel.php` | Model for the `users` table |
| `app/Controllers/Customers.php` | Loads customers through `CustomerModel` |
| `app/Controllers/Users.php` | Loads users through `UserModel` |
| `app/Views/customers/index.php`, `app/Views/users/index.php` | Tables that display the records |
| `database/pos_system.sql` | Full database export (creates the database, tables, and sample data) |
| `database/pos_system_hosting.sql` | Same export without `CREATE DATABASE`/`USE`, for hosts that give you a ready-made database |

## Routes

| URL | Page |
|---|---|
| `/` | Home |
| `/about` | About |
| `/customers` | Customer Accounts (from the database) |
| `/users` | User Accounts (from the database) |
