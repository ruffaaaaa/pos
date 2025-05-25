<form method="get" style="margin-bottom: 10px; margin-top: 10px;">
    <input type="hidden" name="report" value="<?= htmlspecialchars($report) ?>">
    <label>From: <input type="date" name="start_date" value="<?= isset($start_date) ? $start_date : '' ?>"></label>
    <label>To: <input type="date" name="end_date" value="<?= isset($end_date) ? $end_date : '' ?>"></label>
    <button type="submit">Filter</button>
    <button type="submit" name="export" value="csv">Export CSV</button>
</form>



<table id="sortTable" cellpadding="5" style="margin-bottom: 10px;">
    <thead>
        <tr>
            <th>Date</th>
            <th>Sale ID</th>
            <th>Product</th>
            <th>Sold to</th>
            <th>Qty</th>
            <th>Cost Price</th>
            <th>Unit Price</th>
            <th>Total Cost</th>
            <th>Total Revenue</th>
            <th>Profit</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($sales)): ?>
            <?php foreach ($sales as $row): ?>
                <tr>
                    <td><?= date('Y-m-d', strtotime($row->created_at)) ?></td>
                    <td><?= $row->sale_id ?></td>
                    <td><?= $row->product_name ?></td>
                    <td><?= $row->customer_name ?></td>
                    <td><?= $row->quantity ?></td>
                    <td><?= number_format($row->cost_price, 2) ?></td>
                    <td><?= number_format($row->unit_price, 2) ?></td>
                    <td><?= number_format($row->total_cost, 2) ?></td>
                    <td><?= number_format($row->total_revenue, 2) ?></td>
                    <td><strong><?= number_format($row->profit, 2) ?></strong></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="10">No sales found for the selected dates.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
