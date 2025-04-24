<?php
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $pass = $_POST["password"];
    $conn->query("INSERT INTO users (email, password) VALUES ('$email', '$pass')");
    echo "<script>alert('Signup successful!'); window.location.href='index.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Signup - QuickBooks Clone</title>
    <style>
        body { font-family:sans-serif; background:#eef; display:flex; align-items:center; justify-content:center; height:100vh; }
        .signup-box { background:white; padding:30px; border-radius:10px; box-shadow:0 0 15px rgba(0,0,0,0.2); width:300px; }
        input { width:100%; padding:10px; margin:10px 0; border:1px solid #ccc; border-radius:5px; }
        button { width:100%; padding:10px; background:#007bff; color:white; border:none; border-radius:5px; font-weight:bold; }
        a { display:block; text-align:center; margin-top:10px; color:#28a745; }
    </style>
</head>
<body>
    <form class="signup-box" method="POST">
        <h2>Signup</h2>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Create Account</button>
        <a href="index.php">Already have an account? Login</a>
    </form>
</body>
</html>
