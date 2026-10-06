<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'POS System') ?> | Basic POS System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
            background: #f4f6f8;
            color: #222;
        }
        nav {
            background: #1f2d3d;
            padding: 0.9rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        nav .brand {
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
            text-decoration: none;
        }
        nav .links a {
            color: #cfd8e3;
            text-decoration: none;
            margin-left: 1.25rem;
            font-size: 0.95rem;
        }
        nav .links a:hover {
            color: #fff;
        }
        main {
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }
        h1 {
            margin-top: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }
        th, td {
            text-align: left;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e5e9ee;
        }
        th {
            background: #eef1f5;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        tr:last-child td {
            border-bottom: none;
        }
        .card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }
        footer {
            text-align: center;
            color: #8a97a5;
            font-size: 0.85rem;
            padding: 2rem 0 1rem;
        }
    </style>
</head>
<body>
    <nav>
        <a class="brand" href="<?= site_url('/') ?>">Basic POS System</a>
        <div class="links">
            <a href="<?= site_url('/') ?>">Home</a>
            <a href="<?= site_url('about') ?>">About</a>
            <a href="<?= site_url('customers') ?>">Customer Accounts</a>
            <a href="<?= site_url('users') ?>">User Accounts</a>
        </div>
    </nav>
    <main>
