<?php
include("config.php");
$cid = $_GET['id'];
$sql = "DELETE FROM city WHERE cid = :cid";
try {
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cid', $cid, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        $msg = "<p class='alert alert-success'>City Deleted</p>";
        header("Location: cityadd.php?msg=$msg");
    } else {
        $msg = "<p class='alert alert-warning'>City Not Deleted</p>";
        header("Location: cityadd.php?msg=$msg");
    }
} catch (PDOException $e) {
    $error = "<p class='alert alert-danger'>Error: " . $e->getMessage() . "</p>";
    // Optionally redirect with error message
}
?>
