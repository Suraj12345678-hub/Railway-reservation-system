<?php
include('../includes/db.php');
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../includes/login.php");
    exit();
}

$train_id   = isset($_GET['id'])   ? mysqli_real_escape_string($conn, $_GET['id'])   : '';
$coach      = isset($_GET['cls'])  ? mysqli_real_escape_string($conn, $_GET['cls'])  : '';
$travel_date= isset($_GET['date']) ? mysqli_real_escape_string($conn, $_GET['date']) : '';

if (!$train_id) {
    header("Location: search_trains.php");
    exit();
}

$query = mysqli_query($conn, "SELECT * FROM trains WHERE id='$train_id'");
$train = mysqli_fetch_assoc($query);

if (!$train) {
    header("Location: search_trains.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Details - Rail Reserv</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        .top-nav { background: #2f69ff; color: white; padding: 12px 20px; }
        .details-card { border-radius: 15px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.08); }
    </style>
</head>
<body>
<nav class="top-nav d-flex align-items-center mb-4">
    <a href="search_trains.php" class="text-white me-3 fs-5"><i class="fa fa-arrow-left"></i></a>
    <h5 class="m-0 fw-bold">Passenger Details</h5>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Train Info Banner -->
            <div class="alert alert-info mb-3 py-2">
                <i class="fa fa-train me-2"></i>
                <b><?php echo htmlspecialchars($train['train_name']); ?></b> &nbsp;|&nbsp;
                Class: <b><?php echo htmlspecialchars($coach); ?></b> &nbsp;|&nbsp;
                Date: <b><?php echo date('d M Y', strtotime($travel_date)); ?></b>
            </div>

            <div class="card details-card p-4">
                <h5 class="fw-bold text-primary mb-3"><i class="fa fa-user me-2"></i>Passenger Information</h5>
                <form action="process_payment.php" method="POST">
                    <input type="hidden" name="train_id" value="<?php echo $train_id; ?>">
                    <input type="hidden" name="coach"    value="<?php echo $coach; ?>">
                    <input type="hidden" name="date"     value="<?php echo $travel_date; ?>">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Full Name</label>
                        <input type="text" name="passenger_name" class="form-control" placeholder="Name as per Aadhaar" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-bold">Age</label>
                            <input type="number" name="age" class="form-control" min="1" max="120" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-bold">Gender</label>
                            <select name="gender" class="form-select">
                                <option>Male</option>
                                <option>Female</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-bold">Country</label>
                            <select name="country" class="form-select">
                                <option>India</option>
                                <option>USA</option>
                                <option>UK</option>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-bold">Aadhaar Number</label>
                            <input type="text" name="aadhaar" class="form-control" pattern="[0-9]{12}" maxlength="12" placeholder="12 digit Aadhaar" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Mobile Number</label>
                            <input type="text" name="mobile" class="form-control" pattern="[0-9]{10}" maxlength="10" placeholder="10 digit mobile" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill">
                        <i class="fa fa-credit-card me-2"></i>PROCEED TO PAYMENT
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
