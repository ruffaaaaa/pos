<style>
    .sales-container {
        display: flex;
        flex-direction: row;
        gap: 20px;
        height: auto;
        flex-wrap: wrap;
        padding: 10px;
    }

    .left-panel, .right-panel {
        background-color: #fff;
        padding: 20px;
        border: 2px solid #b30000;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        box-sizing: border-box;
    }

    .left-panel {
        flex: 2;
        overflow-x: auto;
        max-height: 85vh;
    }

    .right-panel {
        flex: 2;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        max-height: 85vh;
    }

    h2 {
        color: #b30000;
        margin-bottom: 15px;
    }

    #product-list {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .product {
        border: 1px solid #b30000;
        border-radius: 10px;
        padding: 15px;
        width: 160px;
        background-color: #fff3f3;
        text-align: center;
    }

    .product button {
        background-color: #b30000;
        color: white;
        padding: 6px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 8px;
    }

    .product button:hover {
        background-color: #990000;
    }

    #cart-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
        margin-bottom: 10px;
    }

    #cart-table th, #cart-table td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: center;
    }

    #cart-table th {
        background-color: #b30000;
        color: white;
        font-size: 12px;
    }

    #cart-table td input[type="number"] {
        padding: 4px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 50px;
        font-size: 14px;
    }

    #cart-table td button {
        background-color: #b30000;
        color: white;
        border: none;
        padding: 3px 8px;
        margin: 0 2px;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
    }

    #cart-table td button:hover {
        background-color: #990000;
    }

    #total_display {
        font-weight: bold;
        color: #b30000;
        font-size: 14px;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    #cash-payment-section {
        font-weight: bold;
        color: #b30000;
        font-size: 14px;
        margin-bottom: 5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    #cash-payment-section input {
        width: 30%;
        padding: 7px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
    }

    #customer-section {
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 5px;
        padding-bottom: 5px;
        padding-top: 5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    #customer-section select {
        width: 34%;
        padding: 7px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 15px;
    }

    #change-info {
        display: flex;
        justify-content: space-between;
        font-weight: bold;
        color: rgb(212, 108, 108);
        font-size: 15px;
        margin-bottom: 5px;
        align-items: center;
    }

    #checkout-form button {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        font-size: 15px;
        background-color: #b30000;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    #checkout-form button:hover {
        background-color: #990000;
    }

    /* Responsive Design */
    @media screen and (max-width: 1024px) {
        .sales-container {
            flex-direction: column;
        }

        .left-panel, .right-panel {
            width: 100%;
            max-height: none;
        }

        #cash-payment-section input,
        #customer-section select {
            width: 100%;
        }

        #product-table th, #product-table td {
            font-size: 11px;
        }

        .product {
            width: 45%;
        }
    }

    @media screen and (max-width: 600px) {
        .product {
            width: 100%;
        }

        #cash-payment-section,
        #customer-section,
        #total_display,
        #change-info {
            flex-direction: column;
            align-items: flex-start;
        }

        #cart-table th, #cart-table td {
            font-size: 11px;
        }

        #cash-payment-section input,
        #customer-section select {
            width: 100%;
        }
    }
</style>


<div class="sales-container">
    <!-- LEFT: Product Panel -->
    <div class="left-panel">
        <h2>Products</h2>
        <!-- DataTable for Products -->
        <table id="product-table" class="display">
            <thead style="font-size: 12px;">
                <tr>
                    <th style="font-size: 12px;">Barcode</th>
                    <th style="font-size: 12px;">Product Name</th>
                    <th style="font-size: 12px;">Category</th>
                    <th style="font-size: 12px;">Price</th>
                    <th style="font-size: 12px;">Stocks</th>

                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['products'] as $product): ?>
                    <tr data-id="<?= $product->product_id ?>" data-name="<?= $product->product_name ?>" data-price="<?= $product->cost_price ?>">
                        <td style="font-size: 13px;"><?= $product->barcode ?></td>

                        <td style="font-size: 13px;"><?= $product->product_name ?></td>
                        <td style="font-size: 13px;"><?= $product->category_name ?></td>

                        <td style="font-size: 13px;">₱<?= number_format($product->cost_price, 2) ?></td>
                        <td style="font-size: 13px;"><?= $product->current_stock?></td>
                        <td style="font-size: 13px;"><button onclick="addToCart(<?= $product->product_id ?>)">Add</button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- RIGHT: Cart Panel -->
    <div class="right-panel" >
        <div style="height: 360px; overflow-y: auto;">
            <table id="cart-table" style="width: 100%; border-collapse: collapse; font-size: 12px;">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                        <th>X</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <!-- Checkout Section with Cash and Change Calculation -->
      <form id="checkout-form">



        <p id="total_display" style="font-size: 13px;"> 
            Sub total <span>₱<span id="total">0.00</span></span>
        </p>
        <div id="cash-payment-section" style="font-size: 13px;">
            <label for="discount">Discount</label>
            <input type="number" id="discount" name="discount" step="0.01" placeholder="Enter discount" value="0">
        </div>
        <div id="total_display" style="border-top: 1px solid #b30000; padding-top: 5px; font-size: 17px; font-weight: bold; color:rgb(122, 8, 8);">
            Total <span>₱<span id="discountTotal">0.00</span></span>

        </div>

        <div id="customer-section" style="font-size: 14px;">
            <label for="customer">Supplier:</label>
            <select name="supplier_id" id="customer">
                <option value="" disabled selected>Select Supplier</option>
                <?php foreach ($data['suppliers'] as $supplier): ?>
                    <option value="<?= $supplier->supplier_id ?>">
                        <?= htmlspecialchars($supplier->supplier_name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <input type="hidden" name="items" id="items-data">
        <input type="hidden" name="total_amount" id="total-data">

        <button type="submit">Print Purchase Order</button>
    </form>


    </div>
</div>


<script>
$(document).ready(function() {
    $('#product-table').DataTable();
});

let cart = [];

function addToCart(productId) {
    const row = document.querySelector(`tr[data-id='${productId}']`);
    const name = row.dataset.name;
    const price = parseFloat(row.dataset.price);

    const existingItem = cart.find(item => item.product_id == productId);
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({ product_id: productId, name, quantity: 1, price });
    }
    renderCart();
}

function increaseQty(index) {
    cart[index].quantity++;
    renderCart();
}

function decreaseQty(index) {
    if (cart[index].quantity > 1) {
        cart[index].quantity--;
    } else {
        cart.splice(index, 1);
    }
    renderCart();
}

function updateQuantity(index, quantity) {
    const qty = parseInt(quantity);
    if (!isNaN(qty) && qty > 0) {
        cart[index].quantity = qty;
        renderCart();
    }
}

function renderCart() {
    const tbody = document.querySelector('#cart-table tbody');
    tbody.innerHTML = '';
    let total = 0;

    cart.forEach((item, index) => {
        const subtotal = item.price * item.quantity;
        total += subtotal;

        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.name}</td>
            <td style="font-size: 12px;">
                <button onclick="decreaseQty(${index})">−</button>
                <input type="number" min="1" value="${item.quantity}" onchange="updateQuantity(${index}, this.value)" style="width: 50px; text-align: center;">
                <button onclick="increaseQty(${index})">+</button>
            </td>
            <td>
                ₱<span id="price-${index}">${item.price.toFixed(2)}</span>
                <button onclick="editPrice(${index})">🖉</button>
            </td>
            <td>₱<span id="subtotal-${index}">${subtotal.toFixed(2)}</span></td>
            <td><button onclick="removeFromCart(${index})">X</button></td>
        `;
        tbody.appendChild(row);
    });

    document.getElementById('total').textContent = total.toFixed(2);

    // Discount and grand total
    const discount = parseFloat(document.getElementById('discount').value || 0);
    const discountedTotal = total - discount;
    document.getElementById('discountTotal').textContent = discountedTotal.toFixed(2);

    // Save data for backend
    document.getElementById('items-data').value = JSON.stringify(cart);
    document.getElementById('total-data').value = total.toFixed(2);
}

function editPrice(index) {
    const newPrice = prompt("Enter new price:", cart[index].price);
    if (newPrice !== null && !isNaN(newPrice) && parseFloat(newPrice) >= 0) {
        cart[index].price = parseFloat(newPrice);
        renderCart();
    }
}

function removeFromCart(index) {
    cart.splice(index, 1);
    renderCart();
}

// Discount input
document.getElementById('discount').addEventListener('input', renderCart);


// Checkout submission
document.getElementById('checkout-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const customerId = document.getElementById('customer').value;

    const total = parseFloat(document.getElementById('discountTotal').textContent);

    fetch('<?= base_url("purchase/process_po") ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams(new FormData(this))
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.po_id) {
            window.location.href = "<?= site_url('purchase/print_po/') ?>" + data.po_id;
        } else {
            alert('An error occurred, please try again.');
        }

        cart = [];
        renderCart();
        document.getElementById('change-info').style.display = 'none';
    })
    .catch(err => {
        alert('Failed to process transaction. Please try again.');
        console.error(err);
    });
});
</script>
