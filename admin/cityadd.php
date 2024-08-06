<?php
session_start();
include("config.php"); 
// if(!isset($_SESSION['auser']))
// {
// 	header("location:index.php");
// }
///code
$error="";
$msg="";
if (isset($_POST['insert'])) {
    $state = $_POST['state'];
    $city = $_POST['city'];

    if (!empty($state) && !empty($city)) {
        // Check if the city already exists
        $checkSql = "SELECT * FROM city WHERE cname = :city AND sid = :state";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->bindParam(':city', $city);
        $checkStmt->bindParam(':state', $state);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            $error = "<p class='alert alert-warning'>* City Already Exists</p>";
        } else {
            // Insert the new city
            $sql = "INSERT INTO city (cname, sid) VALUES (:city, :state)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':state', $state);
            
            if ($stmt->execute()) {
                $msg = "<p class='alert alert-success'>City Inserted Successfully</p>";
            } else {
                $error = "<p class='alert alert-warning'>* City Not Inserted</p>";
            }
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
					
				<!-- city add section --> 
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h1 class="card-title">Add City</h1>
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
													<h5 class="card-title">City Details</h5>
													<div class="form-group row">
														<label class="col-lg-3 col-form-label">State Name</label>
														<div class="col-lg-9" >
															<?php
															// Example PDO query to get the state data
															$query = $pdo->query("SELECT sid, sname FROM state");
															$rows = $query->fetchAll(PDO::FETCH_ASSOC);
															?>
															<select class="form-control" name="state">
																<option value="">Select</option>
																<?php foreach ($rows as $row1) { ?>
																	<option value="<?php echo $row1['sid']; ?>" class="text-capitalize"><?php echo $row1['sname']; ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-lg-3 col-form-label">City Name</label>
														<div class="col-lg-9">
															<input type="text" class="form-control" name="city">
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
				<!----End City add section  --->
				
				<!----view city  --->
				<div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">City List</h4>
									
								</div>
								<div class="card-body">

									<table id="basic-datatable" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>City</th>
													<!-- <th>State ID</th> -->
													<th>State</th>
													<th>Actions</th>
                                                </tr>
                                            </thead>
                                        
                                        
                                            <tbody>
											<?php
													
													$query = $pdo->query("SELECT city.*, state.sname FROM city, state WHERE city.sid = state.sid");
													$rows = $query->fetchAll(PDO::FETCH_ASSOC);
													$cnt = 1;
													foreach ($rows as $row) {
											?>
                                                <tr>
                                                    
                                                    <td><?php echo $cnt; ?></td>
                                                    <td><?php echo $row['cname']; ?></td>
													<!-- <td><?php echo $row['sid']; ?></td> -->
													<td><?php echo $row['sname']; ?></td>
													<td><a href="cityedit.php?id=<?php echo $row['cid']; ?>"><button class="btn btn-info">Edit</button></a>
                                                   <a href="citydelete.php?id=<?php echo $row['cid']; ?>"><button class="btn btn-danger">Delete</button></a></td>
                                                </tr>
                                                <?php $cnt++; } ?>

                                            </tbody>
                                        </table>
								</div>
							</div>
						</div>
					</div>
				<!-- view City -->
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
