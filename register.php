<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// require 'C:/xampp/htdocs/project/PHPMailer-master/src/SMTP.php';
// require 'C:/xampp/htdocs/project/PHPMailer-master/src/PHPMailer.php';
// require 'C:/xampp/htdocs/project/PHPMailer-master/src/Exception.php';


include "config.php";
$n='';
$m='';
if (isset($_POST['submit'])) {
    // Validate input
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if ($password !== $cpassword) {
        echo "Passwords do not match";
    } elseif (empty($name) || empty($email) || empty($password)) {
        echo "All fields are required";
    } else {
        // Hash the password
        // $passwordHash = md5($password);

        // Insert data into the database
        $qry="SELECT * FROM user WHERE email='$email'";
        $run=mysqli_query($conn,$qry);
        $rest=mysqli_num_rows($run);
        // print_r($rest);die;
        if($rest>0){
          echo "Email already exist";
        }else{

        $sql = "INSERT INTO user (name, email, password) VALUES ('$name', '$email', md5('$password'))";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $n= "Data inserted successfully";

//             // Send email
//             $mail = new PHPMailer(true);

// // try {
//     // Server settings
//     $mail->SMTPDebug = 0; // Set to 0 in production to disable debug output
//     $mail->isSMTP();    
//     $mail->Host       = 'smtp.gmail.com'; // Corrected: Removed the semicolon
//     $mail->SMTPAuth   = true;
//     $mail->Username   = 'sandeepkauli652@gmail.com'; // Your SMTP username
//     $mail->Password   = 'gmftgthqyihmotna'; // Your SMTP password
//     // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use PHPMailer::ENCRYPTION_SMTPS for SSL
//     $mail->Port       = 587; // Port for TLS

//     // Recipients
//     $mail->setFrom('sandeepkauli652@gmail.com', 'Mailer'); // Set the sender email and name
//     $mail->addAddress('sandeepkauli652@gmail.com'); // Add a recipient
//     // $mail->addAddress('another@example.com', 'Receiver Name'); // Optionally add more recipients

//     // Content
//     $mail->isHTML(true);
//     $mail->Subject = 'Testing Mail';
//     $mail->Body    = '<b>Purpose only testing </b>';
//     $mail->AltBody = 'Body in plain text for non-HTML mail clients';

//     $mail->send();
//     $m="<span style='color:red;'> * Mail has been sent successfully! </span>";
// } catch (Exception $e) {
//     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
// }
        }
      }
    }
    }
?>





<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Registration Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="../../index2.html"><b>Admin</b>LTE</a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>
      <?php echo $m; ?>

      <form action="#" method="post">
        <div class="input-group mb-3">
          <input type="text"  name="name"  class="form-control" placeholder="Full name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email"   name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password"  name="password"  class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password"   name="cpassword" class="form-control" placeholder="Retype password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>

        </div>
        <?php echo $n; ?>

        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a><br><br>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center">
        

      <a href="login.html" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
</body>
</html>
