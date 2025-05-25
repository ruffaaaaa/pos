<div class="card">
    <div class="card-header">
        <h2>Products</h2>
    </div>

    <div class="card-body">
        <div style="overflow-x: auto; -webkit-overflow-scrolling: touch; width: 100%;">
            <table id="sortTable" class="display">
                <thead>
                    <tr>
                        <th style="width: 2%;">#</th>
                        <th>Barcode</th>
                        <th style="width: 20%;">Name</th>
                        <th>Category</th>
                        <th>Unit</th>
                        <th>Cost Price</th>
                        <th>Retail Price</th>
                        <th>Stock</th>
                        <th class="actions-column" style="width: 10%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['products'])): ?>
                        <?php foreach ($data['products'] as $index => $product): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= html_escape($product->barcode) ?></td>

                                <td><?= html_escape($product->product_name) ?></td>
                                <td><?= html_escape($product->category_name) ?></td> 
                                <td><?= html_escape($product->unit_name) ?> (<?= html_escape($product->abbreviation) ?>)</td>
                                <td><?= html_escape($product->cost_price) ?></td>
                                <td><?= html_escape($product->retail_price) ?></td>
                                <td><?= html_escape($product->current_stock) ?></td>
                                <td class="actionss-column" >
                                    <a href="javascript:void(0);" class="btn btn-warning" title="Edit"
                                        onclick='openEditModal("product", {
                                            id: "<?= $product->product_id ?>",
                                            barcode: "<?= htmlspecialchars($product->barcode, ENT_QUOTES) ?>",
                                            product_name: "<?= htmlspecialchars($product->product_name, ENT_QUOTES) ?>",
                                            category_id: "<?= htmlspecialchars($product->category_id, ENT_QUOTES) ?>",
                                            unit_id: "<?= htmlspecialchars($product->unit_id, ENT_QUOTES) ?>",
                                            cost_price: "<?= htmlspecialchars($product->cost_price, ENT_QUOTES) ?>",
                                            retail_price: "<?= htmlspecialchars($product->retail_price, ENT_QUOTES) ?>",
                                            description: "<?= htmlspecialchars($product->description, ENT_QUOTES) ?>"
                                        })'>
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="<?= base_url('product/delete/' . $product->product_id) ?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this product?')" style="text-decoration:none;">
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

<?php $this->load->view('components/editModal'); ?>
