<?php
include('../includes/db.php');
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../includes/login.php");
    exit();
}

$result = null;
$pnr_searched = '';

if (isset($_POST['pnr'])) {
    $pnr = mysqli_real_escape_string($conn, trim($_POST['pnr']));
    $pnr_searched = $pnr;
    $res = mysqli_query($conn, "SELECT b.*, t.train_name, t.train_number, t.source_station, t.destination_station, t.departure_time, t.arrival_time FROM bookings b LEFT JOIN trains t ON b.train_id = t.id WHERE b.pnr = '$pnr'");
    if ($res && mysqli_num_rows($res) > 0) {
        $result = mysqli_fetch_assoc($res);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PNR Status - Rail Reserv</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        .top-nav { background: #2f69ff; color: white; padding: 12px 20px; }
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.07); }
        .status-badge { padding: 8px 18px; border-radius: 20px; font-weight: bold; font-size: 14px; }
        .status-confirmed { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        .status-pending { background: #fff3cd; color: #856404; }
    </style>
</head>
<body>

<nav class="top-nav d-flex align-items-center">
    <a href="passenger_dashboard.php" class="text-white me-3 fs-5"><i class="fa fa-arrow-left"></i></a>
    <h5 class="m-0 fw-bold">PNR Status</h5>
</nav>

<div class="container mt-4">
    <div class="card p-4 mb-4">
        <h6 class="fw-bold mb-3 text-muted">Enter PNR Number</h6>
        <form method="POST" action="pnr_status.php">
            <div class="input-group">
                <input type="text" name="pnr" class="form-control form-control-lg" 
                       placeholder="Enter 10-digit PNR" pattern="[0-9]{10}" maxlength="10"
                       value="<?php echo htmlspecialchars($pnr_searched); ?>" required>
                <button type="submit" class="btn btn-primary px-4 fw-bold">
                    <i class="fa fa-search me-1"></i> Check
                </button>
            </div>
        </form>
    </div>

    <?php if (isset($_POST['pnr'])): ?>
        <?php if ($result): ?>
            <div class="card p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <div class="text-muted small">PNR Number</div>
                        <h5 class="fw-bold m-0"><?php echo htmlspecialchars($result['pnr']); ?></h5>
                    </div>
                    <?php
                        $status = $result['status'] ?? 'Pending';
                        $badge = 'status-pending';
                        if (strtolower($status) == 'confirmed') $badge = 'status-confirmed';
                        if (strtolower($status) == 'cancelled') $badge = 'status-cancelled';
                    ?>
                    <span class="status-badge <?php echo $badge; ?>"><?php echo htmlspecialchars($status); ?></span>
                </div>
                <hr>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="text-muted small">Train</div>
                        <div class="fw-bold"><?php echo htmlspecialchars($result['train_name'] ?? 'N/A'); ?></div>
                        <div class="text-muted small">#<?php echo htmlspecialchars($result['train_number'] ?? ''); ?></div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Coach Class</div>
                        <div class="fw-bold"><?php echo htmlspecialchars($result['coach'] ?? $result['class'] ?? 'N/A'); ?></div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">From</div>
                        <div class="fw-bold"><?php echo htmlspecialchars($result['source_station'] ?? 'N/A'); ?></div>
                        <div class="text-muted small"><?php echo $result['departure_time'] ? date('H:i', strtotime($result['departure_time'])) : ''; ?></div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">To</div>
                        <div class="fw-bold"><?php echo htmlspecialchars($result['destination_station'] ?? 'N/A'); ?></div>
                        <div class="text-muted small"><?php echo $result['arrival_time'] ? date('H:i', strtotime($result['arrival_time'])) : ''; ?></div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Passenger</div>
                        <div class="fw-bold"><?php echo htmlspecialchars($result['passenger_name'] ?? 'N/A'); ?></div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Travel Date</div>
                        <div class="fw-bold"><?php echo isset($result['travel_date']) ? date('d M Y', strtotime($result['travel_date'])) : 'N/A'; ?></div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="card p-4 text-center">
                <i class="fa fa-times-circle fa-3x text-danger mb-3"></i>
                <h5>PNR Not Found</h5>
                <p class="text-muted">No booking found for PNR: <b><?php echo htmlspecialchars($pnr_searched); ?></b><br>Please check the number and try again.</p>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

</body>
</html>
