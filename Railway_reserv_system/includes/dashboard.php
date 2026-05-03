<?php
session_start();
include('db.php');

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];

if ($role == 'Administrator') {
    header("Location: ../admin/admin_dashboard.php");
    exit();
} else {
    header("Location: ../user/passenger_dashboard.php");
    exit();
}
?>
