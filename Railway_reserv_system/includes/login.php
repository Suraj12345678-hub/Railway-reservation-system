<?php include('db.php'); 
session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rail Reserv - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #2c3e50; color: white; }
        .login-card { background: #eef2f7; border-radius: 25px; color: #333; width: 450px; }
        .role-box { border: 1px solid #ddd; border-radius: 10px; padding: 15px; cursor: pointer; text-align: center; background: white; }
        .role-box:hover { border-color: #87ceeb; }
        input[type="radio"] { display: none; }
        input[type="radio"]:checked + label .role-box { border: 2px solid #2ecc71; background: #f0fff4; }
    </style>
</head>
<body>
<div class="container d-flex flex-column align-items-center justify-content-center vh-100">
    <h2 class="mb-4">Rail Reserv 🚂</h2>
    <div class="login-card p-5 shadow">
        <h5 class="text-center mb-4">Login with Mobile</h5>
        <form method="POST">
            <input type="text" name="mobile" class="form-control mb-3"pattern="[0-9]{10}"maxlenght="10" placeholder="Enter 10 digit mobile number" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
            
            <p class="text-center small">Select your role to continue:</p>
            <div class="d-flex justify-content-between mb-4">
                <input type="radio" name="role" value="Passenger" id="pass" checked>
                <label for="pass" class="w-100 me-2">
                    <div class="role-box">👤 Passenger</div>
                </label>
                
                <input type="radio" name="role" value="Administrator" id="admin">
                <label for="admin" class="w-100 ms-2">
                    <div class="role-box">🔑 Admin</div>
                </label>
            </div>
            <button type="submit" name="login" class="btn btn-info w-100 text-white rounded-pill">Rail Login</button>
        </form>
         <p class="mt-3 text-center">Already not have an account? <a href="register.php">Sign Up</a></p>
    </div>
</div>

<?php
if(isset($_POST['login'])){
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    $query = "SELECT * FROM users WHERE mobile='$mobile' AND role='$role'";
    $result = mysqli_query($conn, $query);

    if($row = mysqli_fetch_assoc($result)){
        if(password_verify($password, $row['password'])){
            $_SESSION['name'] = $row['name']; 
            $_SESSION['user'] = $row['mobile'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['user_id'] = $row['id'];
            echo "<script>
                    alert('Login Successful!');
                    window.location.href='dashboard.php';
                  </script>";
        } else {
        
            echo "<script>alert('Wrong Password! Please try again.');</script>";
        }
    } else {
        echo "<script>alert('User not found or Role mismatch!');</script>";
    }
}
?>
</body>
</html>