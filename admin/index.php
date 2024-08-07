<?php 
	session_start();
	include("config.php");
	$_SESSION['auser'] = "admin";
	//header("Location: dashboard.php");

	if (isset($_POST['login'])) {
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		$storedHash = '$2y$10$2gV0WpwHBO7q/EjDi/KPa.ieQol/K7XI8ZUfjLMwhyr';
		$inputPassword = '12345';
		
		if (!empty($user) && !empty($pass)) {
			try {
				// Prepare the SQL statement
				$sql = "SELECT auser, apass FROM admin WHERE auser = :user";
				$stmt = $pdo->prepare($sql);
				
				// Bind the parameters
				$stmt->bindParam(':user', $user);
				
				// Execute the statement
				$stmt->execute();
				
				// Fetch the result
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				
				if ($row) {
					// Debugging: Print the hashed password from the database
					echo 'Hashed password in DB: ' . $row['apass'] . '<br>';
					echo 'Plain text password: ' . htmlspecialchars($pass) . '<br>'; // Avoid echoing plain text passwords in production
					echo 'user input password: ' . $pass . '<br>';

					// Verify the password
					if (password_verify($pass, $row['apass'])) {
						echo 'Password Verified!';
						$_SESSION['auser'] = $user;
						//header("Location: dashboard.php");
						exit();
					} else {
						echo 'Password Not Verified!';
					}
					
					// if (password_verify($inputPassword, $storedHash)){
					// 	$_SESSION['auser'] = $user;
					// 	echo "<script>location.assign('dashboard.php');</script>";
					// 	//exit();
					// } else {
					// 	$error = '* Invalid Username or Password';
					// }
				} else {
					$error = '* Username not found';
				}
			} catch (PDOException $e) {
				$error = '* Error: ' . $e->getMessage();
			}
		} else {
			$error = "* Please fill all the fields!";
		}
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