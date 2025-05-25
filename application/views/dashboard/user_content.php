<div class="card">
    <div class="card-header">
        <h2>Units</h2>
        <a href="javascript:void(0);" class="btn btn-primary" onclick="openModal()">
            <i class="fas fa-plus"></i> ADD USER
        </a>

    </div>

    <div class="card-body">
        <table id="sortTable" class="display">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 30%;">Name</th>
                    <th style="width: 15%;">Username</th>
                    <th style="width: 10%;">Status</th>
                    <th class="actions-column" style="width: 10%;">Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($data['users'])): ?>
                    <?php foreach ($data['users'] as $index => $user): ?>
                         <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= html_escape($user->name) ?></td>
                            <td><?= html_escape($user->username) ?></td>
                            <td>
                                <?= html_escape($user->isActive) == 1 ? 'Active' : 'Inactive' ?>
                            </td>
                               <td class="actionss-column" >
                                <a href="javascript:void(0);" class="btn btn-warning" title="Edit" 
                                onclick="openEditModal('user', {
                                    id: '<?= $user->user_id ?>',
                                    name: '<?= html_escape($user->name) ?>',
                                    username: '<?= html_escape($user->username) ?>',
                                    role: '<?= html_escape($user->role) ?>',
                                    isActive: '<?= html_escape($user->isActive) ?>'
                                })">
                                    <i class="fi fi-rr-edit"></i>
                                </a>
                                <a href="<?= base_url('user/delete/' . $user->user_id) ?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this product?')" style="text-decoration:none;">
                                    <i class="fi fi-rr-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="no-found">No categories found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="modal" class="modal" style="display:none;">
    <div class="modal-content">
        <h2>Add User</h2>
        <form action="<?= base_url('user/store') ?>" method="POST">
            <div class="form-group">
                <label> Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Role</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="cashier">Cashier</option>
                </select>
            </div>

            <div class="form-group button-group">
                <button type="button" class="" onclick="closeModal()">Cancel</button>

                <button type="submit" class="btn btn-success">Save User</button>
            </div>
        </form>
    </div>
</div>

<?php $this->load->view('components/editModal'); ?>
