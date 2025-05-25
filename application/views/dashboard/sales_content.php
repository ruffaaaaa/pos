<style>


    .sales-container {
        display: flex;
        gap: 20px;
        height: 89vh;
    }

    .left-panel, .right-panel {
        background-color: #fff;
        padding: 20px;
        border: 2px solid #b30000;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .left-panel {
        flex: 2;
        overflow-y: auto;
        max-height: 85vh;
    }

    .right-panel {
        flex: 1.4;
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
        color:rgb(212, 108, 108);
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
                    <tr data-id="<?= $product->product_id ?>" data-name="<?= $product->product_name ?>" data-price="<?= $product->retail_price ?>">
                        <td style="font-size: 13px;"><?= $product->barcode ?></td>

                        <td style="font-size: 13px;"><?= $product->product_name ?></td>
                        <td style="font-size: 13px;"><?= $product->category_name ?></td>

                        <td style="font-size: 13px;">₱<?= number_format($product->retail_price, 2) ?></td>
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
            <label for="customer">Customer:</label>
            <select name="customer_id" id="customer">
                <option value="" disabled selected>Select Customer</option>
                <?php foreach ($data['customers'] as $customer): ?>
                    <option value="<?= $customer->customer_id ?>">
                        <?= htmlspecialchars($customer->customer_name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div id="cash-payment-section" style="font-size: 14px;">
            <label for="cash-amount">Enter Cash Amount:</label>
            <input type="number" id="cash-amount" name="cash_amount" step="0.01" placeholder="Enter cash amount">
        </div>



        <p id="change-info" style="font-size: 14px;">
            Change <span>₱<span id="change-amount">0.00</span></span>
        </p>

        <input type="hidden" name="cart" id="cart-data">
        <input type="hidden" name="total" id="total-data">

        <button type="submit">Process Payment</button>
    </form>


    </div>
</div>

<script>
let cart = [];

function addToCart(productId) {
    let product = document.querySelector(`tr[data-id='${productId}']`);
    let name = product.dataset.name;
    let price = parseFloat(product.dataset.price);
    let existing = cart.find(p => p.product_id == productId);

    if (existing) {
        existing.quantity++;
    } else {
        cart.push({ product_id: productId, name, price, quantity: 1 });
    }

    renderCart();
}

function removeFromCart(index) {
    cart.splice(index, 1);
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

function updateQty(index, value) {
    let qty = parseInt(value);
    if (!isNaN(qty) && qty > 0) {
        cart[index].quantity = qty;
    } else {
        cart[index].quantity = 1;
    }
    renderCart();
}

function renderCart() {
    let tbody = document.querySelector('#cart-table tbody');
    tbody.innerHTML = '';
    let total = 0;

    cart.forEach((item, i) => {
        let subtotal = item.price * item.quantity;
        total += subtotal;

        tbody.innerHTML += `
            <tr >
                <td style="font-size: 12px;">${item.name}</td>
                <td style="font-size: 12px;">
                    <button onclick="decreaseQty(${i})">−</button>
                    <input type="number" min="1" value="${item.quantity}" onchange="updateQty(${i}, this.value)" style="width: 50px; text-align: center;">
                    <button onclick="increaseQty(${i})">+</button>
                </td>
                <td style="font-size: 12px;">₱${item.price.toFixed(2)}</td>
                <td style="font-size: 12px;">₱${subtotal.toFixed(2)}</td>
                <td style="font-size: 12px;"><button onclick="removeFromCart(${i})">X</button></td>
            </tr>
        `;

    });

    document.getElementById('total').textContent = total.toFixed(2);
    document.getElementById('cart-data').value = JSON.stringify(cart);
    document.getElementById('total-data').value = total.toFixed(2);
    updateChange();
}



function updateChange() {
    let total = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
    let discount = parseFloat(document.getElementById('discount').value) || 0;

    // Clamp discount to not exceed total
    if (discount > total) discount = total;

    let discountedTotal = total - discount;
    document.getElementById('discountTotal').textContent = discountedTotal.toFixed(2);
    document.getElementById('total-data').value = discountedTotal.toFixed(2); // Update hidden total input

    let cashAmount = parseFloat(document.getElementById('cash-amount').value) || 0;
    let change = cashAmount - discountedTotal;
    document.getElementById('change-amount').textContent = change >= 0 ? change.toFixed(2) : '0.00';
}

document.getElementById('cash-amount').addEventListener('input', updateChange);
document.getElementById('discount').addEventListener('input', updateChange);

$(document).ready(function() {
    $('#product-table').DataTable();
});

document.getElementById('checkout-form').addEventListener('submit', function(e) {
    e.preventDefault();

    let cashAmount = parseFloat(document.getElementById('cash-amount').value);
    let discountedTotal = parseFloat(document.getElementById('discountTotal').textContent);

    if (isNaN(cashAmount) || cashAmount <= 0) {
        alert('Please enter a valid cash amount.');
        return;
    }

    if (cashAmount < discountedTotal) {
        alert('Cash amount must be greater than or equal to the total.');
        return;
    }

    fetch("<?= site_url('sales/process') ?>", {
        method: 'POST',
        body: new FormData(this)
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.sale_id) {
            window.location.href = "<?= site_url('sales/receipt/') ?>" + data.sale_id;
        } else {
            alert('An error occurred, please try again.');
        }

        cart = [];
        renderCart();
        document.getElementById('cash-amount').value = '';
        document.getElementById('change-info').style.display = 'none';
    });
});

</script>
