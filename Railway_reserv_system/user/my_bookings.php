<?php
include('../includes/db.php');
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../includes/login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - Rail Reserv</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f0f2f5; font-family: 'Segoe UI', sans-serif; padding-bottom: 80px; }
        .top-nav { background: #2f69ff; color: white; padding: 12px 20px; }
        .booking-card { border: none; border-radius: 12px; box-shadow: 0 3px 10px rgba(0,0,0,0.06); margin-bottom: 12px; }
        .bottom-nav { position: fixed; bottom: 0; width: 100%; background: #4f5156; display: flex; justify-content: space-around; padding: 12px 0; border-radius: 20px 20px 0 0; }
        .nav-item { color: rgba(255,255,255,0.7); text-align: center; text-decoration: none; font-size: 11px; }
        .nav-item.active { color: #fff; }
        .nav-item i { display: block; font-size: 20px; margin-bottom: 3px; }
    </style>
</head>
<body>
<nav class="top-nav d-flex align-items-center mb-3">
    <a href="passenger_dashboard.php" class="text-white me-3 fs-5"><i class="fa fa-arrow-left"></i></a>
    <h5 class="m-0 fw-bold">My Bookings</h5>
</nav>

<div class="container">
    <?php
    $query = "SELECT b.pnr, b.coach, b.travel_date, b.status, t.train_name, t.source_station, t.destination_station
              FROM bookings b
              JOIN trains t ON b.train_id = t.id
              WHERE b.user_id = '$user_id'
              ORDER BY b.id DESC";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0):
        while ($row = mysqli_fetch_assoc($result)):
            $badge = 'bg-success';
            if ($row['status'] == 'Cancelled') $badge = 'bg-danger';
            elseif ($row['status'] == 'Waiting') $badge = 'bg-warning text-dark';
    ?>
    <div class="card booking-card p-3">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <div class="fw-bold"><?php echo htmlspecialchars($row['train_name']); ?></div>
                <div class="text-muted small"><?php echo htmlspecialchars($row['source_station']); ?> → <?php echo htmlspecialchars($row['destination_station']); ?></div>
                <div class="text-muted small mt-1">
                    <i class="fa fa-calendar me-1"></i><?php echo date('d M Y', strtotime($row['travel_date'])); ?>
                    &nbsp;|&nbsp; Class: <b><?php echo htmlspecialchars($row['coach']); ?></b>
                </div>
                <div class="text-muted small">PNR: <b><?php echo $row['pnr']; ?></b></div>
            </div>
            <span class="badge <?php echo $badge; ?>"><?php echo $row['status']; ?></span>
        </div>
    </div>
    <?php endwhile; ?>
    <?php else: ?>
    <div class="text-center p-5 bg-white rounded shadow-sm">
        <i class="fa fa-ticket-alt fa-3x text-muted mb-3"></i>
        <h5>No Bookings Yet</h5>
        <p class="text-muted">You haven't booked any tickets yet.</p>
        <a href="search_trains.php" class="btn btn-primary">Search Trains</a>
    </div>
    <?php endif; ?>
</div>

<div class="bottom-nav">
    <a href="passenger_dashboard.php" class="nav-item">
        <i class="fa-solid fa-house"></i><span>Home</span>
    </a>
    <a href="my_bookings.php" class="nav-item active">
        <i class="fa-solid fa-briefcase"></i><span>Bookings</span>
    </a>
    <a href="pnr_status.php" class="nav-item">
        <i class="fa-solid fa-magnifying-glass"></i><span>PNR</span>
    </a>
    <a href="../includes/logout.php" class="nav-item">
        <i class="fa-solid fa-power-off"></i><span>Logout</span>
    </a>
</div>
</body>
</html>
