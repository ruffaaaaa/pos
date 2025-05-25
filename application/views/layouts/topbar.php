<!-- Mobile navbar -->
<div class="mobile-toggle">
    <div>
        <img src="<?= base_url('assets/img/logo.png') ?>" width="30" alt="logo">
        <span><strong>POS</strong></span>
    </div>
    <button onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
</div>

<!-- Desktop topbar -->
<div class="topbar">
    <div class="topbar-left">
        <button onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
        <h4>POINT OF SALE SYSTEM</h4>
    </div>
    <div class="topbar-right" onclick="toggleDropdown()">
        <i class="fi fi-rr-user"></i>
        <div id="profileDropdown" class="dropdown hidden">
            <a href="<?= base_url('auth/logout') ?>">LOGOUT</a>
        </div>
    </div>
</div>

