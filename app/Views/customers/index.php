<div class="card">
    <h1>Customer Accounts</h1>
    <p>Customer records retrieved from the MySQL database.</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
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
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="4">No customer records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
