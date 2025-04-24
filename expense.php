<?php
session_start();
if (!isset($_SESSION["user"])) echo "<script>window.location.href='index.php';</script>";
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cat = $_POST["category"];
    $amount = $_POST["amount"];
    $user = $_SESSION["user"];
    $conn->query("INSERT INTO expenses (category, amount, user) VALUES ('$cat', '$amount', '$user')");
    echo "<script>alert('Expense added!'); window.location.href='dashboard.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Expense</title>
  <style>
    body { font-family:sans-serif; background:#eee; padding:20px; }
    form { background:white; padding:20px; border-radius:10px; max-width:400px; margin:auto; box-shadow:0 0 10px rgba(0,0,0,0.2); }
    input, select { width:100%; padding:10px; margin:10px 0; border:1px solid #ccc; border-radius:5px; }
    button { padding:10px; background:#dc3545; color:white; border:none; border-radius:5px; width:100%; }
  </style>
</head>
<body>
  <form method="POST">
    <h2>Add Expense</h2>
    <select name="category" required>
      <option value="">Select Category</option>
      <option>Rent</option>
      <option>Utilities</option>
      <option>Supplies</option>
      <option>Other</option>
    </select>
    <input type="number" name="amount" placeholder="Amount (Rs)" required>
    <button type="submit">Add Expense</button>
  </form>
</body>
</html>
