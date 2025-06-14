<div class="card">
    <div class="card-header">
        <h2>Logs</h2>


    </div>

    <div class="card-body">
        <table id="sortTable" class="display">
            <thead>
                <tr>
                <th>Date</th>
                <th>User</th>
                <th>Name</th>
                <th>Action</th>
                <th>Description</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($logs)): ?>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <?php
                                $datetime = new DateTime($log->created_at, new DateTimeZone('UTC'));
                                $datetime->setTimezone(new DateTimeZone('Asia/Manila'));
                            ?>
                            <td><?= $datetime->format('Y-m-d, h:i A') ?></td>

                            <td><?= $log->user_name ?></td>
                            <td><?= $log->table_name ?></td>
                            <td><?= $log->action ?></td>
                            <td><?= $log->description ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7">No sales found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>