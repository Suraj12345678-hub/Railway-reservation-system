<?php
include('../includes/db.php');
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../includes/login.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: passenger_dashboard.php");
    exit();
}

$u_id     = $_SESSION['user_id'];
$pnr      = rand(1000000000, 9999999999);
$p_name   = mysqli_real_escape_string($conn, $_POST['p_name']   ?? '');
$p_age    = mysqli_real_escape_string($conn, $_POST['p_age']    ?? '');
$p_gender = mysqli_real_escape_string($conn, $_POST['p_gender'] ?? '');
$t_id     = mysqli_real_escape_string($conn, $_POST['t_id']     ?? '');
$coach    = mysqli_real_escape_string($conn, $_POST['coach']    ?? '');
$date     = mysqli_real_escape_string($conn, $_POST['date']     ?? '');
$fare     = mysqli_real_escape_string($conn, $_POST['fare']     ?? 0);

// Check seat availability
$check   = mysqli_query($conn, "SELECT COUNT(*) as booked FROM bookings WHERE train_id='$t_id' AND travel_date='$date'");
$seat    = mysqli_fetch_assoc($check);
$status  = ($seat['booked'] >= 60) ? 'Waiting' : 'Confirmed';

$sql = "INSERT INTO bookings (pnr, user_id, train_id, passenger_name, passenger_age, passenger_gender, coach, travel_date, status)
        VALUES ('$pnr', '$u_id', '$t_id', '$p_name', '$p_age', '$p_gender', '$coach', '$date', '$status')";

$success = mysqli_query($conn, $sql);

// Get train info for display
$train_res = mysqli_query($conn, "SELECT * FROM trains WHERE id='$t_id'");
$train     = mysqli_fetch_assoc($train_res);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed - Rail Reserv</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        .ticket-card { border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        .pnr-display { background: #2f69ff; color: white; border-radius: 10px; padding: 15px; text-align: center; }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <?php if ($success): ?>
            <div class="text-center mb-4">
                <i class="fa fa-check-circle fa-4x text-success mb-2"></i>
                <h4 class="fw-bold">Booking <?php echo $status; ?>!</h4>
                <p class="text-muted">Your ticket has been booked successfully.</p>
            </div>

            <div class="card ticket-card p-4 mb-3">
                <div class="pnr-display mb-3">
                    <div class="small">PNR Number</div>
                    <h3 class="fw-bold m-0 letter-spacing"><?php echo $pnr; ?></h3>
                </div>
                <div class="row g-2">
                    <div class="col-6">
                        <div class="text-muted small">Passenger</div>
                        <div class="fw-bold"><?php echo htmlspecialchars($p_name); ?></div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Status</div>
                        <span class="badge <?php echo $status=='Confirmed' ? 'bg-success' : 'bg-warning text-dark'; ?> fs-6"><?php echo $status; ?></span>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Train</div>
                        <div class="fw-bold"><?php echo htmlspecialchars($train['train_name'] ?? 'N/A'); ?></div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Class</div>
                        <div class="fw-bold"><?php echo htmlspecialchars($coach); ?></div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">From</div>
                        <div class="fw-bold"><?php echo htmlspecialchars($train['source_station'] ?? ''); ?></div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">To</div>
                        <div class="fw-bold"><?php echo htmlspecialchars($train['destination_station'] ?? ''); ?></div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Date</div>
                        <div class="fw-bold"><?php echo date('d M Y', strtotime($date)); ?></div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Amount Paid</div>
                        <div class="fw-bold text-success">₹<?php echo $fare; ?></div>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="text-center p-4">
                <i class="fa fa-times-circle fa-4x text-danger mb-3"></i>
                <h5>Booking Failed</h5>
                <p class="text-muted">Something went wrong. Please try again.</p>
                <p class="text-danger small"><?php echo mysqli_error($conn); ?></p>
            </div>
            <?php endif; ?>

            <div class="d-grid gap-2">
                <a href="my_bookings.php" class="btn btn-primary fw-bold">
                    <i class="fa fa-list me-2"></i>View My Bookings
                </a>
                <a href="passenger_dashboard.php" class="btn btn-outline-secondary">
                    <i class="fa fa-home me-2"></i>Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
