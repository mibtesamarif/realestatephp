<?php
include("config.php");
$aid = $_GET['id'];

// view code//
$aid = $_GET['id'];

// Fetch the current image name
$sql = "SELECT image FROM about WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $aid]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $img = $row["image"];
    @unlink('upload/' . $img);
}

// Delete the record
$sql = "DELETE FROM about WHERE id = :id";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute(['id' => $aid]);

if ($result) {
    $msg = "<p class='alert alert-success'>About Deleted</p>";
    header("Location:aboutview.php?msg=$msg");
} else {
    $msg = "<p class='alert alert-warning'>About not Deleted</p>";
    header("Location:aboutview.php?msg=$msg");
}
?>
