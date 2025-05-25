<div class="card">
    <div class="card-header">
        <h2>Customers</h2>
        <a href="javascript:void(0);" class="btn btn-primary" onclick="openModal()">
            <i class="fas fa-plus"></i> ADD CUSTOMER
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="sortTable" class="display">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th class="email-column">Email</th>
                        <th class="actions-column">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['customers'])): ?>
                        <?php foreach ($data['customers'] as $index => $customer): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= html_escape($customer->customer_name) ?></td>
                                <td><?= html_escape($customer->phone_number) ?></td>
                                <td class="email-column"><?= html_escape($customer->email) ?></td>
                                <td class="actionss-column">
                                   <a href="javascript:void(0);" class="btn btn-warning" title="Edit"
                                        onclick="openEditModal('customer', {
                                            id: '<?= $customer->customer_id ?>',
                                            name: '<?= htmlspecialchars($customer->customer_name, ENT_QUOTES) ?>',
                                            phone: '<?= htmlspecialchars($customer->phone_number, ENT_QUOTES) ?>',
                                            email: '<?= htmlspecialchars($customer->email, ENT_QUOTES) ?>',
                                            address: '<?= htmlspecialchars($customer->address, ENT_QUOTES) ?>'
                                        })">
                                        <i class="fi fi-rr-edit"></i>
                                    </a>

                                    <a href="<?= base_url('customer/delete/' . $customer->customer_id) ?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this product?')" style="text-decoration:none;">
                                        <i class="fi fi-rr-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="no-found">No customers found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Customer Modal -->
<div id="modal" class="modal" style="display:none;">
    <div class="modal-content">
        <h2>Add Customer</h2>
        <form action="<?= base_url('customer/store') ?>" method="POST">
            <div class="form-group">
                <label>Customer Name</label>
                <input type="text" name="customer_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone_number" class="form-control">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label>Address</label>
                <textarea name="address" class="form-control"></textarea>
            </div>
            <div class="form-group button-group">
                <button type="button" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn btn-success">Save Customer</button>
            </div>
        </form>
    </div>
</div>

<?php $this->load->view('components/editModal'); ?>
