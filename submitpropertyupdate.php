<?php 
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
include("config.php");

// Check if user is logged in
if(!isset($_SESSION['uemail'])) {
    header("location:login.php");
    exit;
}

$msg = "";
if (isset($_POST['add'])) {
    $pid = $_REQUEST['id'];
    
    $title = $_POST['title'];
    $content = $_POST['content'];
    $ptype = $_POST['ptype'];
    $bhk = $_POST['bhk'];
    $bed = $_POST['bed'];
    $balc = $_POST['balc'];
    $hall = $_POST['hall'];
    $stype = $_POST['stype'];
    $bath = $_POST['bath'];
    $kitc = $_POST['kitc'];
    $floor = $_POST['floor'];
    $price = $_POST['price'];
    $city = $_POST['city'];
    $asize = $_POST['asize'];
    $loc = $_POST['loc'];
    $state = $_POST['state'];
    $status = $_POST['status'];
    $uid = $_SESSION['uid'];
    $feature = $_POST['feature'];
    
    $totalfloor = $_POST['totalfl'];
    
    $aimage = $_FILES['aimage']['name'];
    $aimage1 = $_FILES['aimage1']['name'];
    $aimage2 = $_FILES['aimage2']['name'];
    $aimage3 = $_FILES['aimage3']['name'];
    $aimage4 = $_FILES['aimage4']['name'];
    
    $fimage = $_FILES['fimage']['name'];
    $fimage1 = $_FILES['fimage1']['name'];
    $fimage2 = $_FILES['fimage2']['name'];
    
    $temp_name  = $_FILES['aimage']['tmp_name'];
    $temp_name1 = $_FILES['aimage1']['tmp_name'];
    $temp_name2 = $_FILES['aimage2']['tmp_name'];
    $temp_name3 = $_FILES['aimage3']['tmp_name'];
    $temp_name4 = $_FILES['aimage4']['tmp_name'];
    
    $temp_name5 = $_FILES['fimage']['tmp_name'];
    $temp_name6 = $_FILES['fimage1']['tmp_name'];
    $temp_name7 = $_FILES['fimage2']['tmp_name'];
    
    move_uploaded_file($temp_name, "admin/property/$aimage");
    move_uploaded_file($temp_name1, "admin/property/$aimage1");
    move_uploaded_file($temp_name2, "admin/property/$aimage2");
    move_uploaded_file($temp_name3, "admin/property/$aimage3");
    move_uploaded_file($temp_name4, "admin/property/$aimage4");
    
    move_uploaded_file($temp_name5, "admin/property/$fimage");
    move_uploaded_file($temp_name6, "admin/property/$fimage1");
    move_uploaded_file($temp_name7, "admin/property/$fimage2");

    // Update property using PDO
    try {
        $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE property SET title = :title, pcontent = :content, type = :ptype, bhk = :bhk, stype = :stype,
                bedroom = :bed, bathroom = :bath, balcony = :balc, kitchen = :kitc, hall = :hall, floor = :floor, 
                size = :asize, price = :price, location = :loc, city = :city, state = :state, feature = :feature,
                pimage = :aimage, pimage1 = :aimage1, pimage2 = :aimage2, pimage3 = :aimage3, pimage4 = :aimage4,
                uid = :uid, status = :status, mapimage = :fimage, topmapimage = :fimage1, groundmapimage = :fimage2, 
                totalfloor = :totalfloor WHERE pid = :pid";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':ptype' => $ptype,
            ':bhk' => $bhk,
            ':stype' => $stype,
            ':bed' => $bed,
            ':bath' => $bath,
            ':balc' => $balc,
            ':kitc' => $kitc,
            ':hall' => $hall,
            ':floor' => $floor,
            ':asize' => $asize,
            ':price' => $price,
            ':loc' => $loc,
            ':city' => $city,
            ':state' => $state,
            ':feature' => $feature,
            ':aimage' => $aimage,
            ':aimage1' => $aimage1,
            ':aimage2' => $aimage2,
            ':aimage3' => $aimage3,
            ':aimage4' => $aimage4,
            ':uid' => $uid,
            ':status' => $status,
            ':fimage' => $fimage,
            ':fimage1' => $fimage1,
            ':fimage2' => $fimage2,
            ':totalfloor' => $totalfloor,
            ':pid' => $pid
        ]);

        $msg = "<p class='alert alert-success'>Property Updated</p>";
        header("Location:feature.php?msg=$msg");
        exit;

    } catch (PDOException $e) {
        $msg = "<p class='alert alert-warning'>Property Not Updated: " . $e->getMessage() . "</p>";
        header("Location:feature.php?msg=$msg");
        exit;
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

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,500,600,700&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Comfortaa:400,700" rel="stylesheet">

    <!-- Css Link -->
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

    <!-- Title -->
    <title>Real Estate PHP</title>
</head>
<body>

<div id="page-wrapper">
    <div class="row"> 
        <!-- Header start -->
        <?php include("include/header.php");?>
        <!-- Header end -->
        
        <!-- Submit property -->
        <div class="full-row">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="text-secondary double-down-line text-center">Update Property</h2>
                    </div>
                </div>
                <div class="row p-5 bg-white">
                    <form method="post" enctype="multipart/form-data">
                        <?php foreach ($properties as $row) { ?>
                            <div class="description">
                                <h3 class="text-primary">Property Information</h3>
                                <div class="row">
                                    <!-- Property Title -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" class="form-control" required>
                                        </div>
                                    </div>
                                    <!-- Property Content -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea name="content" class="form-control" required><?php echo htmlspecialchars($row['pcontent']); ?></textarea>
                                        </div>
                                    </div>
                                    <!-- Property Type -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Property Type</label>
                                            <select name="ptype" class="form-control" required>
                                                <option value="Residential" <?php echo $row['type'] == 'Residential' ? 'selected' : ''; ?>>Residential</option>
                                                <option value="Commercial" <?php echo $row['type'] == 'Commercial' ? 'selected' : ''; ?>>Commercial</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- BHK -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>BHK</label>
                                            <input type="number" name="bhk" value="<?php echo htmlspecialchars($row['bhk']); ?>" class="form-control" required>
                                        </div>
                                    </div>
                                    <!-- Bedrooms -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Bedrooms</label>
                                            <input type="number" name="bed" value="<?php echo htmlspecialchars($row['bedroom']); ?>" class="form-control" required>
                                        </div>
                                    </div>
                                    <!-- Balconies -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Balconies</label>
                                            <input type="number" name="balc" value="<?php echo htmlspecialchars($row['balcony']); ?>" class="form-control" required>
                                        </div>
                                    </div>
                                    <!-- Hall -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Hall</label>
                                            <input type="number" name="hall" value="<?php echo htmlspecialchars($row['hall']); ?>" class="form-control" required>
                                        </div>
                                    </div>
                                    <!-- Type -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Type</label>
                                            <select name="stype" class="form-control" required>
                                                <option value="Flat" <?php echo $row['stype'] == 'Flat' ? 'selected' : ''; ?>>Flat</option>
                                                <option value="House" <?php echo $row['stype'] == 'House' ? 'selected' : ''; ?>>House</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Bathrooms -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Bathrooms</label>
                                            <input type="number" name="bath" value="<?php echo htmlspecialchars($row['bathroom']); ?>" class="form-control" required>
                                        </div>
                                    </div>
                                    <!-- Kitchen -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kitchen</label>
                                            <input type="number" name="kitc" value="<?php echo htmlspecialchars($row['kitchen']); ?>" class="form-control" required>
                                        </div>
                                    </div>
                                    <!-- Floor -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Floor</label>
                                            <input type="number" name="floor" value="<?php echo htmlspecialchars($row['floor']); ?>" class="form-control" required>
                                        </div>
                                    </div>
                                    <!-- Price -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Price</label>
                                            <input type="number" name="price" value="<?php echo htmlspecialchars($row['price']); ?>" class="form-control" required>
                                        </div>
                                    </div>
                                    <!-- City -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>City</label>
                                            <input type="text" name="city" value="<?php echo htmlspecialchars($row['city']); ?>" class="form-control" required>
                                        </div>
                                    </div>
                                    <!-- Size -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Size</label>
                                            <input type="text" name="asize" value="<?php echo htmlspecialchars($row['size']); ?>" class="form-control" required>
                                        </div>
                                    </div>
                                    <!-- Location -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Location</label>
                                            <input type="text" name="loc" value="<?php echo htmlspecialchars($row['location']); ?>" class="form-control" required>
                                        </div>
                                    </div>
                                    <!-- State -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>State</label>
                                            <input type="text" name="state" value="<?php echo htmlspecialchars($row['state']); ?>" class="form-control" required>
                                        </div>
                                    </div>
                                    <!-- Status -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" class="form-control" required>
                                                <option value="Available" <?php echo $row['status'] == 'Available' ? 'selected' : ''; ?>>Available</option>
                                                <option value="Sold" <?php echo $row['status'] == 'Sold' ? 'selected' : ''; ?>>Sold</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Features -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Features</label>
                                            <textarea name="feature" class="form-control" required><?php echo htmlspecialchars($row['feature']); ?></textarea>
                                        </div>
                                    </div>
                                    <!-- Total Floor -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Total Floors</label>
                                            <input type="number" name="totalfl" value="<?php echo htmlspecialchars($row['totalfloor']); ?>" class="form-control" required>
                                        </div>
                                    </div>
                                    <!-- Images -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Images</label>
                                            <input type="file" name="aimage" class="form-control">
                                            <input type="file" name="aimage1" class="form-control">
                                            <input type="file" name="aimage2" class="form-control">
                                            <input type="file" name="aimage3" class="form-control">
                                            <input type="file" name="aimage4" class="form-control">
                                            <input type="file" name="fimage" class="form-control">
                                            <input type="file" name="fimage1" class="form-control">
                                            <input type="file" name="fimage2" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <button type="submit" name="add" class="btn btn-primary">Update Property</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- End of Submit property -->
        
        <!-- Footer -->
        <?php include("include/footer.php");?>
        <!-- End of Footer -->
    </div>
</div>

<!-- Scripts -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/bootstrap-slider.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/layerslider.transitions.js"></script>
<script src="js/layerslider.kreaturamedia.jquery.js"></script>
<script src="js/script.js"></script>

</body>
</html>
