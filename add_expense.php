<?php
// Show all errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION["user"])) {
    echo "<script>window.location.href='index.php';</script>";
    exit();
}
include 'db.php';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $user = $_SESSION['user'];

    // SQL INSERT with error handling
    $stmt = $conn->prepare("INSERT INTO expenses (category, amount, date, user) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("siss", $category, $amount, $date, $user);
        if ($stmt->execute()) {
            $msg = "✅ Expense added successfully!";
        } else {
            $msg = "❌ Execute failed: " . $stmt->error;
        }
    } else {
        $msg = "❌ Prepare failed: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Expense</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #eef3f9;
      padding: 50px;
    }
    .box {
      background: #fff;
      max-width: 500px;
      margin: auto;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }
    h2 {
      color: #d9534f;
      text-align: center;
      margin-bottom: 25px;
    }
    input[type="text"], input[type="number"], input[type="date"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 18px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 15px;
    }
    button {
      width: 100%;
      padding: 12px;
      background-color: #d9534f;
      color: white;
      font-size: 16px;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }
    button:hover {
      background-color: #c9302c;
    }
    .msg {
      margin-top: 20px;
      text-align: center;
      font-weight: bold;
      color: green;
    }
  </style>
</head>
<body>
  <div class="box">
    <h2>Add Expense</h2>
    <form method="POST">
      <input type="text" name="category" placeholder="Expense Category" required>
      <input type="number" name="amount" placeholder="Amount" required>
      <input type="date" name="date" required>
      <button type="submit">Add Expense</button>
    </form>
    <?php if ($msg): ?>
      <div class="msg"><?= $msg ?></div>
    <?php endif; ?>
  </div>
</body>
</html>
