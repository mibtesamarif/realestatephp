<?php
include("config.php");
$pid = $_GET['id'];

$sql = "DELETE FROM property WHERE pid = :pid";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':pid', $pid, PDO::PARAM_INT);

if ($stmt->execute()) {
    $msg = "<p class='alert alert-success'>Property Deleted</p>";
} else {
    $msg = "<p class='alert alert-warning'>Property Not Deleted</p>";
}

header("Location: propertyview.php?msg=" . urlencode($msg));
?>