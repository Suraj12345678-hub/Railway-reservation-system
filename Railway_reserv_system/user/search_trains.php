<?php
include('../includes/db.php');
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../includes/login.php");
    exit();
}

$from = isset($_GET['from']) ? mysqli_real_escape_string($conn, trim($_GET['from'])) : '';
$to   = isset($_GET['to'])   ? mysqli_real_escape_string($conn, trim($_GET['to']))   : '';
$date = isset($_GET['date']) ? mysqli_real_escape_string($conn, $_GET['date'])        : date('Y-m-d');

function calculateDuration($dep, $arr) {
    $start = new DateTime($dep);
    $end   = new DateTime($arr);
    if ($end < $start) $end->modify('+1 day');
    $diff  = $start->diff($end);
    return $diff->format('%h h %i min');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Trains - Rail Reserv</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        .top-nav { background: #2f69ff; color: white; padding: 12px 20px; }
        .search-bar { background: white; padding: 15px 0; border-bottom: 1px solid #ddd; position: sticky; top: 0; z-index: 999; }
        .train-card { border: none; border-radius: 15px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.07); overflow: hidden; }
        .time-display { font-size: 26px; font-weight: 800; color: #1a1a4b; }
        .station-name { font-size: 13px; font-weight: 600; color: #555; }
        .coach-container { display: flex; gap: 10px; padding: 15px; background: #fdfdfd; border-top: 1px solid #f0f0f0; flex-wrap: wrap; }
        .coach-box { flex: 1; min-width: 80px; border: 1px solid #eee; border-radius: 12px; padding: 12px; cursor: pointer; text-decoration: none; color: inherit; text-align: center; transition: 0.2s; }
        .coach-box:hover { border-color: #2f69ff; background: #f0f6ff; color: inherit; }
        .status-green { color: #2ecc71; font-weight: bold; font-size: 11px; }
        .status-orange { color: #f39c12; font-weight: bold; font-size: 11px; }
    </style>
</head>
<body>

<nav class="top-nav d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        <a href="passenger_dashboard.php" class="text-white me-3 fs-5"><i class="fa fa-arrow-left"></i></a>
        <h5 class="m-0 fw-bold">Rail Reserv</h5>
    </div>
    <span class="small fw-bold"><i class="fa fa-clock me-1"></i> <span id="live-clock"></span></span>
</nav>

<div class="search-bar">
    <div class="container">
        <form action="search_trains.php" method="GET" class="row g-2 align-items-end">
            <div class="col-md-3 col-6">
                <label class="small text-muted fw-bold mb-1">From</label>
                <input type="text" name="from" class="form-control" value="<?php echo htmlspecialchars($from); ?>" placeholder="e.g. Pune" required>
            </div>
            <div class="col-md-3 col-6">
                <label class="small text-muted fw-bold mb-1">To</label>
                <input type="text" name="to" class="form-control" value="<?php echo htmlspecialchars($to); ?>" placeholder="e.g. Mumbai" required>
            </div>
            <div class="col-md-3 col-6">
                <label class="small text-muted fw-bold mb-1">Date</label>
                <input type="date" name="date" class="form-control" value="<?php echo $date; ?>">
            </div>
            <div class="col-md-3 col-6">
                <button type="submit" class="btn btn-primary w-100 fw-bold">
                    <i class="fa fa-search me-1"></i> Search
                </button>
            </div>
        </form>
    </div>
</div>

<div class="container mt-4">
    <?php if ($from && $to): ?>
        <?php
        $sql = "SELECT * FROM trains WHERE source_station LIKE '%$from%' AND destination_station LIKE '%$to%'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0):
            echo "<p class='text-muted mb-3'>Trains from <b>" . htmlspecialchars($from) . "</b> to <b>" . htmlspecialchars($to) . "</b> on <b>" . date('d M Y', strtotime($date)) . "</b></p>";
            while ($row = mysqli_fetch_assoc($result)):
                $duration = calculateDuration($row['departure_time'], $row['arrival_time']);
        ?>
        <div class="card train-card">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <span class="badge bg-primary rounded-pill mb-1">Superfast</span>
                        <h6 class="fw-bold m-0"><?php echo htmlspecialchars($row['train_name']); ?> <span class="text-muted">#<?php echo htmlspecialchars($row['train_number']); ?></span></h6>
                    </div>
                </div>
                <div class="row align-items-center text-center">
                    <div class="col-4 text-start">
                        <div class="time-display"><?php echo date("H:i", strtotime($row['departure_time'])); ?></div>
                        <div class="station-name"><?php echo htmlspecialchars($row['source_station']); ?></div>
                    </div>
                    <div class="col-4 text-center">
                        <div class="text-muted small"><?php echo $duration; ?></div>
                        <div style="border-top: 2px dashed #ccc; margin: 4px 0;"></div>
                        <i class="fa fa-train text-primary"></i>
                    </div>
                    <div class="col-4 text-end">
                        <div class="time-display"><?php echo date("H:i", strtotime($row['arrival_time'])); ?></div>
                        <div class="station-name"><?php echo htmlspecialchars($row['destination_station']); ?></div>
                    </div>
                </div>
            </div>
            <div class="coach-container">
                <a href="book_ticket.php?id=<?php echo $row['id']; ?>&cls=SL&date=<?php echo urlencode($date); ?>" class="coach-box">
                    <div class="fw-bold">SL</div>
                    <div>₹<?php echo $row['fare']; ?></div>
                    <div class="status-green">AVAILABLE</div>
                </a>
                <a href="book_ticket.php?id=<?php echo $row['id']; ?>&cls=3A&date=<?php echo urlencode($date); ?>" class="coach-box">
                    <div class="fw-bold">3A</div>
                    <div>₹<?php echo $row['fare']+350; ?></div>
                    <div class="status-orange">WL 12</div>
                </a>
                <a href="book_ticket.php?id=<?php echo $row['id']; ?>&cls=2A&date=<?php echo urlencode($date); ?>" class="coach-box">
                    <div class="fw-bold">2A</div>
                    <div>₹<?php echo $row['fare']+700; ?></div>
                    <div class="status-green">AVAILABLE</div>
                </a>
                <a href="book_ticket.php?id=<?php echo $row['id']; ?>&cls=CC&date=<?php echo urlencode($date); ?>" class="coach-box">
                    <div class="fw-bold">CC</div>
                    <div>₹<?php echo $row['fare']+150; ?></div>
                    <div class="status-green">AVAILABLE</div>
                </a>
            </div>
        </div>
        <?php endwhile; ?>
        <?php else: ?>
            <div class="text-center p-5 bg-white rounded shadow-sm">
                <i class="fa fa-train fa-3x text-muted mb-3"></i>
                <h5>No trains found!</h5>
                <p class="text-muted">Try different station names or date.</p>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="text-center p-5 bg-white rounded shadow-sm">
            <i class="fa fa-search fa-3x text-primary mb-3"></i>
            <h5>Search for Trains</h5>
            <p class="text-muted">Enter source and destination station above to find trains.</p>
        </div>
    <?php endif; ?>
</div>

<script>
    function updateClock() { document.getElementById('live-clock').innerText = new Date().toLocaleTimeString(); }
    setInterval(updateClock, 1000); updateClock();
</script>
</body>
</html>
