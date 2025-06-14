<form method="get" style="margin-bottom: 10px; margin-top: 10px;">
    <input type="hidden" name="report" value="<?= htmlspecialchars($report) ?>">
    <label>From: <input type="date" name="start_date" value="<?= isset($start_date) ? $start_date : '' ?>"></label>
    <label>To: <input type="date" name="end_date" value="<?= isset($end_date) ? $end_date : '' ?>"></label>
    <button type="submit">Filter</button>
</form>
<table id="sortTable" class="display">
<thead>
    <tr>
        <th>Sale ID</th>
        <th>Customer</th>
        <th>Payment Type</th>

        <th>Subtotal</th>
        <th>Total Amount</th>
        <th>Date</th>
        <th>Action</th>
    </tr>
</thead>

<tbody>
    <?php if (!empty($sales)): ?>
        <?php foreach ($sales as $sale): ?>
            <tr>
                <td><?= $sale->sale_id ?></td>
                <td><?= $sale->customer_name ?? '-' ?></td>
                <td><?= $sale->payment_type ?></td>
                <td>₱<?= number_format($sale->total_amount, 2) ?></td>
                <td>₱<?= number_format($sale->final_amount, 2) ?></td>
                <td><?= date('Y-m-d H:i', strtotime($sale->created_at)) ?></td>
                <td>
                    <a href="<?= base_url('sales/receipt/' . $sale->sale_id) ?>"  class="reprint">🖨 Receipt</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="7">No sales found.</td></tr>
    <?php endif; ?>
</tbody>
</table>