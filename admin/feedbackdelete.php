<?php
include("config.php");
$fid = $_GET['id'];

$sql = "DELETE FROM feedback WHERE fid = :fid";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':fid', $fid, PDO::PARAM_INT);

if ($stmt->execute()) {
    $msg = "<p class='alert alert-success'>Feedback Deleted</p>";
} else {
    $msg = "<p class='alert alert-warning'>Feedback Not Deleted</p>";
}

header("Location: feedbackview.php?msg=" . urlencode($msg));
?>
