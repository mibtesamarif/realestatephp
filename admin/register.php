<?php 
include("config.php");
$error="";
$msg="";
if(isset($_REQUEST['insert']))
{
	$name=$_REQUEST['name'];
	$email=$_REQUEST['email'];
	$pass=$_REQUEST['pass'];
	$dob=$_REQUEST['dob'];
	$phone=$_REQUEST['phone'];
	
	$hashed_pass =  password_hash($pass, PASSWORD_DEFAULT);


    try {

        // Check if email already exists
        $query = "SELECT * FROM admin WHERE aemail = :email";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['email' => $email]);
        $num = $stmt->rowCount();

        if($num == 1) {
            $error = "<p class='alert alert-warning'>Email Id already exists</p>";
        } else {
            if(!empty($name) && !empty($email) && !empty($phone) && !empty($pass) && !empty($phone)) {
                $sql = "INSERT INTO admin (auser, aemail, apass, adob, aphone) VALUES (:auser, :aemail, :apass, :adob, :aphone)";
                $stmt = $pdo->prepare($sql);
                $result = $stmt->execute([
                    'auser' => $name,
                    'aemail' => $email,
                    'apass' => $hashed_pass,
                    'adob' => $dob,
                    'aphone' => $phone
                    
                ]);

                if($result) {
                  
                    $msg = "<p class='alert alert-success'>Registered Successfully</p>";
                } else {
                    $error = "<p class='alert alert-warning'>Registration Not Successful</p>";
                    echo "<script> location.assign('login.php');</script>";
                }
            } else {
                $error = "<p class='alert alert-warning'>Please Fill all the fields</p>";
            }
        }
    } catch (PDOException $e) {
        $error = "<p class='alert alert-danger'>Error: " . $e->getMessage() . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Ventura - Register</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
		
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->
    </head>
    <body>
	
		<!-- Main Wrapper -->
        <div class="page-wrappers login-body">
            <div class="login-wrapper">
            	<div class="container">
                	<div class="loginbox">
                    	
                        <div class="login-right">
							<div class="login-right-wrap">
								<h1>Register</h1>
								<p class="account-subtitle">Access to our dashboard</p>
								<p style="color:red;"><?php echo $error; ?></p>
								<p style="color:green;"><?php echo $msg; ?></p>
								<!-- Form -->
								<form method="post">
									<div class="form-group">
										<input class="form-control" type="text" placeholder="Name" name="name">
									</div>
									<div class="form-group">
										<input class="form-control" type="email" placeholder="Email" name="email">
									</div>
									<div class="form-group">
										<input class="form-control" type="text" placeholder="Password" name="pass">
									</div>
									<div class="form-group">
										<input class="form-control" type="date" placeholder="Date of Birth" name="dob">
									</div>
									<div class="form-group">
										<input class="form-control" type="text" placeholder="Phone" name="phone" maxlength="10">
									</div>
									<div class="form-group mb-0">
										<input class="btn btn-primary btn-block" type="submit" name="insert" Value="Register">
									</div>
								</form>
								<!-- /Form -->
								
								<div class="login-or">
									<span class="or-line"></span>
									<span class="span-or">or</span>
								</div>
								
								<!-- Social Login -->
								<div class="social-login">
									<span>Register with</span>
									<a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
									<a href="#" class="google"><i class="fa fa-google"></i></a>
									<a href="#" class="facebook"><i class="fa fa-twitter"></i></a>
									<a href="#" class="google"><i class="fa fa-instagram"></i></a>
								</div>
								<!-- /Social Login -->
								
								<div class="text-center dont-have">Already have an account? <a href="index.php">Login</a></div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!-- /Main Wrapper -->
		
		<!-- jQuery -->
        <script src="assets/js/jquery-3.2.1.min.js"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
		
		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>
		
    </body>

</html>