<?php
defined('BASEPATH') or exit('No direct script access allowed');
function login_header()
{

  ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= SYSTEM_MODULE ?></title>

    <!-- Google Font: Source Sans Pro -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/theme/adminlte/AdminLTE/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet"
      href="<?= base_url() ?>assets/theme/adminlte/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/theme/adminlte/AdminLTE/dist/css/adminlte.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/theme/adminlte/AdminLTE/plugins/toastr/toastr.min.css">
    <link rel="icon" href="<?= base_url() ?>assets/images/Logo/pharmacy-logo2.png">

  </head>

  <body class="hold-transition login-page">
    <?php
}

function login_footer()
{

  ?>
    <script type="text/javascript">
      var base_url = '<?= base_url() ?>';
    </script>
    <!-- jQuery -->
    <script src="<?= base_url() ?>assets/theme/libs/jquery/jquery/dist/jquery.js"></script>
    <script src="<?= base_url() ?>assets/js/login/login.js"></script>
    <script src="<?= base_url() ?>assets/js/noPostBack.js"></script>
    <!-- ajax -->
    <script src="<?= base_url() ?>assets/theme/libs/jquery/jquery-pjax/jquery.pjax.js"></script>
    <!-- Toastr -->
    <script src="<?= base_url() ?>assets/theme/adminlte/AdminLTE/plugins/toastr/toastr.min.js"></script>

    <!-- jQuery -->
    <script src="<?= base_url() ?>assets/theme/adminlte/AdminLTE/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>assets/theme/adminlte/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>assets/theme/adminlte/AdminLTE/dist/js/adminlte.min.js"></script>
  </body>

  </html>
  <?php
}