<?php
include('../includes/db.php');
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../includes/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rail Reserv - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #b5e9e3; font-family: 'Segoe UI', Roboto, sans-serif; color: #1a1a4b; }
        .header { padding: 20px; display: flex; justify-content: space-between; align-items: center; }
        .user-greeting { font-size: 14px; color: #6c757d; margin-bottom: 5px; }
        .user-name { font-size: 20px; font-weight: bold; color: #1a1a4b; text-transform: capitalize; }
        .section-title { font-weight: bold; font-size: 18px; margin: 20px 0; }
        .planner-card { border: none; border-radius: 15px; overflow: hidden; position: relative; height: 120px; }
        .planner-card img { width: 100%; height: 100%; object-fit: cover; filter: brightness(0.8); }
        .planner-label { position: absolute; bottom: 10px; left: 0; right: 0; text-align: center; color: white; font-weight: 500; }
        .offering-item { text-align: center; margin-bottom: 25px; text-decoration: none; color: inherit; display: block; }
        .icon-box { width: 65px; height: 65px; border-radius: 15px; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-size: 24px; transition: transform 0.2s; }
        .offering-item:hover .icon-box { transform: scale(1.1); }
        .offering-text { font-size: 12px; font-weight: 500; display: block; line-height: 1.2; }
        .bg-pink { background-color: #fff0f3; color: #ff4d6d; }
        .bg-green { background-color: #f0fff4; color: #2ecc71; }
        .bg-blue { background-color: #f0f7ff; color: #3498db; }
        .bg-yellow { background-color: #fff9db; color: #f1c40f; }
        .bg-purple { background-color: #f3f0ff; color: #9c27b0; }
        .bg-orange { background-color: #fff4e6; color: #e67e22; }
        .bottom-nav { position: fixed; bottom: 0; width: 100%; background: #4f5156; display: flex; justify-content: space-around; padding: 12px 0; border-radius: 20px 20px 0 0; }
        .nav-item { color: rgba(255,255,255,0.7); text-align: center; text-decoration: none; font-size: 11px; }
        .nav-item.active { color: #ffffff; }
        .nav-item i { display: block; font-size: 20px; margin-bottom: 3px; }
        body { padding-bottom: 80px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="logo">
            <h3 class="fw-bold m-0" style="color: #444;">Rail Reserv</h3>
        </div>
    </div>

    <div class="px-2">
        <div class="user-greeting">Hi, <?php echo isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'Guest'; ?>!</div>
        <h2 class="user-name">Where are you going today?</h2>
    </div>

    <h5 class="section-title px-2">Journey Planner</h5>
    <div class="row g-3 px-2">
        <div class="col-4">
            <div class="planner-card">
                <img src="https://images.unsplash.com/photo-1474487548417-781cb71495f3?auto=format&fit=crop&w=300&q=80" alt="Reserved">
                <div class="planner-label">Reserved</div>
            </div>
        </div>
        <div class="col-4">
            <div class="planner-card">
                <img src="https://images.unsplash.com/photo-1532105956690-db9140e11631?auto=format&fit=crop&w=300&q=80" alt="Unreserved">
                <div class="planner-label">Unreserved</div>
            </div>
        </div>
        <div class="col-4">
            <div class="planner-card">
                <img src="https://images.unsplash.com/photo-1551821427-0130f1465e6d?auto=format&fit=crop&w=300&q=80" alt="Platform">
                <div class="planner-label">Platform</div>
            </div>
        </div>
    </div>

    <h5 class="section-title px-2 mt-4">More Offerings</h5>
    <div class="row row-cols-4 px-2">
        <a href="search_trains.php" class="offering-item">
            <div class="icon-box bg-pink"><i class="fa-solid fa-route"></i></div>
            <span class="offering-text">Search<br>Trains</span>
        </a>
        <a href="food_order.php" class="offering-item">
            <div class="icon-box bg-green"><i class="fa fa-utensils"></i></div>
            <span class="offering-text">Order<br>Food</span>
        </a>
        <a href="station_alarm.php" class="offering-item">
            <div class="icon-box bg-blue"><i class="fa fa-bell"></i></div>
            <span class="offering-text">Station<br>Alarm</span>
        </a>
        <a href="cancel_ticket.php" class="offering-item">
            <div class="icon-box bg-yellow"><i class="fa fa-ticket-alt"></i></div>
            <span class="offering-text">Cancel<br>Ticket</span>
        </a>
    </div>
</div>

<div class="bottom-nav">
    <a href="passenger_dashboard.php" class="nav-item active">
        <i class="fa-solid fa-house"></i>
        <span>Home</span>
    </a>
       <a href="pnr_status.php" class="nav-item">
        <i class="fa fa-search"></i>
        <span>PNR Status</span>
    </a>

    <a href="my_bookings.php" class="nav-item">
        <i class="fa fa-list"></i>
        <span>My Bookings</span>
    </a>
    <a href="../includes/logout.php" class="nav-item">
        <i class="fa-solid fa-power-off"></i>
        <span>Logout</span>
    </a>
</div>
</body>
</html>
