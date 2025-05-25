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
            <th>Product</th>
            <th>Desrciption</th>
            <th>Category</th>
            <th>Unit</th>
            <th>Total Stock In</th>
            <th>Total Stock Out</th>
            <th>Current Stock</th>
            <th>Last Updated</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($inventory)): ?>
            <?php foreach ($inventory as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item->product_name) ?></td>
                    <td><?= htmlspecialchars($item->description) ?></td>
                    <td><?= htmlspecialchars($item->category_name) ?></td>
                    <td><?= htmlspecialchars($item->unit_name) ?></td>
                    <td><?= $item->total_stock_in ?></td>
                    <td><?= $item->total_stock_out ?></td>
                    <td><?= $item->current_stock ?></td>
                    <td><?= date('Y-m-d', strtotime($item->last_updated)) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="7">No inventory data found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
