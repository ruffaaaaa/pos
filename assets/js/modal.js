
function openImportProductModal() {
    document.getElementById('importModal').style.display = 'flex'; // Show the modal
}

function closeImportProductModal() {
    document.getElementById('importModal').style.display = 'none'; // Hide the modal
}
function openEditModal(type, data = {}) {
    // Show the modal container
    document.getElementById("editModal").style.display = "flex";

    // Hide all forms initially
    document.getElementById("editCategoryForm").style.display = "none";
    document.getElementById("editCustomerForm").style.display = "none";
    document.getElementById("editSupplierForm").style.display = "none";
    document.getElementById("editProductForm").style.display = "none";
    document.getElementById("editInventoryForm").style.display = "none";
    document.getElementById("editUserForm").style.display = "none";


    if (type === 'customer') {
        document.getElementById("editCustomerForm").style.display = "block";

        document.getElementById("editCustomerId").value = data.id || '';
        document.getElementById("editCustomerName").value = data.name || '';
        document.getElementById("editCustomerPhone").value = data.phone || '';
        document.getElementById("editCustomerEmail").value = data.email || '';
        document.getElementById("editCustomerAddress").value = data.address || '';
    } else if (type === 'supplier') {
        document.getElementById("editSupplierForm").style.display = "block";
        document.getElementById('editSupplierId').value = data.id;
        document.getElementById('editSupplierName').value = data.supplier_name;
        document.getElementById('editSupplierContactPerson').value = data.contact_person;
        document.getElementById('editSupplierPhone').value = data.phone_number;
        document.getElementById('editSupplierEmail').value = data.email;
        document.getElementById('editSupplierAddress').value = data.address;
        document.getElementById('editSupplierStatus').value = data.status;
    }
    else if (type === 'product') {
        document.getElementById("editProductForm").style.display = "block";
        document.getElementById('editProductId').value = data.id || '';
        document.getElementById('editBarcode').value = data.barcode || '';
        document.getElementById('editProductName').value = data.product_name || '';
        document.getElementById('editCategoryId').value = data.category_id || '';
        document.getElementById('editUnitId').value = data.unit_id || '';
        document.getElementById('editCostPrice').value = data.cost_price || '';
        document.getElementById('editRetailPrice').value = data.retail_price || '';
        document.getElementById('editDescription').value = data.description || '';
    }

    else if (type === 'inventory') {
        document.getElementById("editInventoryForm").style.display = "block";
        document.getElementById('editInventoryId').value = data.id || '';
        document.getElementById('editInventoryProductName').value = data.product_name || '';
        document.getElementById('editStockIn').value = data.stock_in || 0;
        document.getElementById('editStockOut').value = data.stock_out || 0;
        document.getElementById('editCurrentStock').value = data.current_stock || 0;
    }


    else if (type === 'user') {
        document.getElementById("editUserForm").style.display = "block";
        document.getElementById('editUserId').value = data.id || '';
        document.getElementById('editName').value = data.name || '';
        document.getElementById('editUsername').value = data.username || '';
        document.getElementById('editRole').value = data.role || '';
        document.getElementById('editIsActive').checked = data.isActive || false;
    }

}

function closeEditModal() {
    document.getElementById("editModal").style.display = "none";
}

