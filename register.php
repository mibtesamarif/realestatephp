<?php 
include("config.php");
$error="";
$msg="";
if(isset($_REQUEST['reg'])) {
    $name = $_REQUEST['name'];
    $email = $_REQUEST['email'];
    $phone = $_REQUEST['phone'];
    $pass = $_REQUEST['pass'];
    $utype = $_REQUEST['utype'];
    $uimage = $_FILES['uimage']['name'];
    $temp_name1 = $_FILES['uimage']['tmp_name'];

    // Hash the password using password_hash()
    $hashed_pass =  password_hash($pass, PASSWORD_DEFAULT);


    try {

        // Check if email already exists
        $query = "SELECT * FROM user WHERE uemail = :email";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['email' => $email]);
        $num = $stmt->rowCount();

        if($num == 1) {
            $error = "<p class='alert alert-warning'>Email Id already exists</p>";
        } else {
            if(!empty($name) && !empty($email) && !empty($phone) && !empty($pass) && !empty($uimage)) {
                $sql = "INSERT INTO user (uname, uemail, uphone, upass, utype, uimage) VALUES (:name, :email, :phone, :pass, :utype, :uimage)";
                $stmt = $pdo->prepare($sql);
                $result = $stmt->execute([
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'pass' => $hashed_pass,
                    'utype' => $utype,
                    'uimage' => $uimage
                ]);

                if($result) {
                    move_uploaded_file($temp_name1, "admin/user/$uimage");
                    $msg = "<p class='alert alert-success'>Registered Successfully</p>";
                    echo "<script> location.assign('login.php');</script>";
                } else {
                    $error = "<p class='alert alert-warning'>Registration Not Successful</p>";
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
<!-- FOR MORE PROJECTS visit: freeprojectscodes.com -->
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Meta Tags -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="shortcut icon" href="images/favicon.ico">

<!--	Fonts
	========================================================-->
<link href="https://fonts.googleapis.com/css?family=Muli:400,400i,500,600,700&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Comfortaa:400,700" rel="stylesheet">

<!--	Css Link
	========================================================-->
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-slider.css">
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="css/layerslider.css">
<link rel="stylesheet" type="text/css" href="css/color.css">
<link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="fonts/flaticon/flaticon.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/login.css">

<style>
        .password-validity {
            font-size: 0.9rem;
            color: #dc3545;
        }
        .valid {
            color: #28a745;
        }
    </style>

<!--	Title
	=========================================================-->
<title>Real Estate PHP</title>
</head>
<body>

<!--	Page Loader
=============================================================
<div class="page-loader position-fixed z-index-9999 w-100 bg-white vh-100">
	<div class="d-flex justify-content-center y-middle position-relative">
	  <div class="spinner-border" role="status">
		<span class="sr-only">Loading...</span>
	  </div>
	</div>
</div>
--> 


<div id="page-wrapper">
    <div class="row"> 
        <!--	Header start  -->
		<?php include("include/header.php");?>
        <!--	Header end  --><!-- FOR MORE PROJECTS visit: freeprojectscodes.com -->
        
        <!--	Banner   --->
        <!-- <div class="banner-full-row page-banner" style="background-image:url('images/breadcromb.jpg');">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="page-name float-left text-white text-uppercase mt-1 mb-0"><b>Register</b></h2>
                    </div>
                    <div class="col-md-6">
                        <nav aria-label="breadcrumb" class="float-left float-md-right">
                            <ol class="breadcrumb bg-transparent m-0 p-0">
                                <li class="breadcrumb-item text-white"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Register</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div> -->
         <!--	Banner   --->
		 
		 
		 
        <div class="page-wrappers login-body full-row bg-gray">
            <div class="login-wrapper">
            	<div class="container">
                	<div class="loginbox">
                        <div class="login-right">
							<div class="login-right-wrap">
								<h1>Register</h1>
								<p class="account-subtitle">Access to our dashboard</p>
								<?php echo $error; ?><?php echo $msg; ?>
								<!-- Form -->
								<form method="post" enctype="multipart/form-data">
									<div class="form-group">
										<input type="text"  name="name" class="form-control" placeholder="Your Name*" required>
									</div>
									<div class="form-group">
										<input type="email"  name="email" class="form-control" placeholder="Your Email*" required>
									</div>
									<div class="form-group">
										<input type="text"  name="phone" class="form-control" placeholder="Your Phone*" minlength="11" maxlength="11" required>
									</div>
									<div class="form-group">
										<input type="password" name="pass" id="password"  class="form-control" placeholder="Your Password*" required>
                                        <small id="passwordHelp" class="form-text text-muted password-validity">
                                            <ul>
                                                <li id="length" class="invalid">Length: 8-16 characters</li>
                                                <li id="number" class="invalid">At least one number</li>
                                                <li id="special" class="invalid">At least one special character</li>
                                                <li id="lower" class="invalid">At least one lowercase letter</li>
                                                <li id="upper" class="invalid">At least one uppercase letter</li>
                                            </ul>
                                        </small>
									</div>

									 <div class="form-check-inline">
									  <label class="form-check-label">
										<input type="radio" class="form-check-input" name="utype" value="user" checked>User
									  </label>
									</div><!-- FOR MORE PROJECTS visit: freeprojectscodes.com -->
									<div class="form-check-inline">
									  <label class="form-check-label">
										<input type="radio" class="form-check-input" name="utype" value="agent">Agent
									  </label>
									</div>
									
									<div class="form-group">
										<label class="col-form-label"><b>User Image</b></label>
										<input class="form-control" name="uimage" type="file">
									</div>
									
									<button class="btn btn-success" name="reg" value="Register" type="submit">Register</button>
									
								</form>
								
								<div class="login-or">
									<span class="or-line"></span>
									<span class="span-or">or</span>
								</div>
								
								<!-- Social Login -->
								<!-- <div class="social-login">
									<span>Register with</span>
									<a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a>
									<a href="#" class="google"><i class="fab fa-google"></i></a>
									<a href="#" class="facebook"><i class="fab fa-twitter"></i></a>
									<a href="#" class="google"><i class="fab fa-instagram"></i></a>
								</div> -->
								<!-- /Social Login -->
								
								<div class="text-center dont-have">Already have an account? <a href="login.php">Login</a></div>
								
							</div><!-- FOR MORE PROJECTS visit: freeprojectscodes.com -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
	<!--	login  -->
        
        
        <!--	Footer   start-->
		<?php include("include/footer.php");?>
		<!--	Footer   start-->
        
        <!-- Scroll to top --> 
        <a href="#" class="bg-secondary text-white hover-text-secondary" id="scroll"><i class="fas fa-angle-up"></i></a> 
        <!-- End Scroll To top --> 
    </div>
</div>
<!-- Wrapper End --> 
<!-- FOR MORE PROJECTS visit: freeprojectscodes.com -->
<!--	Js Link
============================================================--> 
<script src="js/jquery.min.js"></script> 
<!--jQuery Layer Slider --> 
<script src="js/greensock.js"></script> 
<script src="js/layerslider.transitions.js"></script> 
<script src="js/layerslider.kreaturamedia.jquery.js"></script> 
<!--jQuery Layer Slider --> 
<script src="js/popper.min.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/owl.carousel.min.js"></script> 
<script src="js/tmpl.js"></script> 
<script src="js/jquery.dependClass-0.1.js"></script> 
<script src="js/draggable-0.1.js"></script> 
<script src="js/jquery.slider.js"></script> 
<script src="js/wow.js"></script> 
<script src="js/custom.js"></script>

<script>
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const length = document.getElementById('length');
            const number = document.getElementById('number');
            const special = document.getElementById('special');
            const lower = document.getElementById('lower');
            const upper = document.getElementById('upper');

            const lengthPattern = /^.{8,16}$/;
            const numberPattern = /\d/;
            const specialPattern = /[!@#$%^&*(),.?":{}|<>]/;
            const lowerPattern = /[a-z]/;
            const upperPattern = /[A-Z]/;

            // Validate length
            if (lengthPattern.test(password)) {
                length.classList.remove('invalid');
                length.classList.add('valid');
            } else {
                length.classList.remove('valid');
                length.classList.add('invalid');
            }

            // Validate number
            if (numberPattern.test(password)) {
                number.classList.remove('invalid');
                number.classList.add('valid');
            } else {
                number.classList.remove('valid');
                number.classList.add('invalid');
            }

            // Validate special character
            if (specialPattern.test(password)) {
                special.classList.remove('invalid');
                special.classList.add('valid');
            } else {
                special.classList.remove('valid');
                special.classList.add('invalid');
            }

            // Validate lowercase letter
            if (lowerPattern.test(password)) {
                lower.classList.remove('invalid');
                lower.classList.add('valid');
            } else {
                lower.classList.remove('valid');
                lower.classList.add('invalid');
            }

            // Validate uppercase letter
            if (upperPattern.test(password)) {
                upper.classList.remove('invalid');
                upper.classList.add('valid');
            } else {
                upper.classList.remove('valid');
                upper.classList.add('invalid');
            }
        });
    </script>
</body>
</html>