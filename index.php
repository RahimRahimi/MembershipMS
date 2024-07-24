<?php
include('includes/config.php');
if (isset($_COOKIE['email']) && isset($_COOKIE['password'])){
  $email = $_COOKIE['email'];
  $password = $_COOKIE['password'];
}else{
  $email = '';
  $password = '';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            $error_message = "Email and password are required!";
        } else {
            $hashed_password = md5($password);

            $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$hashed_password'";
            $result = $conn->query($sql);
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();

                $_SESSION['user_id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['image'] = $row['image'];
                
                if(isset($_REQUEST['remember_me'])){
                  setcookie('email', $_REQUEST['email'], time() + 21600, '/');
                  setcookie('password', $_REQUEST['password'], time() + 21600, '/');
                }else{
                  setcookie('email', '', time() - 3600, '/');
                  setcookie('password', '', time() - 3600, '/');
                }

                header("Location: dashboard.php");
                exit();
            } else {
                $error_message = "Invalid email or password!";
            }
        }
    }
}

?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo getSystemName();?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<?php 
  function getLogoUrl()
  {
      global $conn;

      $logoQuery = "SELECT logo FROM settings";
      $logoResult = $conn->query($logoQuery);

      if ($logoResult->num_rows > 0) {
          $logoRow = $logoResult->fetch_assoc();
          return $logoRow['logo'];
      } else {
          return 'dist/img/AdminLTELogo.png';
      }
  }

  function getSystemName()
  {
      global $conn;

      $systemNameQuery = "SELECT system_name FROM settings";
      $systemNameResult = $conn->query($systemNameQuery);

      if ($systemNameResult->num_rows > 0) {
          $systemNameRow = $systemNameResult->fetch_assoc();
          return $systemNameRow['system_name'];
      } else {
          return 'MMS';
      }
  }
?>
<div class="login-box">
  <div class="login-logo">
    <img src="<?php echo getLogoUrl();?>" alt="System Logo" width="151px"><br>
    
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-header text-center h5">
      <b><?php echo getSystemName(); ?></b>
    </div>
    
    <div class="card-body login-card-body">
      <p class="login-box-msg">Log in to start your session</p>

      <?php
            if (isset($error_message)) {
            echo '<div class="alert alert-danger">' . $error_message . '</div>';
            }
        ?>

      <form action="" method="POST">
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $email;?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" value="<?php echo $password;?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember_me" name="remember_me">
              <label for="remember_me">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="login" class="btn btn-success btn-block">Log In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>

</html>