<?php
include("query.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta Tags -->
    <meta name="description" content="Real Estate">
    <meta name="keywords" content="">
    <meta name="author" content="Unicoder">
    <link rel="shortcut icon" href="images/favicon.ico">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,500,600,700&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Comfortaa:400,700" rel="stylesheet">

    <!-- Css Link -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-slider.css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="css/layerslider.css">
    <link rel="stylesheet" type="text/css" href="css/color.css" id="color-change">
    <link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/flaticon/flaticon.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <!-- Title -->
    <title>Real Estate</title>
</head>
<body>

<!-- Page Wrapper -->
<div id="page-wrapper">
    <div class="row"> 

        <?php include("include/header.php");?>
        <!-- Header Start -->
        <!-- Header End -->

        <!-- Banner -->
        <div class="banner-full-row page-banner" style="background-image:url('images/breadcromb.jpg');">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="page-name float-left text-white text-uppercase mt-1 mb-0"><b>Agent Detail</b></h2>
                    </div>
                    <div class="col-md-6">
                        <nav aria-label="breadcrumb" class="float-left float-md-right">
                            <ol class="breadcrumb bg-transparent m-0 p-0">
                                <li class="breadcrumb-item text-white"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Agent Detail</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- Banner End -->

        <!-- Property Grid -->
        <div class="full-row">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row">
                        <?php 
                                try {
                                    // Check if 'uid' is set in the request
                                    if (isset($_REQUEST['uid'])) {
                                        $id = $_REQUEST['uid']; // This is the agent's UID, assumed to be passed in the request
                                    } else {
                                        throw new Exception('UID not set in request.');
                                    }
                                
                                    // Assuming PDO connection is established and stored in $pdo
                                    if (!isset($pdo)) {
                                        throw new Exception('PDO connection is not initialized.');
                                    }
                                
                                    $sql = "SELECT property.*, user.uname, user.utype, user.uimage 
                                            FROM property 
                                            JOIN user ON property.uid = user.uid
                                            WHERE property.uid = :uid"; // Filter by the agent's UID
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->bindParam(':uid', $id, PDO::PARAM_INT); // Bind the UID parameter
                                    $stmt->execute();
                                
                                    // Fetch all results into an array
                                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                    // Use foreach loop to iterate over the results
                                    foreach ($results as $row) {
							?>
                            <div class="col-md-6">
                                <div class="featured-thumb hover-zoomer mb-4">
                                    <div class="overlay-black overflow-hidden position-relative"> 
                                        <img src="admin/property/<?php echo $row['pimage'];?>" alt="Property Image">
                                        <div class="sale bg-success text-white">For <?php echo $row['stype'];?></div>
                                        <div class="price text-primary text-capitalize">PKR <?php echo $row['price'];?> <span class="text-white"><?php echo $row['size'];?> Sqft</span></div>
                                    </div>
                                    <div class="featured-thumb-data shadow-one">
                                        <div class="p-4">
                                            <h5 class="text-secondary hover-text-success mb-2 text-capitalize"><a href="propertydetail.php?pid=<?php echo $row['pid'];?>"><?php echo $row['title'];?></a></h5>
                                            <span class="location text-capitalize"><i class="fas fa-map-marker-alt text-success"></i> <?php echo $row['location'];?></span> 
                                        </div>
                                        <div class="px-4 pb-4 d-inline-block w-100">
                                            <div class="float-left text-capitalize"><i class="fas fa-user text-success mr-1"></i>By <?php echo $row['uname'];?></div>
                                            <div class="float-right"><i class="far fa-calendar-alt text-success mr-1"></i> <?php echo date('d-m-Y', strtotime($row['date']));?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php  }
} catch (Exception $e) {
    echo "<p class='alert alert-danger'>Error: " . $e->getMessage() . "</p>";
} ?>
                        </div>
                    </div>

                    
                    
                    <div class="col-lg-4">
                        <!-- Agent Details Section -->
                        <div class="sidebar-widget">
                            <h4 class="double-down-line-left text-secondary position-relative pb-4 my-4">Agent Details</h4>
                            <?php 
                                
                             try {
                                if (isset($_REQUEST['uid'])) {
                                    $id = $_REQUEST['uid']; // This is the agent's UID, assumed to be passed in the request
                                } else {
                                    throw new Exception('UID not set in request.');
                                }
                                        $sql = "SELECT * FROM `user` WHERE uid = :uid";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->bindParam(':uid', $id, PDO::PARAM_INT);
                                        $stmt->execute();
                                    
                                        // Fetch all results into an array
                                        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    
                                        // Use foreach to iterate over the results
                                        foreach ($results as $row) {
								?>
                            <div class="agent-info">
                                <img src="admin/user/<?php echo $row['uimage'];?>" alt="Agent Image" class="img-fluid mb-3">
                                <h5 class="text-secondary"><?php echo $row['uname'];?></h5>
                                <?php
                                $id = $row['uid'];
                                 $sql = "SELECT * FROM `bio` WHERE uid = :uid";
                                 $stmt = $pdo->prepare($sql);
                                 $stmt->bindParam(':uid', $id, PDO::PARAM_INT);
                                 $stmt->execute();

                                 
                                        // Fetch all results into an array
                                        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    
                                        // Use foreach to iterate over the results
                                        foreach ($results as $row1) {
                                ?>
                                <p><strong>Bio:</strong> <?php echo $row1['agent_bio'];?></strong></p>

                                <?php
                                        }
                                ?>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-envelope text-success mr-2"></i> <?php echo $row['uemail'];?></li>
                                    <li><i class="fas fa-phone-alt text-success mr-2"></i> <?php echo $row['uphone'];?></li>
                                    <li><i class="fas fa-map-marker-alt text-success mr-2"></i> 123 Real Estate St, City, Country</li>
                                </ul>

                                
                                <!-- Rating Section
                                <p><strong>Rating:</strong></p>
                                <div class="rating mb-3">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                    <span class="ml-2">(4.5/5 based on 120 reviews)</span>
                                </div> -->
                                <?php }
                                            } catch (PDOException $e) {
                                            echo "Error: " . $e->getMessage();
                                            } ?>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- Footer Start -->
        <?php include("include/footer.php");?>
        <!-- Footer End -->
        
        <!-- Scroll to Top -->
        <a href="#" class="bg-secondary text-white hover-text-secondary" id="scroll"><i class="fas fa-angle-up"></i></a> 
    </div>
</div>
<!-- Wrapper End --> 

<!-- Js Link -->
<script src="js/jquery.min.js"></script> 
<script src="js/greensock.js"></script> 
<script src="js/layerslider.transitions.js"></script> 
<script src="js/layerslider.kreaturamedia.jquery.js"></script> 
<script src="js/popper.min.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/owl.carousel.min.js"></script> 
<script src="js/tmpl.js"></script> 
<script src="js/jquery.dependClass-0.1.js"></script> 
<script src="js/draggable-0.1.js"></script> 
<script src="js/jquery.slider.js"></script> 
<script src="js/wow.js"></script> 
<script src="js/custom.js"></script>
</body>
</html>
