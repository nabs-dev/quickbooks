<?php
session_start();
if (!isset($_SESSION["user"])) echo "<script>window.location.href='index.php';</script>";
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client = $_POST["client"];
    $amount = $_POST["amount"];
    $due = $_POST["due"];
    $user = $_SESSION["user"];
    $conn->query("INSERT INTO invoices (client, amount, due_date, user) VALUES ('$client', '$amount', '$due', '$user')");
    echo "<script>alert('Invoice added!'); window.location.href='dashboard.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Create Invoice</title>
  <style>
    body { font-family:sans-serif; background:#f5f5f5; padding:20px; }
    form { background:white; padding:20px; border-radius:10px; max-width:400px; margin:auto; box-shadow:0 0 10px rgba(0,0,0,0.2); }
    input { width:100%; padding:10px; margin:10px 0; border:1px solid #ccc; border-radius:5px; }
    button { padding:10px; background:#28a745; color:white; border:none; border-radius:5px; width:100%; }
  </style>
</head>
<body>
  <form method="POST">
    <h2>Create Invoice</h2>
    <input type="text" name="client" placeholder="Client Name" required>
    <input type="number" name="amount" placeholder="Amount (Rs)" required>
    <input type="date" name="due" required>
    <button type="submit">Add Invoice</button>
  </form>
</body>
</html>
