<div class="card">
    <div class="page-head">
        <div>
            <h1>Customer Accounts</h1>
            <p>Customer records retrieved from the MySQL database.</p>
        </div>
        <a class="btn" href="<?= site_url('customers/new') ?>">+ New Customer</a>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (! empty($customers)) : ?>
                <?php foreach ($customers as $index => $customer) : ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= esc($customer['full_name']) ?></td>
                        <td><?= esc($customer['email']) ?></td>
                        <td><?= esc($customer['phone']) ?></td>
                        <td class="actions"><a href="<?= site_url('customers/edit/' . (int) $customer['id']) ?>">Edit</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5">No customer records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
