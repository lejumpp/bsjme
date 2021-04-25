<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->


    <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/font-awesome/css/font-awesome.min.css') ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/Ionicons/css/ionicons.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.min.css') ?>">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/iCheck/square/blue.css') ?>">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>

<body class="hold-transition login-page">

    <div class="login-box">
        <div class="login-logo">

        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">

            <div class="row">
                <div class="col-md-1 col-xs-1">

                </div>
                <div class="col-md-10 col-xs-10">
                    <img width="250" height="90" src="<?php echo base_url('assets/images/logo.jpg'); ?>" />
                </div>
            </div>
            <br>

            <p class="login-box-msg">Password Reset Request</p>

            <?php echo validation_errors(); ?>

            <?php if (!empty($errors)) {
                echo $errors;
            } ?>
            <?php if (!empty($success)) {
                echo $success;
            } ?>
            <form action="<?php echo base_url('auth/password_reset') ?>" method="post">

                <div class="form-group has-feedback">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email address">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <h4><a href="<?php echo base_url('auth/login') ?>"><u>Go Back</u></a></h4>
                    </div> <!-- /.col -->
                    <div class="col-xs-8">
                        <button type="submit" class="btn btn-success btn-block btn-flat">Send Password Reset Email</button>
                    </div> <!-- /.col -->
                </div>


                <!-- Hyperlink to bring you to Registration Page -->
                <!-- <div class="row" align="center">
          <h4>Don't have an account <a href="<?php echo base_url('registration/register') ?>"><u>Click Here!</u></a></h4>
        </div> -->


        </div> <!-- /.login-box-body -->
    </div><!-- /.login-box -->




</body>

<!-- jQuery 3 -->
<script src="<?php echo base_url('assets/bower_components/jquery/dist/jquery.min.js') ?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
<!-- iCheck -->
<script src="<?php echo base_url('assets/plugins/iCheck/icheck.min.js') ?>"></script>


</html>