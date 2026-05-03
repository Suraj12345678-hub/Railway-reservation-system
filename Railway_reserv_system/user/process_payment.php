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

$p_name  = mysqli_real_escape_string($conn, $_POST['passenger_name'] ?? '');
$p_age   = mysqli_real_escape_string($conn, $_POST['age']            ?? '');
$p_gender= mysqli_real_escape_string($conn, $_POST['gender']         ?? '');
$t_id    = mysqli_real_escape_string($conn, $_POST['train_id']       ?? '');
$coach   = mysqli_real_escape_string($conn, $_POST['coach']          ?? '');
$date    = mysqli_real_escape_string($conn, $_POST['date']           ?? '');

$res    = mysqli_query($conn, "SELECT * FROM trains WHERE id='$t_id'");
$train  = mysqli_fetch_assoc($res);
$fare   = $train['fare'] ?? 0;

// Adjust fare by class
if ($coach == '3A') $fare += 350;
elseif ($coach == '2A') $fare += 700;
elseif ($coach == 'CC') $fare += 150;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - Rail Reserv</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        .top-nav { background: #2f69ff; color: white; padding: 12px 20px; }
        .pay-card { border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); }
        .method-btn { border: 2px solid #e0e0e0; border-radius: 12px; padding: 15px; cursor: pointer; transition: 0.2s; background: white; width: 100%; text-align: left; margin-bottom: 10px; }
        .method-btn:hover { border-color: #2f69ff; background: #f0f6ff; }
    </style>
</head>
<body>
<nav class="top-nav d-flex align-items-center mb-4">
    <a href="javascript:history.back()" class="text-white me-3 fs-5"><i class="fa fa-arrow-left"></i></a>
    <h5 class="m-0 fw-bold">Payment</h5>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card pay-card p-4 mb-3">
                <h6 class="text-muted fw-bold mb-3">BOOKING SUMMARY</h6>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">Train</span>
                    <span class="fw-bold"><?php echo htmlspecialchars($train['train_name'] ?? 'N/A'); ?></span>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">Passenger</span>
                    <span class="fw-bold"><?php echo htmlspecialchars($p_name); ?></span>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">Class</span>
                    <span class="fw-bold"><?php echo htmlspecialchars($coach); ?></span>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">Date</span>
                    <span class="fw-bold"><?php echo date('d M Y', strtotime($date)); ?></span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span class="fw-bold fs-5">Total Amount</span>
                    <span class="fw-bold fs-4 text-success">₹<?php echo $fare; ?></span>
                </div>
            </div>

            <div class="card pay-card p-4">
                <h6 class="text-muted fw-bold mb-3">SELECT PAYMENT METHOD</h6>
                <form action="confirm_booking.php" method="POST">
                    <input type="hidden" name="p_name"   value="<?php echo htmlspecialchars($p_name); ?>">
                    <input type="hidden" name="p_age"    value="<?php echo htmlspecialchars($p_age); ?>">
                    <input type="hidden" name="p_gender" value="<?php echo htmlspecialchars($p_gender); ?>">
                    <input type="hidden" name="t_id"     value="<?php echo $t_id; ?>">
                    <input type="hidden" name="coach"    value="<?php echo htmlspecialchars($coach); ?>">
                    <input type="hidden" name="date"     value="<?php echo htmlspecialchars($date); ?>">
                    <input type="hidden" name="fare"     value="<?php echo $fare; ?>">

                    <button type="submit" name="payment_method" value="upi" class="method-btn">
                        <i class="fa fa-mobile-alt text-primary me-2 fs-5"></i>
                        <b>UPI / GPay / PhonePe</b>
                        <div class="small text-muted">Instant payment via UPI</div>
                    </button>
                    <button type="submit" name="payment_method" value="card" class="method-btn">
                        <i class="fa fa-credit-card text-success me-2 fs-5"></i>
                        <b>Debit / Credit Card</b>
                        <div class="small text-muted">Visa, Mastercard, RuPay</div>
                    </button>
                    <button type="submit" name="payment_method" value="netbanking" class="method-btn">
                        <i class="fa fa-university text-warning me-2 fs-5"></i>
                        <b>Net Banking</b>
                        <div class="small text-muted">All major banks supported</div>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
