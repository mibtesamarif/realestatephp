<?php
include("config.php");
$cid = $_GET['id'];
$sql = "DELETE FROM contact WHERE cid = :cid";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':cid', $cid, PDO::PARAM_INT);

if ($stmt->execute()) {
    $msg = "<p class='alert alert-success'>Contact Deleted</p>";
    header("Location:contactview.php?msg=$msg");
} else {
    $msg = "<p class='alert alert-warning'>Contact Not Deleted</p>";
    header("Location:contactview.php?msg=$msg");
}
?>
