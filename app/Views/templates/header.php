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

        /* ---- forms, buttons, alerts, avatars (TFA3) ---- */
        .page-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 0.5rem;
        }
        .btn {
            display: inline-block;
            background: #2563eb;
            color: #fff;
            border: 0;
            border-radius: 6px;
            padding: 0.55rem 1rem;
            font-size: 0.95rem;
            text-decoration: none;
            cursor: pointer;
            white-space: nowrap;
        }
        .btn:hover { background: #1d4ed8; }
        .btn-secondary { background: #e5e9ee; color: #222; }
        .btn-secondary:hover { background: #d5dbe3; }
        .alert {
            padding: 0.75rem 1rem;
            border-radius: 6px;
            margin: 1rem 0;
        }
        .alert.success { background: #e7f6ec; color: #17603a; border: 1px solid #b7e1c6; }
        .alert.error   { background: #fdecec; color: #8a1f1f; border: 1px solid #f3bcbc; }
        .field { margin-bottom: 1.1rem; }
        .field label { display: block; font-weight: 600; margin-bottom: 0.35rem; }
        .field input[type="text"],
        .field input[type="email"] {
            width: 100%;
            padding: 0.6rem 0.75rem;
            border: 1px solid #c4ccd6;
            border-radius: 6px;
            font-size: 1rem;
        }
        .field input.invalid { border-color: #c0392b; background: #fff7f6; }
        .field .error { color: #b02a1f; font-size: 0.88rem; margin-top: 0.3rem; }
        .field .hint  { color: #6b7785; font-size: 0.85rem; margin-top: 0.3rem; }
        .req { color: #c0392b; }
        .form-actions { display: flex; gap: 0.6rem; margin-top: 1.5rem; }
        td.actions a { color: #2563eb; text-decoration: none; font-weight: 600; }
        td.actions a:hover { text-decoration: underline; }
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            background: #dfe5ec;
            vertical-align: middle;
        }
        .avatar-lg { width: 96px; height: 96px; }
        .avatar-row { display: flex; align-items: center; gap: 1rem; }

        /* ---- login / logout (TFA4) ---- */
        nav .links { display: flex; align-items: center; }
        .logout-form { display: inline; margin: 0 0 0 1rem; }
        .logout-form button {
            background: none;
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 6px;
            color: #fff;
            padding: 0.3rem 0.7rem;
            font: inherit;
            cursor: pointer;
        }
        .logout-form button:hover { background: rgba(255, 255, 255, 0.15); }
        .login-card { max-width: 420px; margin: 2rem auto; }
        .alert.info { background: #e8f0fe; color: #1a3d8f; border: 1px solid #b9cdf5; }
        .field input[type="password"] {
            width: 100%;
            padding: 0.6rem 0.75rem;
            border: 1px solid #c4ccd6;
            border-radius: 6px;
            font-size: 1rem;
        }
        .field input[type="password"].invalid { border-color: #c0392b; background: #fff7f6; }
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
            <?php if (session()->get('logged_in') === true) : ?>
                <form class="logout-form" action="<?= site_url('logout') ?>" method="post">
                    <?= csrf_field() ?>
                    <button type="submit">Log out (<?= esc(session()->get('username')) ?>)</button>
                </form>
            <?php else : ?>
                <a href="<?= site_url('login') ?>">Log in</a>
            <?php endif; ?>
        </div>
    </nav>
    <main>
