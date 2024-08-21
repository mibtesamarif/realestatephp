<?php
session_start();
include("config.php");

                // ----- Register -----
$error="";
$msg="";
if(isset($_REQUEST['reg'])) {
    $name = $_REQUEST['name'];
    $email = $_REQUEST['email'];
    $phone = $_REQUEST['phone'];
    $pass = $_REQUEST['pass'];
    $utype = $_REQUEST['utype'];
    $uimage = $_FILES['uimage']['name'];
    $temp_name1 = $_FILES['uimage']['tmp_name'];

    // Hash the password using password_hash()
    $hashed_pass =  password_hash($pass, PASSWORD_DEFAULT);


    try {

        // Check if email already exists
        $query = "SELECT * FROM user WHERE uemail = :email";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['email' => $email]);
        $num = $stmt->rowCount();

        if($num == 1) {
            $error = "<p class='alert alert-warning'>Email Id already exists</p>";
        } else {
            if(!empty($name) && !empty($email) && !empty($phone) && !empty($pass) && !empty($uimage)) {
                $sql = "INSERT INTO user (uname, uemail, uphone, upass, utype, uimage) VALUES (:name, :email, :phone, :pass, :utype, :uimage)";
                $stmt = $pdo->prepare($sql);
                $result = $stmt->execute([
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'pass' => $hashed_pass,
                    'utype' => $utype,
                    'uimage' => $uimage
                ]);

                if($result) {
                    move_uploaded_file($temp_name1, "admin/user/$uimage");
                    $msg = "<p class='alert alert-success'>Registered Successfully</p>";
                    header("Location: login.php");
                } else {
                    $error = "<p class='alert alert-warning'>Registration Not Successful</p>";
                }
            } else {
                $error = "<p class='alert alert-warning'>Please Fill all the fields</p>";
            }
        }
    } catch (PDOException $e) {
        $error = "<p class='alert alert-danger'>Error: " . $e->getMessage() . "</p>";
    }
}


            // ----- Login -----
$error="";
$msg="";
if (isset($_REQUEST['login'])) {
    $email = $_REQUEST['email'];
    $pass = $_REQUEST['pass'];

    if (!empty($email) && !empty($pass)) {
        try {
            // Prepare the SQL query to select user with the given email
            $sql = "SELECT * FROM user WHERE uemail = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($row) {
                // Verify the hashed password
                if (password_verify($pass, $row['upass'])) {
    

                    // Password is correct, set session variables
                    $_SESSION['uid'] = $row['uid'];
                    $_SESSION['utype'] = $row['utype'];
                    $_SESSION['uemail'] = $row['uemail'];
                    
                    // Redirect to index.php
                    header("Location: index.php");
                    exit(); // Ensure no further code is executed
                } else {
                    // Debugging: Log incorrect password attempt
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

                    // ----- Profile -----
// $error = "";
// $msg = "";

// if (isset($_REQUEST['update'])) {
//     $name = $_REQUEST['name'];
//     $email = $_REQUEST['email'];
//     $phone = $_REQUEST['phone'];
//     $pass = $_REQUEST['pass'];
//     $uid = $_SESSION['uid'];
//     $uimage = null;
//     $temp_name1 = null;

//     if (isset($_FILES['uimage']) && !empty($_FILES['uimage']['name'])) {
//         $uimage = $_FILES['uimage']['name'];
//         $temp_name1 = $_FILES['uimage']['tmp_name'];

//         // Generate a unique file name to avoid overwriting existing files
//         $uimage = time() . '_' . basename($uimage);
//         error_log("Image to upload: " . $uimage);
//     } else {
//         error_log("No image uploaded.");
//     }

//     try {
//         // Construct SQL query
//         $sql = "UPDATE user SET uname = :name, uemail = :email, uphone = :phone";
        
//         if (!empty($pass)) {
//             $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
//             $sql .= ", upass = :pass";
//         }

//         if (!empty($uimage)) {
//             $sql .= ", uimage = :uimage";
//         }

//         $sql .= " WHERE uid = :uid";
//         error_log("SQL Query: " . $sql);

//         $stmt = $pdo->prepare($sql);

//         // Bind parameters
//         $stmt->bindParam(':name', $name);
//         $stmt->bindParam(':email', $email);
//         $stmt->bindParam(':phone', $phone);

//         if (!empty($pass)) {
//             $stmt->bindParam(':pass', $hashed_pass);
//         }

//         if (!empty($uimage)) {
//             $stmt->bindParam(':uimage', $uimage);
//         }

//         $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);

//         // Execute the query
//         if ($stmt->execute()) {
//             error_log("Query executed successfully.");
//             if (!empty($uimage) && move_uploaded_file($temp_name1, "admin/user/$uimage")) {
//                 $msg = "<p class='alert alert-success'>Updated Successfully</p>";
//             } elseif (empty($uimage)) {
//                 $msg = "<p class='alert alert-success'>Updated Successfully</p>";
//             } else {
//                 $error = "<p class='alert alert-warning'>Image upload failed</p>";
//                 error_log("Failed to move uploaded image.");
//             }
//         } else {
//             $error = "<p class='alert alert-warning'>Update Not Successful</p>";
//             $errorInfo = $stmt->errorInfo();
//             error_log("Error executing query: " . print_r($errorInfo, true));
//         }
//     } catch (PDOException $e) {
//         error_log("PDOException: " . $e->getMessage());
//         $error = "<p class='alert alert-danger'>Error: " . $e->getMessage() . "</p>";
//     }
// }

// update user information
if(isset($_POST['update'])){
    $userId = $_SESSION['uid'];
    $userName = $_POST['name'];
    $userEmail = $_POST['email'];
    $phoneNumber = $_POST['phone'];
    $userbio = $_POST['bio'];

    $updateUserQuery = $pdo->prepare("UPDATE user SET uname = :name, uemail = :email, uphone = :phoneNumber WHERE uid = :userId");
    $updateUserQuery->bindParam(':name',  $userName);
    $updateUserQuery->bindParam(':email',  $userEmail);
    $updateUserQuery->bindParam(':phoneNumber', $phoneNumber);
    $updateUserQuery->bindParam(':userId', $userId);

    if($updateUserQuery->execute()){
        $userPassword = $_POST['pass'];
        if (!empty($userPassword)){
            $hashed_pass =  password_hash($userPassword, PASSWORD_DEFAULT);
            $updateUserPassQuery = $pdo->prepare("UPDATE user SET upass = :pass WHERE uid = :userId");
            $updateUserPassQuery->bindParam(':pass',  $hashed_pass);
            $updateUserPassQuery->bindParam(':userId', $userId);
            $updateUserPassQuery->execute();
        }
    }

        if (!empty($userbio)){
            $sql = "SELECT agent_bio FROM `bio` WHERE uid = :uid";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':uid', $userId, PDO::PARAM_INT);
            $stmt->execute();
        
            // Fetch all results into an array
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(!empty($results['agent_bio'])){
                $updateUserPassQuery = $pdo->prepare("UPDATE bio SET agent_bio = :agent_bio WHERE uid = :userId");
                $updateUserPassQuery->bindParam(':agent_bio',  $hashed_pass);
                $updateUserPassQuery->bindParam(':userId', $userId);
                $updateUserPassQuery->execute();
            }
            else{
                $insertUserPassQuery = $pdo->prepare("INSERT INTO bio (agent_bio, uid) VALUES (:agent_bio, :userId)");
                $insertUserPassQuery->bindParam(':agent_bio',  $userbio);
                $insertUserPassQuery->bindParam(':userId', $userId);
                $insertUserPassQuery->execute();
            }
        }
    

    if(isset($_FILES['uimage']) && $_FILES['uimage']['error'] === UPLOAD_ERR_OK){
        $categoryImageName = $_FILES['uimage']['name'];
        $categoryImageTmpName = $_FILES['uimage']['tmp_name'];
        $destination = "admin/user/" . $categoryImageName;
        
        // Move the uploaded file to the destination folder
        if(move_uploaded_file($categoryImageTmpName, $destination)){
            // Prepare and execute the SQL query to update the category in the database
            $query = $pdo->prepare("UPDATE user SET uimage = :categoryImageName WHERE uid = :id");
            $query->bindParam(':categoryImageName', $categoryImageName);
            $query->bindParam(':id', $userId);
            if($query->execute()){
                echo "<script>alert('inserted');</script>"; 
            }
            else{
                echo "<script>alert('not inserted');</script>";
            }
            
        
        } else {
            echo "<script>alert('Failed to move uploaded file');</script>";
        }
    }
}


?>