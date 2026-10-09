<div class="card">
    <div class="page-head">
        <div>
            <h1>User Accounts</h1>
            <p>Staff/user records retrieved from the MySQL database.</p>
        </div>
        <a class="btn" href="<?= site_url('users/new') ?>">+ New User</a>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Avatar</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (! empty($users)) : ?>
                <?php foreach ($users as $index => $user) : ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td>
                            <img class="avatar" src="<?= esc($user['avatar_url']) ?>"
                                 alt="Avatar of <?= esc($user['full_name'], 'attr') ?>" width="40" height="40">
                        </td>
                        <td><?= esc($user['username']) ?></td>
                        <td><?= esc($user['full_name']) ?></td>
                        <td class="actions"><a href="<?= site_url('users/edit/' . (int) $user['id']) ?>">Edit</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5">No user records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
