<div class="card">
    <div class="card-header">
        <h2>Categories</h2>
        <a href="javascript:void(0);" class="btn btn-primary" onclick="openModal()">
            <i class="fas fa-plus"></i> ADD CATEGORY
        </a>
    </div>

    <div class="card-body">
        <table id="sortTable" class="display">
            <thead>
                <tr>
                    <th style="width: 10%;">#</th>
                    <th style="width: 70%;">Name</th>
                    <th class="actions-column" style="width: 15%;">Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($data['categories'])): ?>
                    <?php foreach ($data['categories'] as $index => $category): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= html_escape($category->category_name) ?></td>
                            <td class="actionss-column">


                                <a href="<?= base_url('category/delete/' . $category->category_id) ?>" class="btn btn-danger" title="Delete" 
                                   onclick="return confirm('Are you sure you want to delete this category?')">
                                    <i class="fi fi-rr-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="no-found">No categories found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


<!-- Add Category Modal -->
<div id="modal" class="modal" style="display:none;">
    <div class="modal-content">
        <h2>Add Category</h2>
        <form action="<?= base_url('category/store') ?>" method="POST">
            <div class="form-group">
                <label>Category Name</label>
                <input type="text" name="category_name" class="form-control" required>
            </div>
            <div class="form-group button-group">
                <button type="button" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn btn-success">Save Category</button>
            </div>
        </form>
    </div>
</div>

<?php $this->load->view('components/editModal'); ?>
