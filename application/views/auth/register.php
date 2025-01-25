<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Employee Management | Register</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?= base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/bower_components/font-awesome/css/font-awesome.min.css') ?>">
    
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?= base_url('assets/bower_components/Ionicons/css/ionicons.min.css') ?>">
    
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/AdminLTE.min.css') ?>">
    
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/iCheck/square/blue.css') ?>">
</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo">
        <a href="#"><b>Employee</b>Management</a>
    </div>

    <div class="register-box-body">
        <p class="login-box-msg">Register a new user</p>

        <form id="register-form">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Nom (Last Name)" id="nom" name="nom" required>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Prénom (First Name)" id="prenom" name="prenom" required>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Login" id="login" name="login" required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Confirm Password" id="confirm_password" name="confirm_password" required>
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            </div>
            <div class="form-group">
                <select class="form-control" id="role" name="role" required>
                    <option value="">Select Role</option>
                    <option value="1">Admin</option>
                    <option value="2">User</option>
                </select>
            </div>
            <div class="row">
                <div class="col-xs-8">
                </div>
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
                </div>
            </div>
        </form>

        <div id="register-error" class="text-center text-danger" style="display:none;margin-top:10px;"></div>
        <div id="register-success" class="text-center text-success" style="display:none;margin-top:10px;"></div>

        <a href="<?= base_url('/') ?>" class="text-center">I already have a user</a>
    </div>
</div>

<!-- jQuery 3 -->
<script src="<?= base_url('assets/bower_components/jquery/dist/jquery.min.js') ?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
<!-- iCheck -->
<script src="<?= base_url('assets/plugins/iCheck/icheck.min.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/dist/js/adminlte.min.js') ?>"></script>

<script>
$('#register-form').on('submit', function(e) {
    e.preventDefault();
    
    $('#register-error').hide();
    $('#register-success').hide();

    var password = $('#password').val();
    var confirmPassword = $('#confirm_password').val();
    
    if (password !== confirmPassword) {
        $('#register-error').text('Passwords do not match').show();
        return;
    }

    console.log('Form Data:', $(this).serialize());

    $.ajax({
        url: '<?= base_url("index.php/auth/register_process") ?>',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            // console.log('Full server response:', response);
            
            if (response.status === 'success') {
                $('#register-success').text(response.message).show();
                setTimeout(function() {
                    window.location.href = '<?= base_url('/') ?>';
                }, 2000);
            } else {
                $('#register-error').text(response.message).show();
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            console.log('Full error response:', xhr.responseText);
            $('#register-error').text('An error occurred. Please try again.').show();
        }
    });
});
</script>
</body>
</html>