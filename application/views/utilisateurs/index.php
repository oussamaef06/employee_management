<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>User Management | Users List</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?= base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/bower_components/font-awesome/css/font-awesome.min.css') ?>">
    
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/AdminLTE.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/skins/_all-skins.min.css') ?>">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <!-- Main Header -->
    <header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo">
            <span class="logo-mini"><b>UM</b></span>
            <span class="logo-lg"><b>User</b>Management</span>
        </a>
        
        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button -->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="<?= base_url('index.php/auth/logout') ?>"><i class="fa fa-sign-out"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    
    <!-- Left side column -->
    <?php $this->load->view('partials/sidebar'); ?>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <h1>Users List</h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
            <?php endif; ?>
            
            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
            <?php endif; ?>

            <!-- Search Form -->
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Search Users</h3>
                </div>
                <div class="box-body">
                    <form id="searchForm">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" name="nom" class="form-control" placeholder="Nom">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="prenom" class="form-control" placeholder="Prenom">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="login" class="form-control" placeholder="Login">
                            </div>
                            <div class="col-md-3">
                                <select name="role" class="form-control">
                                    <option value="">Select Role</option>
                                    <option value="1">Admin</option>
                                    <option value="2">User</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Users Table -->
            <div class="box">
                <div class="box-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prenom</th>
                                <th>Login</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="userTableBody">
                            <?php foreach($utilisateurs as $utilisateur): ?>
                            <tr>
                                <td><?= $utilisateur->nom ?></td>
                                <td><?= $utilisateur->prenom ?></td>
                                <td><?= $utilisateur->login ?></td>
                                <td><?= $utilisateur->role == 1 ? 'Admin' : 'User' ?></td>
                                <td>
                                    <a href="<?= base_url('index.php/utilisateurs/edit/'.$utilisateur->id) ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="<?= base_url('index.php/utilisateurs/delete/'.$utilisateur->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- jQuery 3 -->
<script src="<?= base_url('assets/bower_components/jquery/dist/jquery.min.js') ?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/dist/js/adminlte.min.js') ?>"></script>

<script>
$(document).ready(function() {
    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?= base_url('index.php/utilisateurs/search') ?>',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#userTableBody').html(response);
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                console.log('Response Text:', xhr.responseText);
            }
        });
    });
});
</script>
</body>
</html>