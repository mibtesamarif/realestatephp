<?php 
session_start();
include("config.php");
$error="";
$msg="";


if (isset($_REQUEST['login'])) {
    $email = trim($_REQUEST['user']); // Trim to remove any extra spaces
    $pass = trim($_REQUEST['pass']);

    if (!empty($email) && !empty($pass)) {
        try {
            // Prepare the SQL query to select user with the given email
            $sql = "SELECT * FROM admin WHERE aemail = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {

                // Verify the hashed password
                if (password_verify($pass, $row['apass'])) {
                    // Password is correct, set session variables
                    $_SESSION['aid'] = $row['aid'];
                    $_SESSION['auser'] = $row['auser'];
                    $_SESSION['aemail'] = $row['aemail'];

                    // Redirect to form.php
                    header("Location: form.php");
                    exit(); // Ensure no further code is executed
                } else {
                    // Debugging: Log incorrect password attempt
                    echo "Password verification failed.<br>";
                   
                    $error = "<p class='alert alert-warning'>Email or Password does not match!</p>";
                }
            } else {
                $error = "<p class='alert alert-warning'>Email or Password does not match!</p>";
            }
        } catch (PDOException $e) {
            $error = "<p class='alert alert-danger'>Error: " . $e->getMessage() . "</p>";
        }
    } else {
        $error = "<p class='alert alert-warning'>Please fill all the fields</p>";
    }
}

// Display any error messages
if (isset($error)) {
    echo $error;
}
?>




	<!DOCTYPE html>
	<html lang="en">
		
	<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
			<title>RE Admin - Login</title>
			
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
									<h1>Admin Login Panel</h1>
									<p class="account-subtitle">Access to our dashboard</p>
									<!-- Form -->
									<form method="post">
										<div class="form-group">
											<input class="form-control" name="user" type="text" placeholder="User Name">
										</div>
										<div class="form-group">
											<input class="form-control" type="password" name="pass" placeholder="Password">
										</div>
										<div class="form-group">
											<button class="btn btn-primary btn-block" name="login" type="submit">Login</button>
										</div>
									</form>
									<p style="color:red;"><?php if (isset($error)): ?>
										<p><?php echo $error; ?></p>
										<?php endif; ?>
									</p>
																	
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