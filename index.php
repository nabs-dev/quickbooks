<?php
session_start();
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $pass = $_POST["password"];
    $result = $conn->query("SELECT * FROM users WHERE email='$email' AND password='$pass'");
    if ($result->num_rows > 0) {
        $_SESSION["user"] = $email;
        echo "<script>window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Invalid credentials');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - QuickBooks Clone</title>
    <style>
        body { font-family:sans-serif; background:#f4f4f4; display:flex; align-items:center; justify-content:center; height:100vh; }
        .login-box { background:white; padding:30px; border-radius:10px; box-shadow:0 0 15px rgba(0,0,0,0.2); width:300px; }
        input { width:100%; padding:10px; margin:10px 0; border:1px solid #ccc; border-radius:5px; }
        button { width:100%; padding:10px; background:#28a745; color:white; border:none; border-radius:5px; font-weight:bold; }
        a { display:block; text-align:center; margin-top:10px; color:#007bff; }
    </style>
</head>
<body>
    <form class="login-box" method="POST">
        <h2>Login</h2>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
        <a href="signup.php">Don't have an account? Sign up</a>
    </form>
</body>
</html>
