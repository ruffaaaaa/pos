<?php
$start_date_query = isset($start_date) ? '&start_date=' . urlencode($start_date) : '';
$end_date_query = isset($end_date) ? '&end_date=' . urlencode($end_date) : '';
?>


<style>
    .top-bar {
        display: flex;
        align-items: center;
        background-color: #ffffff; 
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }
    .top-bar a {
        color: black;
        text-decoration: none;
        font-family: Arial, sans-serif;
        font-weight: bold;
        font-size: 16px;
        padding: 12px;
        border-radius: 4px;
        transition: background-color 0.3s;
    }
    .top-bar a:hover {
        text-decoration: none;
        background-color
    }

    .top-bar a.active {
        background-color: #dc3545;
        color: white;
        text-decoration: none;
    }

    .report-container {
        background-color: #ffffff; 
        padding: 10px 10px;

    }
</style>

<div class="top-bar">
  <a href="?report=sales<?= $start_date_query . $end_date_query ?>" class="<?= ($report == 'sales') ? 'active' : '' ?>">Sales Report</a>
  <a href="?report=inventory<?= $start_date_query . $end_date_query ?>" class="<?= ($report == 'inventory') ? 'active' : '' ?>">Inventory Report</a>
</div>



<div class="report-container">
  <?php
    if ($report == 'sales') {
      $this->load->view('dashboard/report/salesReport');
    } elseif ($report == 'inventory') {
      $this->load->view('dashboard/report/inventoryReport');
    } else {
      echo "<p>Please select a report.</p>";
    }
  ?>
</div>
