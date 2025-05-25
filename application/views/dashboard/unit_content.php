<div class="card">
    <div class="card-header">
        <h2>Units</h2>
        <a href="javascript:void(0);" class="btn btn-primary" onclick="openModal()">
            <i class="fas fa-plus"></i> ADD UNIT
        </a>

    </div>

    <div class="card-body">
        <table id="sortTable" class="display">
            <thead>
                <tr>
                    <th style="width: 10%;">#</th>
                    <th style="width: 40%;">Name</th>
                    <th style="width: 15%;">Abbreviation</th>
                    <th class="actions-column" style="width: 10%;">Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($data['units'])): ?>
                    <?php foreach ($data['units'] as $index => $unit): ?>
                         <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= html_escape($unit->unit_name) ?></td>
                            <td><?= html_escape($unit->abbreviation) ?></td>
                            <td class="actionss-column" >
                                <a href="<?= base_url('unit/delete/' . $unit->unit_id) ?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this product?')" style="text-decoration:none;">
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
        <h2>Add Unit</h2>
        <form action="<?= base_url('unit/store') ?>" method="POST">
            <div class="form-group">
                <label>Unit Name</label>
                <input type="text" name="unit_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Abbreviation</label>
                <input type="text" name="abbreviation" class="form-control" required>
            </div>
            <div class="form-group button-group">
                <button type="button" class="" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn btn-success">Save Unit</button>
            </div>
        </form>
    </div>
</div>

<?php $this->load->view('components/editModal'); ?>
