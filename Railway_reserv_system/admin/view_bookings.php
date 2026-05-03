<?php
include('../includes/db.php');
session_start();

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM bookings WHERE id='$id'");
    header("Location: view_bookings.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Bookings - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow p-4">
        <div class="d-flex justify-content-between mb-3">
            <h4 class="text-primary">Passenger Bookings</h4>
            <a href="admin_dashboard.php" class="btn btn-secondary btn-sm">Back</a>
        </div>
        <table class="table table-hover table-bordered bg-white">
            <thead class="table-dark">
                <tr>
                    <th>PNR</th>
                    <th>Passenger Name</th>
                    <th>Train ID</th>
                    <th>Coach</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $res = mysqli_query($conn, "SELECT * FROM bookings ORDER BY id DESC");
                while($row = mysqli_fetch_assoc($res)){
                    $status_class = ($row['status'] == 'Waiting') ? 'bg-warning text-dark' : 'bg-success';
                    echo "<tr>
                            <td><b>{$row['pnr']}</b></td>
                            <td>{$row['passenger_name']}</td>
                            <td>{$row['train_id']}</td>
                            <td>{$row['coach']}</td>
                            <td><span class='badge $status_class'>{$row['status']}</span></td>
                            <td>
                                <a href='view_bookings.php?delete={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Cancel</a>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>