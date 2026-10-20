<div class="card login-card">
    <h1>Log In</h1>
    <p>Log in to manage customer and user accounts.</p>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert info"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <?php if ($loggedOut) : ?>
        <div class="alert success">You have been logged out.</div>
    <?php endif; ?>

    <?php if (isset($errors['login'])) : ?>
        <div class="alert error"><?= esc($errors['login']) ?></div>
    <?php endif; ?>

    <form action="<?= site_url('login') ?>" method="post" novalidate>
        <?= csrf_field() ?>

        <div class="field">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" maxlength="50" autocomplete="username"
                   value="<?= esc($username, 'attr') ?>"
                   class="<?= isset($errors['username']) ? 'invalid' : '' ?>">
            <?php if (isset($errors['username'])) : ?>
                <div class="error"><?= esc($errors['username']) ?></div>
            <?php endif; ?>
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" autocomplete="current-password"
                   class="<?= isset($errors['password']) ? 'invalid' : '' ?>">
            <?php if (isset($errors['password'])) : ?>
                <div class="error"><?= esc($errors['password']) ?></div>
            <?php endif; ?>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">Log In</button>
        </div>
    </form>
</div>
