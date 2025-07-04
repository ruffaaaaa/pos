<div class="sidebar">
    <div>
        <div class="logo">
            <img src="<?= base_url('assets/img/logo.png') ?>" alt="logo">
            <br>
            <span style="font-size:12px;">
                <?= strtoupper($this->session->userdata('location') ?? 'UNKNOWN') ?>
            </span>
        </div>
        <div class="nav">
            <span style="padding:10px; font-size:12px">MAIN NAVIGATION</span>

            <?php if ($this->session->userdata('role') === 'cashier'): ?>
                <a href="<?= base_url('sales') ?>" class="<?= ($this->uri->segment(1) == 'sales') ? 'active' : '' ?>" style="background: #dc3545; color: #fff;">
                    <i class="fi fi-rr-receipt"></i><span>Sales</span>
                </a>
            <?php else: ?>
                <a href="<?= base_url('dashboard') ?>" class="<?= ($this->uri->segment(1) == 'dashboard') ? 'active ' . $this->session->userdata('location') : '' ?>">
                    <i class="fi fi-rr-home"></i><span>Dashboard</span>
                </a>

                <a href="<?= base_url('products') ?>" class="<?= ($this->uri->segment(1) == 'products') ? 'active ' . $this->session->userdata('location') : '' ?>">
                    <i class="fi fi-rr-box"></i><span>Products</span>
                </a>
                <a href="<?= base_url('sales') ?>" class="<?= ($this->uri->segment(1) == 'sales') ? 'active ' . $this->session->userdata('location') : '' ?>">
                    <i class="fi fi-rr-receipt"></i><span>Sales</span>
                </a>
                <a href="<?= base_url('purchase') ?>" class="<?= ($this->uri->segment(1) == 'purchase') ? 'active ' . $this->session->userdata('location') : '' ?>">
                    <i class="fi fi-rr-receipt"></i><span>Purchase Order</span>
                </a>
                <a href="<?= base_url('inventory') ?>" class="<?= ($this->uri->segment(1) == 'inventory') ? 'active ' . $this->session->userdata('location') : '' ?>">
                    <i class="fi fi-rr-boxes"></i><span>Inventory</span>
                </a>
                <a href="<?= base_url('report') ?>" class="<?= ($this->uri->segment(1) == 'report') ? 'active ' . $this->session->userdata('location') : '' ?>">
                    <i class="fi fi-rr-newspaper"></i><span>Reports</span>
                </a>
                                <a href="<?= base_url('suppliers') ?>" class="<?= ($this->uri->segment(1) == 'suppliers') ? 'active ' . $this->session->userdata('location') : '' ?>">
                    <i class="fi fi-rr-truck-side"></i><span>Suppliers</span>
                </a>
                <a href="<?= base_url('customers') ?>" class="<?= ($this->uri->segment(1) == 'customers') ? 'active ' . $this->session->userdata('location') : '' ?>">
                    <i class="fi fi-rr-user"></i><span>Customers</span>
                </a>

                <span style="padding:10px; font-size:12px">SETTINGS</span>
                <a href="<?= base_url('categories') ?>" class="<?= ($this->uri->segment(1) == 'categories') ? 'active ' . $this->session->userdata('location') : '' ?>">
                    <i class="fi fi-rr-tags"></i><span>Categories</span>
                </a>
                <a href="<?= base_url('units') ?>" class="<?= ($this->uri->segment(1) == 'units') ? 'active ' . $this->session->userdata('location') : '' ?>">
                    <i class="fi fi-rr-box"></i><span>Units</span>
                </a>
                <a href="<?= base_url('users') ?>" class="<?= ($this->uri->segment(1) == 'users') ? 'active ' . $this->session->userdata('location') : '' ?>">
                    <i class="fi fi-rr-users-alt"></i><span>Users</span>
                </a>
                <a href="<?= base_url('logs') ?>" class="<?= ($this->uri->segment(1) == 'logs') ? 'active ' . $this->session->userdata('location') : '' ?>">
                    <i class="fi fi-rr-newspaper"></i><span>Logs</span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
