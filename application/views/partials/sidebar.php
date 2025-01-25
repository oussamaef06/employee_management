<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="<?= ($this->uri->segment(1) == 'employes' && $this->uri->segment(2) == 'index') ? 'active' : '' ?>">
                <a href="<?= base_url('index.php/employes/index') ?>">
                    <i class="fa fa-users"></i> 
                    <span>Employees</span>
                </a>
            </li>
            <?php if($this->session->userdata('user')->role == 1): ?>
            <li>
                <a href="<?= base_url('index.php/employes/add') ?>">
                    <i class="fa fa-user-plus"></i> 
                    <span>Add Employee</span>
                </a>
            </li>
            <?php endif; ?>


            <?php if($this->session->userdata('user')->role == 1): ?>
                <li class="<?= ($this->uri->segment(1) == 'utilisateurs' && $this->uri->segment(2) == 'index') ? 'active' : '' ?>">
                <a href="<?= base_url('index.php/utilisateurs/index') ?>">
                    <i class="fa fa-users"></i> 
                    <span>Users</span>
                </a>
            </li>
                <li>
                    <a href="<?= base_url('index.php/utilisateurs/add') ?>">
                        <i class="fa fa-user-plus"></i> 
                        <span>Add User</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </section>
</aside>