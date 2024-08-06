<?php
include("config.php");
$uid = $_GET['id'];

// Prepare the SQL statement to select the user
$sql = "SELECT * FROM user WHERE uid = :uid";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':uid', $uid, PDO::PARAM_INT);

// Execute the statement
$stmt->execute();

// Fetch the result
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $img = $row["uimage"];
    
    // Delete the image file
    @unlink('user/' . $img);

    // Prepare the SQL statement to delete the user
    $sql = "DELETE FROM user WHERE uid = :uid";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);

    // Execute the statement
    if ($stmt->execute()) {
        $msg = "<p class='alert alert-success'>User Deleted</p>";
    } else {
        $msg = "<p class='alert alert-warning'>User not Deleted</p>";
    }
} else {
    $msg = "<p class='alert alert-warning'>User not found</p>";
}

// Redirect with message
header("Location: userlist.php?msg=" . urlencode($msg));

// Close the PDO connection
$pdo = null;
?>
