<div class="card">
    <h1><?= esc($heading) ?></h1>
    <p>Fields marked <span class="req">*</span> are required.</p>

    <?php if (! empty($errors)) : ?>
        <div class="alert error">Please fix the highlighted fields and try again.</div>
    <?php endif; ?>

    <form action="<?= esc($action) ?>" method="post" novalidate>
        <?= csrf_field() ?>

        <div class="field">
            <label for="full_name">Full Name <span class="req">*</span></label>
            <input type="text" id="full_name" name="full_name" maxlength="100"
                   value="<?= esc($customer['full_name'] ?? '', 'attr') ?>"
                   class="<?= isset($errors['full_name']) ? 'invalid' : '' ?>">
            <?php if (isset($errors['full_name'])) : ?>
                <div class="error"><?= esc($errors['full_name']) ?></div>
            <?php endif; ?>
        </div>

        <div class="field">
            <label for="email">Email <span class="req">*</span></label>
            <input type="email" id="email" name="email" maxlength="100"
                   value="<?= esc($customer['email'] ?? '', 'attr') ?>"
                   class="<?= isset($errors['email']) ? 'invalid' : '' ?>">
            <?php if (isset($errors['email'])) : ?>
                <div class="error"><?= esc($errors['email']) ?></div>
            <?php endif; ?>
        </div>

        <div class="field">
            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" maxlength="20"
                   value="<?= esc($customer['phone'] ?? '', 'attr') ?>"
                   class="<?= isset($errors['phone']) ? 'invalid' : '' ?>">
            <?php if (isset($errors['phone'])) : ?>
                <div class="error"><?= esc($errors['phone']) ?></div>
            <?php endif; ?>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn"><?= esc($submitLabel) ?></button>
            <a class="btn btn-secondary" href="<?= site_url('customers') ?>">Cancel</a>
        </div>
    </form>
</div>
