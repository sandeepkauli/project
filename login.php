<?php
session_start();
if(isset($_COOKIE['email_user']) && isset($_COOKIE['email_password'])){
  $id= $_COOKIE['email_user'];
  $pass= $_COOKIE['email_password'];
}else{
  $id="";
  $pass="";

}

if(!empty($_SESSION['user_id'])){
  header('location:index.php');
}
include "config.php";
if(isset($_POST['login'])){ 

  $email= $_POST['email'];
  $password= md5($_POST['password']);

 $sql= "SELECT * FROM user WHERE email='$email' AND password='$password'";
  $result= mysqli_query($conn,$sql);
  $data=mysqli_fetch_array($result);
  // echo"<pre>";
  // print_r($data);die();

  if($result->num_rows>0){
    // echo "Insert data successfully";
    $_SESSION['user_id']= $data['id'];

    if(isset($_POST['remember_me'])){
      setcookie('email_user',$_POST['email'],time()+(60*60));
      setcookie('email_password',$_POST['password'],time()+(60*60));

    }else{
      setcookie('email_user','',time()-(60*60));
      setcookie('email_password','',time()-(60*60));

    }
    header('location:index.php');
  }else{
    echo "<span style='color:red;'>* Something is wwrong *</span>";
  }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Admin</b>LTE</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      
      
      <form action="#" method="post">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" vlaue="<?php echo $id; ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" vlaue="<?php echo $pass; ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" name="remember_me" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit"  name="login" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

     

      <p class="mb-1">
        <a href="forgot-password.php">I forgot my password</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
</body>
</html>
