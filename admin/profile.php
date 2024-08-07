<?php
require("config.php");
//code
 
// if(!isset($_SESSION['auser']))
// {
// 	header("location:index.php");
// }

if (isset($_REQUEST['insert'])) {
    $name = $_REQUEST['name'];
    $email = $_REQUEST['email'];
    $pass = $_REQUEST['pass'];
    $dob = $_REQUEST['dob'];
    $phone = $_REQUEST['phone'];
    $auser = "admin";

    if (!empty($name) && !empty($email) && !empty($pass) && !empty($dob) && !empty($phone)) {
        try {
            // Hash the password
            $hashedPass = password_hash($pass, PASSWORD_DEFAULT);
            
            // Prepare the SQL statement
            $sql = "UPDATE admin SET auser = :name, aemail = :email, apass = :pass, adob = :dob, aphone = :phone WHERE auser = :auser";
            $stmt = $pdo->prepare($sql);
            
            // Bind the parameters
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':pass', $hashedPass);
            $stmt->bindParam(':dob', $dob);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':auser', $auser);
            
            // Execute the statement
            if ($stmt->execute()) {
                $msg = 'Admin Updated Successfully';
            } else {
                $error = '* Not Updated Admin. Try Again';
            }
        } catch (PDOException $e) {
            $error = '* Error: ' . $e->getMessage();
        }
    } else {
        $error = "* Please Fill all the Fields!";
    }
}

// Fetch the admin data
$id = "admin"; //$_SESSION['auser'];
try {
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE auser = :auser LIMIT 1");
    $stmt->bindParam(':auser', $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Query failed: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>LM HOMES | Profile</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
		
		<!-- Feathericon CSS -->
        <link rel="stylesheet" href="assets/css/feathericon.min.css">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
		
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->
    </head>
    <body>
	
		<!-- Main Wrapper -->

		
			<!-- Header -->
            <?php include("header.php");?>
			<!-- /Header -->
			
			<!-- Page Wrapper -->
            <div class="page-wrapper">
                <div class="content container-fluid">
					
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col">
								<h3 class="page-title">Profile</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
									<li class="breadcrumb-item active">Profile</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<?php if ($row) { ?>
							<div class="row">
								<div class="col-md-12">
									<div class="profile-header">
										<div class="row align-items-center">
											<div class="col-auto profile-image">
												<a href="#">
													<img class="rounded-circle" alt="User Image" src="assets/img/profiles/avatar-01.png">
												</a>
											</div>
											<div class="col ml-md-n2 profile-user-info">
												<h4 class="user-name mb-2 text-uppercase"><?php echo $row['auser']; ?></h4>
												<h6 class="text-muted"><?php echo $row['aemail']; ?></h6>
												<div class="user-Location"><i class="fa fa-id-badge" aria-hidden="true"></i>
												<?php echo $row['aphone']; ?></div>
												<div class="about-text"></div>
											</div>
										</div>
									</div>
									<div class="profile-menu">
										<ul class="nav nav-tabs nav-tabs-solid">
											<li class="nav-item">
												<a class="nav-link active" data-toggle="tab" href="#per_details_tab">About</a>
											</li>
										</ul>
									</div>
									<div class="tab-content profile-tab-cont">
										<div class="tab-pane fade show active" id="per_details_tab">
											<div class="row">
												<div class="col-lg-9">
													<div class="card">
														<div class="card-body">
															<form method="post">
																<div class="row">
																	<p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Name</p>
																	<span class="col-sm-4">
																		<div class="form-group">
																			<input class="form-control" value="<?php echo $row['auser']; ?>" type="text" placeholder="Name" name="name">
																		</div>
																	</span>
																</div>
																<div class="row">
																	<p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Date of Birth</p>
																	<span class="col-sm-4">
																		<div class="form-group">
																			<input class="form-control" value="<?php echo $row['adob']; ?>" type="date" placeholder="Date of Birth" name="dob">
																		</div>
																	</span>
																</div>
																<div class="row">
																	<p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Email ID</p>
																	<span class="col-sm-4">
																		<div class="form-group">
																			<input class="form-control" value="<?php echo $row['aemail']; ?>" type="email" placeholder="Email" name="email">
																		</div>
																	</span>
																</div>
																<div class="row">
																	<p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Password</p>
																	<span class="col-sm-4">
																		<div class="form-group">
																			<input class="form-control" type="password" placeholder="New Password" name="pass" maxlength="10">
																		</div>
																	</span>
																</div>
																<div class="row">
																	<p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Mobile</p>
																	<span class="col-sm-4">
																		<div class="form-group">
																			<input class="form-control" value="<?php echo $row['aphone']; ?>" type="text" placeholder="Phone" name="phone" maxlength="10">
																		</div>
																	</span>
																</div>
																<div class="row">
																<p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3"></p>
																	<span class="col-sm-4">
																	<div class="form-group mb-0">
																		<input class="btn btn-primary btn-block" type="submit" name="insert" Value="Update">
																	</div>
																	</span>
																</div>
															</form>
														</div>
													</div>
												</div>
												<div class="col-lg-3">
													<div class="card">
														<div class="card-body">
															<h5 class="card-title d-flex justify-content-between">
																<span>Account Status</span>
															</h5>
															<button class="btn btn-success" type="button"><i class="fe fe-check-verified"></i> Active</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php } ?>
				</div>			
			</div>
			<!-- /Page Wrapper -->

		<!-- /Main Wrapper -->
		
		<!-- jQuery -->
        <script src="assets/js/jquery-3.2.1.min.js"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
		
		<!-- Slimscroll JS -->
        <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		
		<!-- Custom JS -->
		<script  src="assets/js/script.js"></script>
		
    </body>
</html>