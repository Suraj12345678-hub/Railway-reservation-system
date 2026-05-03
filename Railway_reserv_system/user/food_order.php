<?php
include('../includes/db.php');
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../includes/login.php");
    exit();
}

$msg = '';
if (isset($_POST['order_now'])) {
    $item_name = htmlspecialchars($_POST['food_name'] ?? '');
    $pnr       = htmlspecialchars($_POST['pnr_no']   ?? '');
    $msg = "<div class='alert alert-success'><i class='fa fa-check-circle me-2'></i>Your <b>$item_name</b> order has been placed for PNR: <b>$pnr</b>. It will be delivered at the next major station!</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Order - Rail Reserv</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        .top-nav { background: #2f69ff; color: white; padding: 12px 20px; }
        .food-card { border: none; border-radius: 12px; box-shadow: 0 3px 10px rgba(0,0,0,0.07); transition: 0.2s; }
        .food-card:hover { transform: translateY(-3px); }
    </style>
</head>
<body>
<nav class="top-nav d-flex align-items-center mb-4">
    <a href="passenger_dashboard.php" class="text-white me-3 fs-5"><i class="fa fa-arrow-left"></i></a>
    <h5 class="m-0 fw-bold"><i class="fa fa-utensils me-2"></i>Food on Track</h5>
</nav>

<div class="container">
    <?php if ($msg) echo $msg; ?>

    <div class="row g-3">
        <?php
        $res = mysqli_query($conn, "SELECT * FROM food_items");
        if ($res && mysqli_num_rows($res) > 0):
            while ($row = mysqli_fetch_assoc($res)):
                $badge_class = ($row['item_type'] == 'Veg') ? 'bg-success' : 'bg-danger';
        ?>
        <div class="col-md-4 col-6">
            <div class="card food-card p-3 h-100">
                <span class="badge <?php echo $badge_class; ?> mb-2" style="width:fit-content;"><?php echo htmlspecialchars($row['item_type']); ?></span>
                <h6 class="fw-bold"><?php echo htmlspecialchars($row['item_name']); ?></h6>
                <p class="text-success fw-bold mb-2">₹<?php echo $row['item_price']; ?></p>
                <form method="POST" class="mt-auto">
                    <input type="hidden" name="food_name" value="<?php echo htmlspecialchars($row['item_name']); ?>">
                    <input type="text" name="pnr_no" class="form-control form-control-sm mb-2" placeholder="Enter PNR" pattern="[0-9]{10}" maxlength="10" required>
                    <button type="submit" name="order_now" class="btn btn-warning btn-sm w-100 fw-bold">
                        <i class="fa fa-shopping-cart me-1"></i>Order Now
                    </button>
                </form>
            </div>
        </div>
        <?php endwhile; ?>
        <?php else: ?>
        <div class="col-12 text-center p-5 bg-white rounded shadow-sm">
            <i class="fa fa-utensils fa-3x text-muted mb-3"></i>
            <h5>No food items available</h5>
            <p class="text-muted">Please check back later.</p>
        </div>
        <?php endif; ?>
    </div>

    <p class="text-center text-muted small mt-4">*Meals will be delivered to your seat at the next major station.</p>
</div>
</body>
</html>
