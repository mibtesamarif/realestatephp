<?php
session_start();
require("config.php"); 
// if(!isset($_SESSION['auser']))
// {
// 	header("location:index.php");
// }
///code
$error="";
$msg="";

if (isset($_POST['insert'])) {
    $ustate = $_POST['state'];

    if (!empty($ustate)) {
        try {
            // Check if the state already exists
            $checkSql = "SELECT COUNT(*) FROM state WHERE sname = :ustate";
            $checkStmt = $pdo->prepare($checkSql);
            $checkStmt->bindParam(':ustate', $ustate);
            $checkStmt->execute();
            $exists = $checkStmt->fetchColumn();

            if ($exists) {
                $msg = "<p class='alert alert-warning'>State Already Present</p>";
            } else {
                // State does not exist, insert it
                $sql = "INSERT INTO state (sname) VALUES (:ustate)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':ustate', $ustate);
                $result = $stmt->execute();

                if ($result) {
                    $msg = "<p class='alert alert-success'>State Inserted Successfully</p>";
                } else {
                    $msg = "<p class='alert alert-warning'>State Not Inserted</p>";
                }
            }
        } catch (PDOException $e) {
            $error = "<p class='alert alert-danger'>Error: " . $e->getMessage() . "</p>";
        }
    } else {
        $error = "<p class='alert alert-warning'>* Fill all the Fields</p>";
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
					
				<!-- state add section --> 
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h1 class="card-title">Add State</h1>
									<?php echo $error;?>
									<?php echo $msg;?>
									<?php
										if (isset($_GET['msg_id'])) {
											$msg_id = $_GET['msg_id'];}
									?>
								</div>
								<form method="post" id="insert product" enctype="multipart/form-data">
									<div class="card-body">
											<div class="row">
												<div class="col-xl-6">
													<h5 class="card-title">State Details</h5>
													<div class="form-group row">
														<label class="col-lg-3 col-form-label">State Name</label>
														<div class="col-lg-9">
															<input type="text" class="form-control" name="state">
														</div>
													</div>
												</div>
											</div>
											<div class="text-left">
												<input type="submit" class="btn btn-primary"  value="Submit" name="insert" style="margin-left:200px;">
											</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				<!----End state add section  --->
				
				<!----view state  --->
				<div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">State List</h4>
									
								</div>
								<div class="card-body">

									<table id="basic-datatable " class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>State</th>
													<th>Actions</th>
                                                </tr>
                                            </thead>
                                        
                                        
											<tbody>
												<?php
												// Prepare the SQL statement
												$sql = "SELECT * FROM state";
												$stmt = $pdo->query($sql);
												$cnt = 1;
												
												// Fetch and display the results
												while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
												?>
												<tr>
													<td><?php echo $cnt; ?></td>
													<td><?php echo htmlspecialchars($row['sname']); ?></td>
													<td>
														<a href="stateedit.php?id=<?php echo $row['sid']; ?>"><button class="btn btn-info">Edit</button></a>
														<a href="statedelete.php?id=<?php echo $row['sid']; ?>"><button class="btn btn-danger">Delete</button></a>
													</td>
												</tr>
												<?php 
													$cnt++;
												} 
												?>
											</tbody>
								</div>
							</div>
						</div>
					</div>
				<!-- view state -->
				</div>			
			</div>
			<!-- /Main Wrapper -->
			<!---
			
			<label class="col-lg-3 col-form-label">State Name</label>
													<div class="col-lg-9">	
														<select class="form-control">
															<option>Select</option>
															<option>Option 1</option>
															<option>Option 2</option>
															<option>Option 3</option>
															<option>Option 4</option>
															<option>Option 5</option>
														</select>
													</div>
			
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
