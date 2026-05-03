<?php
include('../includes/db.php');
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../includes/login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

$booking = null;
$res = mysqli_query($conn, "SELECT b.pnr, t.train_name, t.source_station, t.destination_station
                             FROM bookings b
                             JOIN trains t ON b.train_id = t.id
                             WHERE b.user_id='$user_id' AND b.status='Confirmed'
                             ORDER BY b.id DESC LIMIT 1");
if ($res) $booking = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Station Alarm - Rail Reserv</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        .top-nav { background: #2f69ff; color: white; padding: 12px 20px; }
        .alarm-card { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.08); }
    </style>
</head>
<body>
<nav class="top-nav d-flex align-items-center mb-4">
    <a href="passenger_dashboard.php" class="text-white me-3 fs-5"><i class="fa fa-arrow-left"></i></a>
    <h5 class="m-0 fw-bold"><i class="fa fa-bell me-2"></i>Smart Station Alarm</h5>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card alarm-card p-4">
                <div class="text-center mb-3">
                    <i class="fa fa-bell fa-3x text-primary mb-2"></i>
                    <h5 class="fw-bold">Station Alarm</h5>
                    <p class="text-muted small">Get alerted before your station arrives.</p>
                </div>

                <?php if ($booking): ?>
                <div class="alert alert-info py-2 small">
                    <b>Active Trip:</b> <?php echo htmlspecialchars($booking['train_name']); ?> (PNR: <?php echo $booking['pnr']; ?>)
                </div>

                <label class="form-label fw-bold">Select Station for Alarm</label>
                <select id="selected_station" class="form-select mb-3">
                    <option value="">-- Select Station --</option>
                    <option value="<?php echo htmlspecialchars($booking['source_station']); ?>"><?php echo htmlspecialchars($booking['source_station']); ?> (Source)</option>
                    <option value="Intermediate">Intermediate Station</option>
                    <option value="<?php echo htmlspecialchars($booking['destination_station']); ?>"><?php echo htmlspecialchars($booking['destination_station']); ?> (Destination)</option>
                </select>

                <button onclick="startTracking()" id="startBtn" class="btn btn-primary w-100 fw-bold py-2 mb-2">
                    <i class="fa fa-bell me-2"></i>SET ALARM
                </button>
                <button onclick="stopBeep()" id="stopBtn" class="btn btn-danger w-100 fw-bold py-2" style="display:none;">
                    <i class="fa fa-stop me-2"></i>STOP ALARM
                </button>
                <div id="alarm-status" class="text-center fw-bold mt-3"></div>

                <?php else: ?>
                <div class="text-center p-4">
                    <i class="fa fa-ticket-alt fa-3x text-muted mb-3"></i>
                    <p class="text-danger fw-bold">No confirmed tickets found.</p>
                    <a href="search_trains.php" class="btn btn-primary btn-sm">Book a Ticket First</a>
                </div>
                <?php endif; ?>

                <hr>
                <a href="passenger_dashboard.php" class="btn btn-outline-secondary w-100">Back to Dashboard</a>
            </div>
        </div>
    </div>
</div>

<audio id="beep">
    <source src="https://www.soundjay.com/buttons/beep-07a.mp3" type="audio/mpeg">
</audio>

<script>
let timer;
const beepSound = document.getElementById('beep');

function startTracking() {
    const station = document.getElementById('selected_station').value;
    if (!station) { alert("Please select a station first!"); return; }
    document.getElementById('startBtn').disabled = true;
    document.getElementById('alarm-status').innerHTML = '<i class="fa fa-spinner fa-spin text-primary me-2"></i>Tracking location for <b>' + station + '</b>...';
    timer = setTimeout(() => {
        document.getElementById('alarm-status').innerHTML = '<span class="text-danger"><i class="fa fa-bell me-2"></i>Wake up! <b>' + station + '</b> is arriving!</span>';
        document.getElementById('stopBtn').style.display = 'block';
        beepSound.loop = true;
        beepSound.play().catch(() => {});
    }, 5000);
}

function stopBeep() {
    beepSound.pause();
    beepSound.currentTime = 0;
    clearTimeout(timer);
    document.getElementById('startBtn').disabled = false;
    document.getElementById('stopBtn').style.display = 'none';
    document.getElementById('alarm-status').innerHTML = '<span class="text-success">Alarm stopped.</span>';
}
</script>
</body>
</html>
