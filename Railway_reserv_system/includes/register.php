<?php include('db.php');
session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rail Reserv - Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #2c3e50; color: white; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .card { border-radius: 20px; background: #eef2f7; color: #333; }
        .btn-rail { background-color: #87ceeb; border: none; border-radius: 20px; padding: 10px 30px; }
    </style>
</head>
<body>
<div class="container d-flex flex-column align-items-center justify-content-center vh-100">
    <h2 class="mb-4">Rail Reserv 🚂</h2>
    
    <div class="card p-4 shadow" style="width: 400px;">
        <h5 class="text-center mb-3"> Passenger Sign Up</h5>
        <form method="POST">
            <div class="mb-3">
                <input type="text" name="name" class="form-control mb-3" placeholder="Full Name" required>
            </div>
            <div class="mb-3">
            <input type="text" name="mobile" class="form-control mb-3"pattern="[0-9]{10}"maxlenght="10" placeholder="Enter 10 digit mobile number" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="mb-3">
            <label class="form-label fw-bold"> User Role:</label>
             <select name="role" class="form-select" required>
             <option value="Passenger">Passenger</option>
    </select>
</div> 
            <button type="submit" name="register" class="btn btn-rail w-100">Register</button>
        </form>
        <p class="mt-3 text-center">Already have an account? <a href="login.php">Login</a></p>
    </div>
</div>

<?php
if(isset($_POST['register'])){
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

    $checkQuery = "SELECT * FROM users WHERE mobile = '$mobile'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if(mysqli_num_rows($checkResult) > 0){
        echo "<script>alert('This no was already registered!');</script>";
    } else {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $sql = "INSERT INTO users (name, mobile, password, role) VALUES ('$name', '$mobile', '$hashed_pass', '$role')";
        
        if(mysqli_query($conn, $sql)){
            echo "<script>
                    alert('Registration Successful!');
                    window.location.href='login.php'; 
                  </script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>
</body>
</html>