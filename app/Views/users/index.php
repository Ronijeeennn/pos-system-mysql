<div class="card">
    <h1>User Accounts</h1>
    <p>Staff/user records retrieved from the MySQL database.</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Full Name</th>
            </tr>
        </thead>
        <tbody>
            <?php if (! empty($users)) : ?>
                <?php foreach ($users as $index => $user) : ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= esc($user['username']) ?></td>
                        <td><?= esc($user['full_name']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="3">No user records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
