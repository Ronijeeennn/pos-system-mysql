<div class="card">
    <h1><?= esc($heading) ?></h1>
    <p>Fields marked <span class="req">*</span> are required.</p>

    <?php if (! empty($errors)) : ?>
        <div class="alert error">Please fix the highlighted fields and try again.</div>
    <?php endif; ?>

    <form action="<?= esc($action) ?>" method="post" enctype="multipart/form-data" novalidate>
        <?= csrf_field() ?>

        <div class="field">
            <label for="username">Username <span class="req">*</span></label>
            <input type="text" id="username" name="username" maxlength="50"
                   value="<?= esc($user['username'] ?? '', 'attr') ?>"
                   class="<?= isset($errors['username']) ? 'invalid' : '' ?>">
            <?php if (isset($errors['username'])) : ?>
                <div class="error"><?= esc($errors['username']) ?></div>
            <?php endif; ?>
        </div>

        <div class="field">
            <label for="full_name">Full Name <span class="req">*</span></label>
            <input type="text" id="full_name" name="full_name" maxlength="100"
                   value="<?= esc($user['full_name'] ?? '', 'attr') ?>"
                   class="<?= isset($errors['full_name']) ? 'invalid' : '' ?>">
            <?php if (isset($errors['full_name'])) : ?>
                <div class="error"><?= esc($errors['full_name']) ?></div>
            <?php endif; ?>
        </div>

        <div class="field">
            <?php if ($showAvatar) : ?>
                <label for="password">New Password</label>
            <?php else : ?>
                <label for="password">Password <span class="req">*</span></label>
            <?php endif; ?>
            <input type="password" id="password" name="password" maxlength="72" autocomplete="new-password"
                   class="<?= isset($errors['password']) ? 'invalid' : '' ?>">
            <div class="hint">
                8 to 72 characters.
                <?php if ($showAvatar) : ?>Leave empty to keep the current password.<?php endif; ?>
            </div>
            <?php if (isset($errors['password'])) : ?>
                <div class="error"><?= esc($errors['password']) ?></div>
            <?php endif; ?>
        </div>

        <?php if ($showAvatar) : ?>
            <div class="field">
                <label for="avatar">Profile Picture</label>
                <div class="avatar-row">
                    <img class="avatar avatar-lg" src="<?= esc($avatarUrl) ?>"
                         alt="Current profile picture" width="96" height="96">
                    <div>
                        <input type="file" id="avatar" name="avatar" accept="image/png,image/jpeg">
                        <div class="hint">
                            JPG or PNG, up to 2 MB. It is saved as a 200 &times; 200 square.
                            Leave empty to keep the current picture.
                        </div>
                        <?php if (isset($errors['avatar'])) : ?>
                            <div class="error"><?= esc($errors['avatar']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="form-actions">
            <button type="submit" class="btn"><?= esc($submitLabel) ?></button>
            <a class="btn btn-secondary" href="<?= site_url('users') ?>">Cancel</a>
        </div>
    </form>
</div>
