<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in (v2)</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="#" class="h1"><b>Admin</b>LTE</a>
      </div>
      <div class="card-body">
        <div class="err"></div>
        <p class="login-box-msg">Sign in to start your session</p>
        <div id="alert" class="form-group"></div>
        <form method="post" id="loginForm">
          <div class="input-group mb-3">
            <input type="email" id="email" name="email" class="form-control" placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" id="password" name="password" class="form-control" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <input type="submit" class="btn btn-primary btn-block" value="Sign In">
            </div>
            <!-- /.col -->
          </div>
        </form>
        <p class="mb-1">
          <a href="forgot-password.html">I forgot my password</a>
        </p>

      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <script src="plugins/jquery-validation/jquery.validate.js"></script>
  <script src="plugins/jquery-validation/jquery.validate.min.js"></script>

  <script src="plugins/datatables/jquery.dataTables.js"></script>
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script>
    $(document).ready(function() {
      $("#loginForm").submit(function(event) {
        event.preventDefault();
        alert();
        $.ajax({
          type: "POST",
          url: "http://127.0.0.1:8000/API/login.php",
          data: JSON.stringify({
            email: $("#email").val(),
            password: $("#password").val()
          }),
          dataType: "json",
          encode: true,
        }).done(function(data) {
          console.log(data);
          if (data.email) {
            $(".card-body").html(
              '<div class="alert alert-success">' + data.message + '</div>'
            );
            setTimeout(function() {
              window.location.href = 'pages/dashboard/dashboard.php';
            }, 500);
          }
        }).fail(function(e) {
          console.log(e);
          $(".err").html(
            '<p class="alert alert-danger">' + e.responseJSON.message + '</p>'
          );
        });
      });
    });
  </script>
</body>

</html>
