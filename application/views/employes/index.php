<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Employee Management | Employees List</title>
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
            <span class="logo-mini"><b>EM</b></span>
            <span class="logo-lg"><b>Employee</b>Management</span>
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
            <h1>Employees List</h1>
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
<!-- Search Form -->
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Search Employees</h3>
    </div>
    <div class="box-body">
        <form id="searchForm">
            <div class="row">
                <div class="col-md-2">
                    <input type="text" name="nom" class="form-control" placeholder="Nom">
                </div>
                <div class="col-md-2">
                    <input type="text" name="prenom" class="form-control" placeholder="Prenom">
                </div>
                <div class="col-md-2">
                    <input type="text" name="mail" class="form-control" placeholder="Email">
                </div>
                <div class="col-md-2">
                    <input type="text" name="adresse" class="form-control" placeholder="Adresse">
                </div>
                <div class="col-md-2">
                    <input type="text" name="telephone" class="form-control" placeholder="Telephone">
                </div>
                <div class="col-md-2">
                    <select name="poste" class="form-control">
                        <option value="">Select Poste</option>
                        <option value="1">Gérant</option>
                        <option value="2">Livreur</option>
                        <option value="3">Cuisinier</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>



<div class="box-body">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Email</th>
                <th>Telephone</th>
                <th>Poste</th>
                <?php if($this->session->userdata('user')->role == 1): ?>
                <th>Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody id="employeeTableBody">
            <?php foreach($employees as $employee): ?>
            <tr>
                <td><?= $employee->nom ?></td>
                <td><?= $employee->prenom ?></td>
                <td><?= $employee->mail ?></td>
                <td><?= $employee->telephone ?></td>
                <td><?= $employee->poste ?></td>
                <?php if ($this->session->userdata('user')->role == 1): ?>
                <td>
                    <a href="<?= base_url('index.php/employes/edit/'.$employee->id) ?>" class="btn btn-sm btn-primary">Edit</a>
                    <a href="<?= base_url('index.php/employes/delete/'.$employee->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<script src="<?= base_url('assets/bower_components/jquery/dist/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/dist/js/adminlte.min.js') ?>"></script>

<script>
$(document).ready(function() {
    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?= base_url('index.php/employes/search') ?>',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#employeeTableBody').html(response);
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