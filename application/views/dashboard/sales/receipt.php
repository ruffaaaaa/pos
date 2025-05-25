<!DOCTYPE html>
<html moznomarginboxes mozdisallowselectionprint>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Receipt</title>
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

        /* Flex layout for items */
        .transaction p {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
            font-size: 12px;
        }

        /* Product name & qty - left aligned, takes most space */
        .transaction p .item-name {
            flex: 2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Unit price and subtotal - right aligned */
        .transaction p .unit-price,
        .transaction p .subtotal {
            flex: 1;
            text-align: right;
            min-width: 50px;
        }

        /* Summary values layout */
        .transaction-value p {
            display: flex;
            justify-content: space-between;
            margin: 4px 0;
            font-size: 12px;
        }

        .transaction-value p strong {
            font-weight: 600;
        }

        .transaction-value p.total {
            border-top: 1px solid #000;
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
        <div class="title">Receipt</div>

        <div class="head">
            <p><strong>Receipt #:</strong> <?= isset($sale->sale_id) ? $sale->sale_id : 'N/A' ?></p>
            <p><strong>Customer Name:</strong> <?= isset($sale->customer_name) ? $sale->customer_name : 'N/A' ?></p>
            <p><strong>Date:</strong> <?= isset($sale->created_at) ? $sale->created_at : 'N/A' ?></p>
        </div>

        <div class="transaction">
            <?php if (!empty($sale_items)): ?>
                <?php foreach ($sale_items as $item): ?>
                    <p>
                        <span class="item-name"><?= isset($item->product_name) ? $item->product_name : 'Unknown' ?> x <?= $item->quantity ?></span>
                        <span class="unit-price">₱<?= number_format($item->unit_price, 2) ?></span>
                        <span class="subtotal">₱<?= number_format($item->subtotal, 2) ?></span>
                    </p>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No items found.</p>
            <?php endif; ?>
        </div>

        <div class="transaction-value">
            <p><strong>Sub total</strong> <span>₱<?= isset($sale->total_amount) ? number_format($sale->total_amount, 2) : '0.00' ?></span></p>
            <p>Discount <span>₱<?= isset($sale->discount) ? number_format($sale->discount, 2) : '0.00' ?></span></p>
            <p class="total"><strong>Total</strong> <span>₱<?= isset($sale->final_amount) ? number_format($sale->final_amount, 2) : '0.00' ?></span></p>

            <p><strong>Cash Paid</strong> <span>₱<?= isset($sale->payment_amount) ? number_format($sale->payment_amount, 2) : '0.00' ?></span></p>
            <p><strong>Change</strong> 
                <span>
                    ₱<?= (isset($sale->payment_amount) && isset($sale->final_amount)) ? number_format($sale->payment_amount - $sale->final_amount, 2) : '0.00' ?>
                </span>
            </p>
        </div>

        <div class="thanks">--- Thank You ---</div>
    </div>
</body>

</html>
