<section class="content">
  <div class="container">

    <div class="card-grid">
      <div class="card-dashboard items">
        <div class="icon"><i class="fas fa-th"></i></div>
        <div>
          <div class="text">Products</div>
          <div class="number"><?= count($item) ?></div>
        </div>
      </div>

      <div class="card-dashboard suppliers">
        <div class="icon"><i class="fas fa-truck"></i></div>
        <div>
          <div class="text">Suppliers</div>
          <div class="number"><?= count($supplier) ?></div>
        </div>
      </div>

      <div class="card-dashboard customers">
        <div class="icon"><i class="fas fa-users"></i></div>
        <div>
          <div class="text">Customers</div>
          <div class="number"><?= count($customer) ?></div>
        </div>
      </div>
    </div>

    <div class="card-table">
      <div class="card-header">
        <h3>Products In Demand</h3>
      </div>
      <div class="card-body">
        <table>
          <thead>
            <tr>
              <th>Product</th>
              <th>Price</th>
              <th>Sales</th>
              <th>Detail</th>
            </tr>
          </thead>
         <tbody>
            <?php if(@$product): foreach ($product as $p): ?>
              <?php
                $percent_change = 0;
                if (!empty($p->prev_qty)) {
                  $percent_change = (($p->qty - $p->prev_qty) / $p->prev_qty) * 100;
                } elseif ($p->qty > 0) {
                  $percent_change = 100;
                }
                $percent_text = number_format($percent_change, 1) . '%';
                $percent_icon = $percent_change >= 0 ? 'fa-arrow-up' : 'fa-arrow-down';
                $percent_class = $percent_change >= 0 ? 'up' : 'down';
              ?>
              <tr>
                <td><?= $p->product_name ?></td>
                <td><?= php_currency($p->retail_price) ?></td>
                <td>
                  <span class="<?= $percent_class ?>">
                    <i class="fas <?= $percent_icon ?>"></i> <?= $percent_text ?>
                  </span>
                  <?= $p->qty ?> Item Sold
                </td>
                <td class="center"><a href="#"><i class="fas fa-search"></i></a></td>
              </tr>
            <?php endforeach; endif; ?>
          </tbody>

        </table>
      </div>
    </div>

  </div>
</section>
