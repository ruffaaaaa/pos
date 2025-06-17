<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Select Location</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/login.css') ?>">
    <style>
        .btn-group {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-group button {
            flex: 1;
            padding: 20px;
            color: #000000;
            border: none;
            font-weight: bold;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }

        .btn-group button:hover {
        background-color: #c82333;
            color: #fff;

        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="login-container">
        <h4>Select your Location</h4>

    <form method="post" action="<?= base_url('auth/set_location') ?>">
        <div class="btn-group">
            <button type="submit" name="location" value="store">
                <img src="<?= base_url('assets/img/store.png') ?>" alt="Store" style="width:100px; display:block; margin:0 auto 5px;">
                Store
            </button>
            <button type="submit" name="location" value="warehouse">
                <img src="<?= base_url('assets/img/warehouse.png') ?>" alt="Warehouse" style="width:100px; display:block; margin:0 auto 5px;">
                Warehouse
            </button>
        </div>
    </form>


        <?php if($this->session->flashdata('error')): ?>
            <div class="alert"><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
