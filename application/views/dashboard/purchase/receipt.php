<!DOCTYPE html>
<html moznomarginboxes mozdisallowselectionprint>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Purchase Order</title>
    <style type="text/css">
        html {
            font-family: Verdana, Arial, sans-serif;
        }

        .content {
            width: 80mm;
            font-size: 12px;
            padding: 5px;
        }

        .title {
            text-align: center;
            font-size: 13px;
            padding-bottom: 5px;
            border-bottom: 1px dashed #000;
            font-weight: bold;
        }

        .head {
            margin: 5px 0 10px 0;
            border-bottom: 1px solid #000;
        }

        .logo {
            text-align: center;
            margin-bottom: 5px;
        }

        .transaction {
            border-bottom: 1px solid #000;
            margin-bottom: 10px;
        }

        .transaction p {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
            font-size: 12px;
        }

        .transaction p .item-name {
            flex: 2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .transaction p .unit-price,
        .transaction p .subtotal {
            flex: 1;
            text-align: right;
            min-width: 50px;
        }

        .transaction-value p {
            display: flex;
            justify-content: space-between;
            margin: 4px 0;
            font-size: 12px;
        }

        .transaction-value p.total {
            padding-top: 5px;
            font-weight: bold;
        }

        .thanks {
            margin-top: 15px;
            padding-top: 10px;
            text-align: center;
            border-top: 1px dashed #000;
            font-style: italic;
            font-size: 13px;
        }

        @media print {
            @page {
                width: 80mm;
                margin: 0mm;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="content">
        <div class="logo">
            <img src="<?= base_url('assets/img/logo.png') ?>" alt="logo" style="max-width: 50px; display: block; margin: 0 auto;" />
        </div>
        <div class="title">Purchase Order</div>

        <div class="head">
            <p><strong>Purchase Order #:</strong> <?= isset($po->po_id) ? $po->po_id : 'N/A' ?></p>
            <p><strong>Supplier:</strong> <?= isset($po->supplier_name) ? $po->supplier_name : 'N/A' ?></p>
            <p><strong>Processed By:</strong> <?= isset($po->username) ? $po->username : 'N/A' ?></p>
            <p><strong>Date:</strong> <span id="realTimeDate"></span></p>
        </div>

        <div class="transaction">
            <?php if (!empty($po_items)): ?>
                <?php foreach ($po_items as $item): ?>
                    <p>
                        <span class="item-name"><?= $item->product_name ?> x <?= $item->quantity ?></span>
                        <span class="unit-price">₱<?= number_format($item->unit_price, 2) ?></span>
                        <span class="subtotal">₱<?= number_format($item->subtotal, 2) ?></span>
                    </p>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No items found.</p>
            <?php endif; ?>
        </div>

        <div class="transaction-value">
            <p class="total"><strong>Total Amount</strong> <span>₱<?= number_format($po->subtotal ?? 0, 2) ?></span></p>
        </div>

        <div class="thanks">--- Thank you for your business ---</div>
    </div>
</body>

<script>
    function updateDateTime() {
        const now = new Date();
        const formatted = now.toLocaleString();
        document.getElementById('realTimeDate').innerText = formatted;
    }
    setInterval(updateDateTime, 1000);
    updateDateTime();
</script>

</html>
