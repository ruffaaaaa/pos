<div id="editModal" class="modal" style="display:none;">
    <div class="modal-content">
        <h2>Edit</h2>

        <form id="editCategoryForm" method="POST" action="<?= base_url('category/update') ?>" style="display:none;">
            <input type="hidden" name="category_id" id="editCategoryId">
            <div class="form-group">
                <label>Category Name</label>
                <input type="text" name="category_name" id="editCategoryName" class="form-control" required>
            </div>
            <div class="form-group button-group">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="btn btn-success">Save Changes</button>
            </div>
        </form>

        <!-- Edit Customer Form -->
        <form id="editCustomerForm" method="POST" action="<?= base_url('customer/update') ?>" style="display:none;">
            <input type="hidden" name="customer_id" id="editCustomerId">
            <div class="form-group">
                <label>Customer Name</label>
                <input type="text" name="customer_name" id="editCustomerName" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone_number" id="editCustomerPhone" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="editCustomerEmail" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Address</label>
                <textarea name="address" id="editCustomerAddress" class="form-control"></textarea>
            </div>
            <div class="form-group button-group">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="btn btn-success">Save Changes</button>
            </div>
        </form>

        <form id="editProductForm" method="POST" action="<?= base_url('product/edit') ?>" style="display:none;">
            <input type="hidden" name="product_id" id="editProductId">
            
            <div class="form-group">
                <label>Barcode</label>
                <input type="text" name="barcode" id="editBarcode" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="product_name" id="editProductName" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Category</label>
                <select name="category_id" id="editCategoryId" class="form-control" placeholder="Select" required>
                    <?php foreach ($data['categories'] as $category): ?>
                        <option value="<?= $category->category_id ?>"><?= $category->category_name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Unit</label>
                <select name="unit_id" id="editUnitId" class="form-control" placeholder="Select" required>
                    <?php foreach ($data['units'] as $unit): ?>
                        <option value="<?= $unit->unit_id ?>"><?= $unit->unit_name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Cost Price</label>
                <input type="number" name="cost_price" id="editCostPrice" class="form-control" step="0.01" required>
            </div>
            <div class="form-group">
                <label>Retail Price</label>
                <input type="number" name="retail_price" id="editRetailPrice" class="form-control" step="0.01" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" id="editDescription" class="form-control"></textarea>
            </div>
           
            <div class="form-group button-group">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="btn btn-success">Save Changes</button>
            </div>
        </form>

        <form id="editSupplierForm" method="POST" action="<?= base_url('supplier/edit') ?>" style="display:none;">
            <input type="hidden" name="supplier_id" id="editSupplierId">
            
           <div class="form-group">
                <label>Customer Name</label>
                <input type="text" name="supplier_name" id="editSupplierName" class="form-control" required>
            </div>
                        <div class="form-group">
                <label>Contact Person</label>
                <input type="text" name="contact_person" id="editSupplierContactPerson" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone_number" id="editSupplierPhone" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="editSupplierEmail" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Address</label>
                <textarea name="address" id="editSupplierAddress" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" id="editSupplierStatus" class="form-control" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <div class="form-group button-group">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="btn btn-success">Save Changes</button>
            </div>

            
        </form>

        <form id="editInventoryForm" style="display:none;" method="post" action="<?= base_url('inventory/edit') ?>">

            <input type="hidden" name="inventory_id" id="editInventoryId">

            <div class="form-group">
                <label for="editInventoryProductName">Product Name</label>
                <input type="text" name="product_name" id="editInventoryProductName" required disabled>
            </div>


            <div class="form-group">
                <label for="editStockIn">Stock In</label>
                <input type="number" name="stock_in" id="editStockIn" required>
            </div>

            <div class="form-group">
                <label for="editStockOut">Stock Out</label>
                <input type="number" name="stock_out" id="editStockOut" required >
            </div>

            <div class="form-group">
                <label for="editCurrentStock">Current Stock</label>
                <input type="number" name="current_stock" id="editCurrentStock" required disabled>
            </div>

            <div class="form-group button-group">
                <button type="button" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="btn btn-success">Update Product</button>
            </div>
        </form>

        <form id="editUserForm" style="display:none;" method="post" action="<?= base_url('user/edit') ?>">

            <input type="hidden" name="user_id" id="editUserId">

            <div class="form-group">
                <label for="editName">Name</label>
                <input type="text" name="name" id="editName" >
            </div>

            <div class="form-group">
                <label for="editUsername">Username</label>
                <input type="text" name="username" id="editUsername" >  
                    </div>
                                <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <label for="editRole">Role</label>
                <select name="role" id="editRole" class="form-control" >
                    <option value="admin">Admin</option>
                    <option value="cashier">Cashier</option>
                </select>
            </div>

            
            <div class="form-group">
                <label for="editIsActive">Status</label>
                <select name="isActive" id="editIsActive" class="form-control" required>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
                        
            </div>

            <div class="form-group button-group">
                <button type="button" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="btn btn-success">Update User</button>
            </div>

        </form>

    </div>
</div>
