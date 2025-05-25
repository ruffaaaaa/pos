<div class="card">
    <div class="card-header">
        <h2>Suppliers</h2>
        <a href="javascript:void(0);" class="btn btn-primary" onclick="openModal()">
            <i class="fas fa-plus"></i> ADD SUPPLIER
        </a>
    </div>

    <div class="card-body">
        <table id="sortTable" class="display">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Supplier Name</th>
                    <th class="contact-person-column">Contact Person</th>
                    <th>Phone</th>
                    <th class="email-column">Email</th>
                    <th class="status-column">Status</th>
                    <th class="actions-column">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['suppliers'])): ?>
                    <?php foreach ($data['suppliers'] as $index => $supplier): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= html_escape($supplier->supplier_name) ?></td>
                            <td class="contact-person-column"><?= html_escape($supplier->contact_person) ?></td>
                            <td><?= html_escape($supplier->phone_number) ?></td>
                            <td class="email-column"><?= html_escape($supplier->email) ?></td>
                            <td class="status-column"><?= ucfirst(html_escape($supplier->status)) ?></td>
                               <td class="actionss-column" >
                                <a href="javascript:void(0);" class="btn btn-warning" title="Edit"
                                    onclick='openEditModal("supplier", {
                                        id: "<?= $supplier->supplier_id ?>",
                                        supplier_name: "<?= htmlspecialchars($supplier->supplier_name, ENT_QUOTES) ?>",
                                        contact_person: "<?= htmlspecialchars($supplier->contact_person, ENT_QUOTES) ?>",
                                        phone_number: "<?= htmlspecialchars($supplier->phone_number, ENT_QUOTES) ?>",
                                        email: "<?= htmlspecialchars($supplier->email, ENT_QUOTES) ?>",
                                        address: "<?= htmlspecialchars($supplier->address, ENT_QUOTES) ?>",
                                        status: "<?= htmlspecialchars($supplier->status, ENT_QUOTES) ?>"
                                    })'>
                                    <i class="fi fi-rr-edit mr-4"></i>
                                </a>

                                <a href="<?= base_url('supplier/delete/' . $supplier->supplier_id) ?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this product?')" style="text-decoration:none;">
                                    <i class="fi fi-rr-trash"></i>
                                </a>
                                
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="no-found">No suppliers found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Supplier Modal -->
<div id="modal" class="modal" style="display:none;">
    <div class="modal-content">
        <h2>Add Supplier</h2>
        <form action="<?= base_url('supplier/store') ?>" method="POST">
            <div class="form-group">
                <label>Supplier Name</label>
                <input type="text" name="supplier_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Contact Person</label>
                <input type="text" name="contact_person" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone_number" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Address</label>
                <textarea name="address" class="form-control" required></textarea>
            </div>
            <div class="form-group button-group">
                <button type="button" class="" onclick="closeModal()">Cancel</button>

                <button type="submit" class="btn btn-success">Save Supplier</button>
            </div>
        </form>
    </div>
</div>

<?php $this->load->view('components/editModal'); ?>
