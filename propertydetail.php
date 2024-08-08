<?php 
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
include("config.php");
								
?>
<!DOCTYPE html>
<html lang="en">

<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Meta Tags --><!-- FOR MORE PROJECTS visit: freeprojectscodes.com -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Real Estate PHP">
<meta name="keywords" content="">
<meta name="author" content="Unicoder">
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
<link rel="stylesheet" type="text/css" href="css/color.css" id="color-change">
<link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="fonts/flaticon/flaticon.css">
<link rel="stylesheet" type="text/css" href="css/style.css">

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
                        <h2 class="page-name float-left text-white text-uppercase mt-1 mb-0"><b>Property Detail</b></h2>
                    </div>
                    <div class="col-md-6">
                        <nav aria-label="breadcrumb" class="float-left float-md-right">
                            <ol class="breadcrumb bg-transparent m-0 p-0">
                                <li class="breadcrumb-item text-white"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Property Detail</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
         <!--	Banner   --->

		
        <div class="full-row">
            <div class="container">
                <div class="row"><!-- FOR MORE PROJECTS visit: freeprojectscodes.com -->
				
					<?php
                        $id = $_REQUEST['pid'];

                        try {
                            // Assuming PDO connection is established and stored in $pdo
                            $sql = "SELECT property.*, user.* 
                                    FROM property 
                                    JOIN user ON property.uid = user.uid 
                                    WHERE property.pid = :id";
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(':id', $id);
                            $stmt->execute();

                            // Fetch all results into an array
                            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // Use foreach loop to iterate over the results
                            foreach ($results as $row) {
					  ?>
				  
                    <div class="col-lg-8">

                        <div class="row">
                            <div class="col-md-12">
                                <div id="single-property" style="width:1200px; height:700px; margin:30px auto 50px;"> 
                                    <!-- Slide 1-->
                                    <div class="ls-slide" data-ls="duration:7500; transition2d:5; kenburnszoom:in; kenburnsscale:1.2;"> <img width="1920" height="1080" src="admin/property/<?php echo $row['pimage'];?>" class="ls-bg" alt="" /> </div>
                                    
                                    <!-- Slide 2-->
                                    <div class="ls-slide" data-ls="duration:7500; transition2d:5; kenburnszoom:in; kenburnsscale:1.2;"> <img width="1920" height="1080" src="admin/property/<?php echo $row['pimage1'];?>" class="ls-bg" alt="" /> </div>
                                    
                                    <!-- Slide 3-->
                                    <div class="ls-slide" data-ls="duration:7500; transition2d:5; kenburnszoom:in; kenburnsscale:1.2;"> <img width="1920" height="1080" src="admin/property/<?php echo $row['pimage2'];?>" class="ls-bg" alt="" /> </div>
									
									<!-- Slide 4-->
									<div class="ls-slide" data-ls="duration:7500; transition2d:5; kenburnszoom:in; kenburnsscale:1.2;"> <img width="1920" height="1080" src="admin/property/<?php echo $row['pimage3'];?>" class="ls-bg" alt="" /> </div>
									
									<!-- Slide 5-->
									<div class="ls-slide" data-ls="duration:7500; transition2d:5; kenburnszoom:in; kenburnsscale:1.2;"> <img width="1920" height="1080" src="admin/property/<?php echo $row['pimage4'];?>" class="ls-bg" alt="" /> </div>
                                </div>
                            </div>
                        </div><!-- FOR MORE PROJECTS visit: freeprojectscodes.com -->
        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="bg-success d-table px-3 py-2 rounded text-white text-capitalize">For <?php echo $row['stype'];?></div>
                                <h5 class="mt-2 text-secondary text-capitalize"><?php echo $row['title'];?></h5>
                                <span class="mb-sm-20 d-block text-capitalize"><i class="fas fa-map-marker-alt text-success font-12"></i> &nbsp;<?php echo $row['location'];?></span>
							</div>
                            <div class="col-md-6">
                                <div class="text-success text-left h5 my-2 text-md-right">$<?php echo $row['price'];?></div>
                                <div class="text-left text-md-right">Price</div>
                            </div>
                        </div>
                        <div class="property-details">
                            <div class="bg-gray property-quantity px-4 pt-4 w-100">
                                <ul>
                                    <li><span class="text-secondary"><?php echo $row['size'];?></span> Sqft</li>
                                    <li><span class="text-secondary"><?php echo $row['bedroom'];?></span> Bedroom</li>
                                    <li><span class="text-secondary"><?php echo $row['bathroom'];?></span> Bathroom</li>
                                    <li><span class="text-secondary"><?php echo $row['balcony'];?></span> Balcony</li>
                                    <li><span class="text-secondary"><?php echo $row['hall'];?></span> Hall</li>
                                    <li><span class="text-secondary"><?php echo $row['kitchen'];?></span> Kitchen</li>
                                </ul>
                            </div>
                            <h4 class="text-secondary my-4">Description</h4>
                            <p><?php echo $row['pcontent'];?></p>
                            
                            <h5 class="mt-5 mb-4 text-secondary">Property Summary</h5>
                            <div  class="table-striped font-14 pb-2">
                                <table class="w-100"><!-- FOR MORE PROJECTS visit: freeprojectscodes.com -->
                                    <tbody>
                                        <tr>
                                            <td>BHK :</td>
                                            <td class="text-capitalize"><?php echo $row['bhk'];?></td>
                                            <td>Property Type :</td>
                                            <td class="text-capitalize"><?php echo $row['type'];?></td>
                                        </tr>
                                        <tr>
                                            <td>Floor :</td>
                                            <td class="text-capitalize"><?php echo $row['floor'];?></td>
                                            <td>Total Floor :</td>
                                            <td class="text-capitalize"><?php echo $row['totalfloor'];?></td>
                                        </tr>
                                        <tr>
                                            <td>City :</td>
                                            <td class="text-capitalize"><?php echo $row['city'];?></td>
                                            <td>State :</td>
                                            <td class="text-capitalize"><?php echo $row['state'];?></td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                            <h5 class="mt-5 mb-4 text-secondary">Features</h5>
                            <div class="row">
								<?php echo $row['feature'];?>
								
                            </div>   
						

                            <h5 class="mt-5 mb-4 text-secondary double-down-line-left position-relative">Contact Agent</h5>
                            <div class="agent-contact pt-60">
                                <div class="row">
                                    <div class="col-sm-4 col-lg-3"> <img src="admin/user/<?php echo $row['uimage']; ?>" alt="" height="200" width="170"> </div>
                                    <div class="col-sm-8 col-lg-9">
                                        <div class="agent-data text-ordinary mt-sm-20">
                                            <h6 class="text-success text-capitalize"><?php echo $row['uname'];?></h6>
                                            <ul class="mb-3">
                                                <li><?php echo $row['uphone'];?></li>
                                                <li><?php echo $row['uemail'];?></li>
                                            </ul>
                                            
                                            <div class="mt-3 text-secondary hover-text-success">
                                                <ul>
                                                    <li class="float-left mr-3"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                                    <li class="float-left mr-3"><a href="#"><i class="fab fa-twitter"></i></a></li>
                                                    <li class="float-left mr-3"><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                                                    <li class="float-left mr-3"><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                                    <li class="float-left mr-3"><a href="#"><i class="fas fa-rss"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- FOR MORE PROJECTS visit: freeprojectscodes.com -->
                                </div>
                            </div>
                        </div>
                    </div>
					
					<?php }
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        } ?>
					
                    <div class="col-lg-4">
                        <!-- <h4 class="double-down-line-left text-secondary position-relative pb-4 mb-4 mt-md-50">Send Message</h4>
                        <form method="post" action="#">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter Name">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter Email">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter Phone">
                                    </div>
                                </div>
								<div class="col-md-12">
                                    <div class="form-group">
										<textarea class="form-control" placeholder="Enter Message"></textarea>
                                    </div>
                                </div>
								
                                <div class="col-md-12">
                                    <div class="form-group mt-4">
                                        <button type="submit" class="btn btn-success w-100">Search Property</button>
                                    </div>
                                </div>
                            </div>
                        </form> -->
                        <h4 class="double-down-line-left text-secondary position-relative pb-4 my-4">Instalment Calculator</h4>
                        <form class="d-inline-block w-100" action="calc.php" method="post">
                            <label class="sr-only">Property Amount</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">$</div>
                                </div>
                                <input type="text" class="form-control" name="amount" placeholder="Property Price">
                            </div>
                            <label class="sr-only">Month</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                </div>
                                <input type="text" class="form-control" name="month" placeholder="Duration Year">
                            </div>
                            <label class="sr-only">Interest Rate</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">%</div>
                                </div>
                                <input type="text" class="form-control" name="interest" placeholder="Interest Rate">
                            </div>
                            <button type="submit" value="submit" name="calc" class="btn btn-danger mt-4">Calclute Instalment</button>
                        </form>
                        <h4 class="double-down-line-left text-secondary position-relative pb-4 mb-4 mt-5">Featured Property</h4>
                        <ul class="property_list_widget">
							
                            <?php 
                                try {
                                    // Assuming PDO connection is established and stored in $pdo
                                    $sql = "SELECT * FROM `property` WHERE isFeatured = 1 ORDER BY date DESC LIMIT 3";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute();

                                    // Fetch all results into an array
                                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    // Use foreach loop to iterate over the results
                                    foreach ($results as $row) {
                            ?>
                            <li> <img src="admin/property/<?php echo $row['pimage'];?>" alt="pimage">
                                <h6 class="text-secondary hover-text-success text-capitalize"><a href="propertydetail.php?pid=<?php echo $row['pid'];?>"><?php echo $row['title'];?></a></h6>
                                <span class="font-14"><i class="fas fa-map-marker-alt icon-success icon-small"></i> <?php echo $row['location'];?></span>
                                
                            </li>
                            <?php }
                                } catch (PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                } ?>

                        </ul>

                        <div class="sidebar-widget mt-5">
    <h4 class="double-down-line-left text-secondary position-relative pb-4 mb-4">Recently Added Property</h4>
    <ul class="property_list_widget">
        <?php
        // Prepare and execute the PDO query to get the recently added properties
        $stmt = $pdo->prepare("SELECT * FROM property ORDER BY date DESC LIMIT 7");
        $stmt->execute();
        $recentProperties = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Loop through the results and display each property
        foreach ($recentProperties as $row) {
        ?>
            <li>
                <img src="admin/property/<?php echo $row['pimage']; ?>" alt="pimage">
                <h6 class="text-secondary hover-text-success text-capitalize">
                    <a href="propertydetail.php?pid=<?php echo $row['pid']; ?>"><?php echo $row['title']; ?></a>
                </h6>
                <span class="font-14">
                    <i class="fas fa-map-marker-alt icon-success icon-small"></i> <?php echo ($row['location']); ?>
                </span>
            </li>
        <?php
        }
        ?>
    </ul>
</div>

                    </div>
                </div>
            </div>
        </div>

         <!--	Footer   start-->
		<?php include("include/footer.php");?>
		<!--	Footer   start-->
        
        
        <!-- Scroll to top --> 
        <a href="#" class="bg-secondary text-white hover-text-secondary" id="scroll"><i class="fas fa-angle-up"></i></a> 
        <!-- End Scroll To top --> 
    </div>
</div>
<!-- Wrapper End --> 

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

</body>

</html>