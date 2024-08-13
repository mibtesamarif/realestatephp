<?php 
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
$error="";
$msg="";
include("config.php");
if (isset($_REQUEST['reg'])) {
    $name = $_REQUEST['name'];
    $email = $_REQUEST['email'];
    $phone = $_REQUEST['phone'];
    $pass = $_REQUEST['pass'];
    $uimage = $_FILES['uimage']['name'];
    $temp_name1 = $_FILES['uimage']['tmp_name'];
    $uid = $_SESSION['uid'];

    try {
        if (!empty($pass)) {
            $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "UPDATE user SET uname = :name, uphone = :phone, upass = :pass";
            if (!empty($uimage)) {
                $sql .= ", uimage = :uimage";
            }
            $sql .= " WHERE uid = :uid";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':pass', $hashed_pass);
        } else {
            $sql = "UPDATE user SET uname = :name, uphone = :phone";
            if (!empty($uimage)) {
                $sql .= ", uimage = :uimage";
            }
            $sql .= " WHERE uid = :uid";
            $stmt = $pdo->prepare($sql);
        }
    
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        if (!empty($uimage)) {
            $stmt->bindParam(':uimage', $uimage);
        }
        $stmt->bindParam(':uid', $uid);
    
        if ($stmt->execute()) {
            if (!empty($uimage)) {
                move_uploaded_file($temp_name1, "admin/user/$uimage");
            }
            $msg = "<p class='alert alert-success'>Updated Successfully</p>";
        } else {
            $error = "<p class='alert alert-warning'>Update Not Successful</p>";
        }
    } catch (PDOException $e) {
        error_log($e->getMessage()); // Log error message
        $error = "<p class='alert alert-danger'>Error: " . $e->getMessage() . "</p>";
    }
}	
?>
<!DOCTYPE html>
<html lang="en">

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
        <!--	Header end  -->
        
        <!--	Banner   --->
        <div class="banner-full-row page-banner" style="background-image:url('images/breadcromb.jpg');">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="page-name float-left text-white text-uppercase mt-1 mb-0"><b>Profile</b></h2>
                    </div>
                    <div class="col-md-6">
                        <nav aria-label="breadcrumb" class="float-left float-md-right">
                            <ol class="breadcrumb bg-transparent m-0 p-0">
                                <li class="breadcrumb-item text-white"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Profile</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
         <!--	Banner   --->
		 
		 
		<!--	Submit property   -->
            <?php
            $uid = $_SESSION['uid'];
            echo"$uid";
            ?>
        <div class="full-row">
            <div class="container">
                    <div class="row">
						<div class="col-lg-12">
							<h2 class="text-secondary double-down-line text-center">Profile</h2>
                        </div>
					</div>
                <div class="dashboard-personal-info p-5 bg-white">
                    <form action="#" method="post">
                        <h5 class="text-secondary border-bottom-on-white pb-3 mb-4">User Information</h5>
						<?php echo $msg; ?><?php echo $error; ?>
                        <?php 
									$uid = $_SESSION['uid'];

                                    try {
                                        $sql = "SELECT * FROM `user` WHERE uid = :uid";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
                                        $stmt->execute();
                                    
                                        // Fetch all results into an array
                                        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    
                                        // Use foreach to iterate over the results
                                        foreach ($results as $row) {
								?>
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <input type="text"  name="name" value="<?php echo $row['uname'];?>" class="form-control" placeholder="Your Name*">
                                </div>                
                                
                                <div class="form-group">
                                    <input type="email"  name="email" value="<?php echo $row['uemail'];?>" class="form-control" placeholder="Your Email*">
								</div>

                                <div class="form-group">
                                    <input type="text"  name="phone" value="<?php echo $row['uphone'];?>" class="form-control" placeholder="Your Phone*" minlength="11" maxlength="11">
								</div>
                                <div class="form-group">
                                    <textarea id="bio" name="bio" class="form-control" placeholder="Your Bio (max 250 characters)" maxlength="250" rows="4"></textarea>
                                    <small id="charCount" class="form-text text-muted">250 characters remaining</small>
                                </div>

                                <div class="form-group">
                                    <input type="password" name="pass" id="password"  class="form-control" placeholder="Your Password*">
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

                                <div class="form-group">
                                    <label class="col-form-label"><b>User Image</b></label>
                                    <input class="form-control" name="uimage" type="file">
                                </div>

                                <button class="btn btn-success" name="update" value="Register" type="submit">Save</button>
                            </div>
							</form>
                            <div class="col-lg-1"></div>
                            <div class="col-lg-5 col-md-12">
								
                                <div class="user-info mt-md-50"> <img src="admin/user/<?php echo $row['uimage'];?>" alt="userimage">
                                    <div class="mb-4 mt-3">
                                        
                                    </div>
									
                                    <div class="font-18">
                                        <div class="mb-1 text-capitalize"><b style="color:black;"> <?php echo $row['uname'];?></b></div>
                                        <div class="mb-1 mt-1"><b>Bio:</b> <?php echo $row['uemail'];?></div>
                                        <div class="mb-1 mt-1"><b style="color:black;">Contact Information</b> </div>
                                        <div class="mb-1"><b>Email:</b> <?php echo $row['uemail'];?></div>
                                        <div class="mb-1"><b>Contact:</b> <?php echo $row['uphone'];?></div>
										<div class="mb-1 text-capitalize"><b>Role:</b> <?php echo $row['utype'];?></div>
                                    </div>
									
                                </div>
                            </div>
                        </div>
                        <?php }
                                            } catch (PDOException $e) {
                                            echo "Error: " . $e->getMessage();
                                            } ?>
                    
                </div>            
            </div>
        </div>
	<!--	Submit property   -->
      <!-- FOR MORE PROJECTS visit: freeprojectscodes.com -->  
        
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
    <script>
        const bio = document.getElementById('bio');
        const charCount = document.getElementById('charCount');
        const maxChars = 250;

        bio.addEventListener('input', function() {
            const remaining = maxChars - bio.value.length;
            charCount.textContent = `${remaining} characters remaining`;

            // If the limit is reached, prevent further typing
            if (remaining <= 0) {
                charCount.textContent = 'You have reached the 250 character limit';
            }
        });
    </script>
</body>
</html>