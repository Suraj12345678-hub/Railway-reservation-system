<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Rail Reserv</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f4f7f6; }
        .admin-card { border: none; border-radius: 12px; transition: 0.3s; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .admin-card:hover { transform: translateY(-5px); box-shadow: 0 8px 16px rgba(0,0,0,0.2); }
        .btn-custom { border-radius: 30px; padding: 10px 25px; font-weight: 600; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container d-flex justify-content-between align-items-center">
        <span class="navbar-brand mb-0 h1">
            <i class="fa fa-train me-2"></i> Rail Reserv Admin Panel
        </span>
        <a href="../includes/logout.php" class="text-light">
            <i class="fa-solid fa-power-off fs-4"></i>
        </a>
    </div>
</nav>

<div class="container">
    <div class="row text-center">
        <div class="col-md-4 mb-4">
            <div class="card admin-card p-4">
                <i class="fa fa-file-excel fa-3x text-success mb-3"></i>
                <h5>Booking Report</h5>
                <a href="export_excel.php" class="btn btn-success btn-custom">
                    <i class="fa fa-download me-2"></i> Export to Excel
                </a>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card admin-card p-4">
                <i class="fa fa-plus-circle fa-3x text-primary mb-3"></i>
                <h5>Add New Train</h5>
                <a href="add_train.php" class="btn btn-primary btn-custom">
                    <i class="fa fa-plus me-2"></i> Add Train
                </a>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card admin-card p-4">
                <i class="fa fa-users fa-3x text-info mb-3"></i>
                <h5>View Passengers</h5>
                <a href="view_bookings.php" class="btn btn-info btn-custom text-white">
                    <i class="fa fa-eye me-2"></i> View All
                </a>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card admin-card p-4">
                <h5 class="fw-bold"><i class="fa fa-chart-line me-2"></i> System Summary</h5>
                <hr>
            </div>
        </div>
    </div>
</div>

</body>
</html>