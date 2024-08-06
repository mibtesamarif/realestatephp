<?php
include("config.php");
$uid = $_GET['id'];

// view code
$sql = "SELECT uimage FROM user WHERE uid = :uid";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $img = $row['uimage'];
    @unlink('user/' . $img);
}

// end view code
$msg = "";
$sql = "DELETE FROM user WHERE uid = :uid";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':uid', $uid, PDO::PARAM_INT);

if ($stmt->execute()) {
    $msg = "<p class='alert alert-success'>Agent Deleted</p>";
} else {
    $msg = "<p class='alert alert-warning'>Agent not Deleted</p>";
}

header("Location: useragent.php?msg=" . urlencode($msg));

$pdo = null;
?>
