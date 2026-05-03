<?php
include('../includes/db.php');
session_start();

if(isset($_POST['add_train'])){
    $t_no = $_POST['train_number'];
    $t_name = $_POST['train_name'];
    $source = $_POST['source'];
    $dest = $_POST['destination'];
    $dep_time = $_POST['dep_time'];
    $arr_time = $_POST['arr_time'];
    $fare = $_POST['fare'];

    $sql = "INSERT INTO trains (train_number, train_name, source_station, destination_station, departure_time, arrival_time, fare) 
            VALUES ('$t_no', '$t_name', '$source', '$dest', '$dep_time', '$arr_time', '$fare')";

    if(mysqli_query($conn, $sql)){
        echo "<script>alert('Train Added Successfully!'); window.location.href='admin_dashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Train - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow p-4">
                <h4 class="mb-3 text-primary">Add New Train</h4>
                <form method="POST">
                    <div class="mb-3"><input type="text" name="train_number" class="form-control" placeholder="Train Number" required></div>
                    <div class="mb-3"><input type="text" name="train_name" class="form-control" placeholder="Train Name" required></div>
                    <div class="row">
                        <div class="col-6 mb-3"><input type="text" name="source" class="form-control" placeholder="Source Station" required></div>
                        <div class="col-6 mb-3"><input type="text" name="destination" class="form-control" placeholder="Destination" required></div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3"><label class="small">Departure</label><input type="time" name="dep_time" class="form-control" required></div>
                        <div class="col-6 mb-3"><label class="small">Arrival</label><input type="time" name="arr_time" class="form-control" required></div>
                    </div>
                    <div class="mb-3"><input type="number" name="fare" class="form-control" placeholder="Ticket Fare (Base Price)" required></div>
                    <button type="submit" name="add_train" class="btn btn-primary w-100">Save Train</button>
                    <a href="admin_dashboard.php" class="btn btn-link w-100 mt-2">Back to Dashboard</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>