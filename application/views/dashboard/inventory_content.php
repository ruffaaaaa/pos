<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2>Inventory</h2>
        <div class="button-group d-flex gap-2">
            <a href="javascript:void(0);" class="btn btn-primary" onclick="openModal()">
                <i class="fas fa-plus"></i> ADD PRODUCT
            </a>
            <a href="javascript:void(0);" class="btn btn-primary" onclick="openImportProductModal()">
                <i class="fas fa-file-import"></i> IMPORT EXCEL
            </a>
        </div>
    </div>


    <div class="card-body">
        <div style="overflow-x: auto; -webkit-overflow-scrolling: touch; width: 100%;">
            <table id="sortTable" class="display">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 20%;">Product</th>
                        <th style="width: 10%;">Cost Price</th>
                        <th style="width: 10%;">Retail Price</th>
                        <th style="width: 10%;">Stock In</th>
                        <th style="width: 10%;">Stock Out</th>

                        <th style="width: 10%;">Current Stock</th>
                        <th class="actions-column" style="width: 10%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['inventory'])): ?>
                        <?php foreach ($data['inventory'] as $index => $inventory): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= html_escape($inventory->product_name) ?></td>
                                <td><?= html_escape($inventory->cost_price) ?></td> 
                                <td><?= html_escape($inventory->retail_price) ?></td>
                                <td><?= html_escape($inventory->stock_in) ?></td> 
                                <td><?= html_escape($inventory->stock_out)?></td>
                                <td><?= html_escape($inventory->current_stock)?></td>
                                <td class="actionss-column">
                                    <a href="javascript:void(0);" class="btn btn-warning" title="Edit"
                                        onclick='openEditModal("inventory", {
                                            id: "<?= $inventory->inventory_id ?>",
                                            barcode: "<?= htmlspecialchars($inventory->barcode, ENT_QUOTES) ?>",
                                            product_name: "<?= htmlspecialchars($inventory->product_name, ENT_QUOTES) ?>",
                                            stock_in: "<?= htmlspecialchars($inventory->stock_in, ENT_QUOTES) ?>",
                                            stock_out: "<?= htmlspecialchars($inventory->stock_out, ENT_QUOTES) ?>",
                                            current_stock: "<?= htmlspecialchars($inventory->current_stock, ENT_QUOTES) ?>"
                                        })'

                                    >
                                        <i class="fi fi-rr-edit"></i>
                                    </a>

                                    <a href="<?= base_url('inventory/delete/' . $inventory->inventory_id) ?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this product?')" style="text-decoration:none;">
                                        <i class="fi fi-rr-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="no-found">No products found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="importModal" class="modal" style="display:none;">
    <div class="modal-overlay" onclick="closeImportProductModal()"></div>
    <div class="modal-content">
        <h2>Import Excel File</h2>

        <a href="<?= base_url('uploads/template.xlsx') ?>" download class="btn btn-primary" style="margin-bottom: 10px;">Download Template</a>

        <form id="excelUploadForm" enctype="multipart/form-data" method="post" action="<?= base_url('inventory/upload_excel') ?>" class="d-flex align-items-center">
            <input type="file" name="excelFile" id="excelFile" accept=".xls,.xlsx" class="form-control mr-2" />

            <div class="form-group button-group" style="margin-top: 10px;">
                <button type="button" class="" onclick="closeImportProductModal()">Cancel</button>

                <button type="submit" class="btn btn-success">Import</button>
            </div>
        </form>

    </div>
</div>

<!-- Product Modal -->
<div id="modal" class="modal" style="display:none;">
    <div class="modal-overlay" onclick="closeModal()"></div>
    <div class="modal-content">
        <h2>Add Product</h2>
        <form action="<?= base_url('inventory/add_product') ?>" method="post">
            
            <div class="form-group">
                <label for="barcode">Barcode</label>
                <input type="text" name="barcode" id="barcode" required><br>
            </div>

            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" name="product_name" id="product_name" required><br>
            </div>
            
            <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" required>
                    <?php foreach ($data['categories'] as $category): ?>
                        <option value="<?= $category->category_id ?>"><?= $category->category_name ?></option>
                    <?php endforeach; ?>
                </select><br>
            </div>
            
            <div class="form-group">
                <label for="unit_id">Unit</label>
                <select name="unit_id" id="unit_id" required>
                    <?php foreach ($data['units'] as $unit): ?>
                        <option value="<?= $unit->unit_id ?>"><?= $unit->unit_name ?> (<?= $unit->abbreviation ?>)</option>
                    <?php endforeach; ?>
                </select><br>
            </div>
            
            <div class="form-group">
                <label for="price">Cost Price</label>
                <input type="number" name="cost_price" id="cost_price" step="0.01" required><br>
            </div>


            <div class="form-group">
                <label for="price">Retail Price</label>
                <input type="number" name="retail_price" id="retail_price" step="0.01" required><br>
            </div>

            <div class="form-group">
                <label for="stock">Stock In</label>
                <input type="number" name="stock_in" id="stock_in" required><br>
            </div>
            

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description"></textarea><br>
            </div>


            <div class="form-group button-group">
                <button type="button" class="" onclick="closeModal()">Cancel</button>

                <button type="submit" class="btn btn-success">Save Supplier</button>
            </div>
            
        </form>
    </div>
</div>

<?php $this->load->view('components/editModal'); ?>
