<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Employee Management | Edit Employee</title>
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
            <h1>Edit Employee</h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
            <?php endif; ?>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Employee Details</h3>
                </div>
                
                <form id="editEmployeeForm" method="post" action="<?= base_url('index.php/employes/edit/'.$employee->id) ?>">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nom">Nom (Last Name)</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="<?= $employee->nom ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prenom (First Name)</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="<?= $employee->prenom ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="mail">Email</label>
                            <input type="email" class="form-control" id="mail" name="mail" value="<?= $employee->mail ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="adresse">Adresse (Address)</label>
                            <input type="text" class="form-control" id="adresse" name="adresse" value="<?= $employee->adresse ?>">
                        </div>
                        <div class="form-group">
                            <label for="telephone">Telephone</label>
                            <input type="text" class="form-control" id="telephone" name="telephone" value="<?= $employee->telephone ?>">
                        </div>
                        <div class="form-group">
                            <label for="poste">Poste (Position)</label>
                            <select class="form-control" id="poste" name="poste" required>
                                <option value="1" <?= $employee->poste == 1 ? 'selected' : '' ?>>Gérant</option>
                                <option value="2" <?= $employee->poste == 2 ? 'selected' : '' ?>>Livreur</option>
                                <option value="3" <?= $employee->poste == 3 ? 'selected' : '' ?>>Cuisinier</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Update Employee</button>
                        <a href="<?= base_url('index.php/employes/edit/'.$employee->id) ?>" class="btn btn-default">Cancel</a>
                    </div>
                </form>
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
    $('#editEmployeeForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    window.location.href = '<?= base_url('index.php/employes/edit/'.$employee->id) ?>';
                } else {
                    alert(response.message || 'Failed to update employee');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                alert('An error occurred while updating the employee');
            }
        });
    });
});
</script>
</body>
</html>