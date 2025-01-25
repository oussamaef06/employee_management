<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>User Management | Edit User</title>
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
            <h1>Edit User</h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">User Information</h3>
                        </div>
                        
                        <!-- Form Start -->
                        <form id="editUserForm" role="form">
                            <div class="box-body">
                                <!-- Error Message Container -->
                                <div id="errorContainer" class="alert alert-danger" style="display:none;"></div>

                                <div class="form-group">
                                    <label for="nom">Nom</label>
                                    <input type="text" class="form-control" id="nom" name="nom" 
                                           placeholder="Enter Last Name" 
                                           value="<?= htmlspecialchars($utilisateur->nom) ?>">
                                </div>

                                <div class="form-group">
                                    <label for="prenom">Prenom</label>
                                    <input type="text" class="form-control" id="prenom" name="prenom" 
                                           placeholder="Enter First Name" 
                                           value="<?= htmlspecialchars($utilisateur->prenom) ?>">
                                </div>

                                <div class="form-group">
                                    <label for="login">Login (Cannot be changed)</label>
                                    <input type="text" class="form-control" 
                                           value="<?= htmlspecialchars($utilisateur->login) ?>" 
                                           disabled>
                                </div>

                                <div class="form-group">
                                    <label for="mot_de_passe">New Password (Optional)</label>
                                    <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" 
                                           placeholder="Leave blank if no change">
                                </div>

                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <select class="form-control" id="role" name="role">
                                        <option value="1" <?= $utilisateur->role == 1 ? 'selected' : '' ?>>Admin</option>
                                        <option value="2" <?= $utilisateur->role == 2 ? 'selected' : '' ?>>User</option>
                                    </select>
                                </div>
                            </div>

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Update User</button>
                                <a href="<?= base_url('index.php/utilisateurs/'.$utilisateur->id) ?>" class="btn btn-default">Cancel</a>
                            </div>
                        </form>
                    </div>
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
    $('#editUserForm').on('submit', function(e) {
        e.preventDefault();
        
        $('#errorContainer').hide().html('');
        
        $.ajax({
            url: '<?= base_url('index.php/utilisateurs/edit/'.$utilisateur->id) ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    window.location.href = response.redirect;
                } else {
                    $('#errorContainer').html(response.message).show();
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                $('#errorContainer').html('An unexpected error occurred. Please try again.').show();
            }
        });
    });
});
</script>
</body>
</html>