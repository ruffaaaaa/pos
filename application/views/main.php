<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>KD ENTREPRISE | POS System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
    <link rel="stylesheet" href="<?= base_url('assets/css/sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/pos.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/supplier.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/js/navbar.js') ?>"></script>
    <script src="<?= base_url('assets/js/modal.js') ?>"></script>
    

<script>
    function applySidebarState() {
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');
        const isMobile = window.innerWidth <= 768;
        const sidebarState = localStorage.getItem('sidebarState'); // 'collapsed' or 'open'

        if (isMobile) {
            // For mobile, just open/close sidebar, no collapse styling
            if (sidebarState === 'open') {
                sidebar.classList.add('open');
            } else {
                sidebar.classList.remove('open');
            }
        } else {
            // For desktop: add/remove collapsed class based on saved state
            if (sidebarState === 'collapsed') {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('collapsed');
            } else {
                sidebar.classList.remove('collapsed');
                mainContent.classList.remove('collapsed');
            }
        }
    }

    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');
        const isMobile = window.innerWidth <= 768;

        if (isMobile) {
            sidebar.classList.toggle('open');
            // Save state
            if (sidebar.classList.contains('open')) {
                localStorage.setItem('sidebarState', 'open');
            } else {
                localStorage.setItem('sidebarState', 'closed');
            }
        } else {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed');
            // Save state
            if (sidebar.classList.contains('collapsed')) {
                localStorage.setItem('sidebarState', 'collapsed');
            } else {
                localStorage.setItem('sidebarState', 'expanded');
            }
        }
    }

    window.addEventListener('DOMContentLoaded', () => {
        applySidebarState();
        document.querySelector('.sidebar').classList.add('js-loaded');
    });

    window.addEventListener('resize', () => {
        applySidebarState();
    });
</script>

</head>
<body>
    <?php $this->load->view('components/toast'); ?>

    <?php $this->load->view('layouts/sidebar'); ?>
    
    <div class="main-content">
        <?php $this->load->view('layouts/topbar'); ?>
        
        <div class="w-full " style="padding:15px">
            <?php $this->load->view(isset($content_view) ? $content_view : 'dashboard/home_content'); ?>
        </div>
    </div>
</body>
</html>
