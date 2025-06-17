<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - POS System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/css/login.css') ?>">
</head>
<body>
<div class="wrapper">
    <div class="logo">
        <img src="<?= base_url('assets/img/logo.png') ?>" alt="logo">
    </div>

    <div class="login-container">
    <h4>Sign in to start your session</h4>

    <form method="post" action="<?php echo base_url('auth/login_process'); ?>">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" class="btn">Login</button>
    </form>
    <?php if($this->session->flashdata('error')): ?>
        <div class="alert"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>
</div>
</div>
</body>
</html>
