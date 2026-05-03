<?php
include('../includes/db.php');
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../includes/login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$message = '';

if (isset($_POST['confirm_cancel'])) {
    $pnr = mysqli_real_escape_string($conn, trim($_POST['pnr_no']));
    $check = mysqli_query($conn, "SELECT * FROM bookings WHERE pnr='$pnr' AND user_id='$user_id' AND status != 'Cancelled'");
    if ($check && mysqli_num_rows($check) > 0) {
        if (mysqli_query($conn, "UPDATE bookings SET status='Cancelled' WHERE pnr='$pnr' AND user_id='$user_id'")) {
            $message = "<div class='alert alert-success'><i class='fa fa-check-circle me-2'></i>Ticket (PNR: $pnr) cancelled successfully. Refund will be processed in 5-7 days.</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error updating database.</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'><i class='fa fa-exclamation-triangle me-2'></i>Invalid PNR or ticket already cancelled.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Ticket - Rail Reserv</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        .top-nav { background: #2f69ff; color: white; padding: 12px 20px; }
        .cancel-card { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.08); }
    </style>
</head>
<body>
<nav class="top-nav d-flex align-items-center mb-4">
    <a href="passenger_dashboard.php" class="text-white me-3 fs-5"><i class="fa fa-arrow-left"></i></a>
    <h5 class="m-0 fw-bold">Cancel Ticket</h5>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card cancel-card p-4">
                <div class="text-center mb-3">
                    <i class="fa fa-times-circle fa-3x text-danger mb-2"></i>
                    <h5 class="fw-bold">Ticket Cancellation</h5>
                    <p class="text-muted small">Enter your PNR to cancel the ticket.</p>
                </div>

                <?php echo $message; ?>

                <form method="POST" onsubmit="return confirm('Are you sure you want to cancel this ticket? This cannot be undone.');">
                    <div class="mb-3">
                        <label class="form-label fw-bold">PNR Number</label>
                        <input type="text" name="pnr_no" class="form-control form-control-lg text-center fw-bold"
                               placeholder="Enter 10-digit PNR" pattern="[0-9]{10}" maxlength="10" required>
                    </div>
                    <button type="submit" name="confirm_cancel" class="btn btn-danger w-100 fw-bold py-2">
                        <i class="fa fa-trash me-2"></i>CANCEL TICKET
                    </button>
                </form>
                <hr>
                <a href="my_bookings.php" class="btn btn-outline-secondary w-100">
                    <i class="fa fa-list me-2"></i>View My Bookings
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
