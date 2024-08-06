<?php
include("config.php");
$sid = $_GET['id'];
$sql = "DELETE FROM state WHERE sid = :sid";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':sid', $sid, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $msg = "<p class='alert alert-success'>State Deleted</p>";
        header("Location:stateadd.php?msg=$msg");
    } else {
        $msg = "<p class='alert alert-warning'>State Not Deleted</p>";
        header("Location:stateadd.php?msg=$msg");
    }
} catch (PDOException $e) {
    $msg = "<p class='alert alert-warning'>State Not Deleted</p>";
    header("Location:stateadd.php?msg=$msg");
}
?>
