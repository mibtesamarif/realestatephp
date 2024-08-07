<?php
session_start();
include("config.php"); 
if(!isset($_SESSION['auser']))
{
	header("location:index.php");
}
///code
$error="";
$msg="";
if (isset($_POST['insert'])) {
    $cid = $_GET['id'];
    $ustate = $_POST['ustate'];
    $ucity = $_POST['ucity'];
    
    if (!empty($ustate) && !empty($ucity)) {
        try {
            $sql = "UPDATE city SET cname = :ucity, sid = :ustate WHERE cid = :cid";
            $stmt = $pdo->prepare($sql);
            
            // Bind the parameters
            $stmt->bindParam(':ucity', $ucity);
            $stmt->bindParam(':ustate', $ustate);
            $stmt->bindParam(':cid', $cid, PDO::PARAM_INT);
            
            // Execute the statement
            if ($stmt->execute()) {
                $msg = "<p class='alert alert-success'>City Updated</p>";
                header("Location: cityadd.php?msg=$msg");
            } else {
                $msg = "<p class='alert alert-warning'>City Not Updated</p>";
                header("Location: cityadd.php?msg=$msg");
            }
        } catch (PDOException $e) {
            $error = "<p class='alert alert-danger'>Error: " . $e->getMessage() . "</p>";
            // Optionally redirect with error message
        }
    } else {
        $error = "<p class='alert alert-warning'>* Please Fill all the Fields</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Ventura - Data Tables</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
		
		<!-- Feathericon CSS -->
        <link rel="stylesheet" href="assets/css/feathericon.min.css">
		
		<!-- Datatables CSS -->
		<link rel="stylesheet" href="assets/plugins/datatables/dataTables.bootstrap4.min.css">
		<link rel="stylesheet" href="assets/plugins/datatables/responsive.bootstrap4.min.css">
		<link rel="stylesheet" href="assets/plugins/datatables/select.bootstrap4.min.css">
		<link rel="stylesheet" href="assets/plugins/datatables/buttons.bootstrap4.min.css">
		
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
			<!-- /Sidebar -->
			
			<!-- Page Wrapper -->
            <div class="page-wrapper">
                <div class="content container-fluid">

					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col">
								<h3 class="page-title">State</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
									<li class="breadcrumb-item active">State</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
				<!-- city add section --> 
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h1 class="card-title">Add City</h1>
									<?php echo $error;?>
									<?php echo $msg;?>
									<?php 
										if(isset($_GET['msg']))	
										echo $_GET['msg'];	
									?>
								</div>
								<?php 
								$cid = $_GET['id'];
								$sql = "SELECT city.*, state.sname FROM city JOIN state ON city.sid = state.sid WHERE city.cid = :cid";
								$stmt = $pdo->prepare($sql);
								$stmt->bindParam(':cid', $cid, PDO::PARAM_INT);
								$stmt->execute();
								$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
								
								foreach ($rows as $row) {
								?>
								<form method="post">
									<div class="card-body">
											<div class="row">
												<div class="col-xl-6">
													<h5 class="card-title">City Details</h5>
													<div class="form-group row">
														<label class="col-lg-3 col-form-label">State Name</label>
														<div class="col-lg-9" >	
															<select class="form-control" name="ustate">
																<option value="<?php echo $row['sid']; ?>"><?php echo $row['sname']; ?></option>
																<?php
																		$excludedState = $row['sname'];

																		// Fetch states excluding the specific state
																		$sql = "SELECT * FROM state WHERE sname <> :excludedState";
																		$query1 = $pdo->prepare($sql);
																		$query1->bindParam(':excludedState', $excludedState, PDO::PARAM_STR);
																		$query1->execute();
																		$rows1 = $query1->fetchAll(PDO::FETCH_ASSOC);
																		
																		foreach ($rows1 as $row1) {
																	?>
																<option value="<?php echo $row1['sid']; ?>">
																<?php echo $row1['sname']; ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-lg-3 col-form-label">City Name</label>
														<div class="col-lg-9">
															<input type="text" class="form-control" name="ucity" value="<?php echo $row['cname']; ?>">
														</div>
													</div>
												</div>
											</div>
											<div class="text-left">
												<input type="submit" class="btn btn-primary"  value="Submit" name="insert" style="margin-left:200px;">
											</div>
									</div>
								</form>
								<?php } ?>
							</div>
						</div>
					</div>
				<!----End City add section  --->

				</div>			
			</div>
			<!-- /Main Wrapper -->
			<!---
			
			
			
			---->

		<!-- jQuery -->
        <script src="assets/js/jquery-3.2.1.min.js"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
		
		<!-- Slimscroll JS -->
        <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		
		<!-- Datatables JS -->
		<!-- Datatables JS -->
		<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
		<script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
		<script src="assets/plugins/datatables/responsive.bootstrap4.min.js"></script>
		
		<script src="assets/plugins/datatables/dataTables.select.min.js"></script>
		
		<script src="assets/plugins/datatables/dataTables.buttons.min.js"></script>
		<script src="assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
		<script src="assets/plugins/datatables/buttons.html5.min.js"></script>
		<script src="assets/plugins/datatables/buttons.flash.min.js"></script>
		<script src="assets/plugins/datatables/buttons.print.min.js"></script>
		
		<!-- Custom JS -->
		<script  src="assets/js/script.js"></script>
		
    </body>
</html>
