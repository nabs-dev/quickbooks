<?php
session_start();
if (!isset($_SESSION["user"])) {
    echo "<script>window.location.href='index.php';</script>";
    exit();
}
include 'db.php';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client = $_POST['client'];
    $amount = $_POST['amount'];
    $due = $_POST['due_date'];
    $user = $_SESSION['user'];

    $stmt = $conn->prepare("INSERT INTO invoices (client, amount, due_date, user) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $client, $amount, $due, $user);
    if ($stmt->execute()) {
        $msg = "Invoice added successfully!";
    } else {
        $msg = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Invoice</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f3f6f9;
      padding: 40px;
    }
    .box {
      background: white;
      max-width: 500px;
      margin: auto;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    h2 {
      margin-bottom: 20px;
      color: #0077cc;
      text-align: center;
    }
    input[type="text"], input[type="number"], input[type="date"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
    }
    button {
      width: 100%;
      background: #0077cc;
      color: white;
      border: none;
      padding: 12px;
      font-size: 16px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
    }
    button:hover {
      background: #005fa3;
    }
    .msg {
      text-align: center;
      margin-top: 15px;
      color: green;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="box">
    <h2>Add New Invoice</h2>
    <form method="post">
      <input type="text" name="client" placeholder="Client Name" required>
      <input type="number" name="amount" placeholder="Amount" required>
      <input type="date" name="due_date" required>
      <button type="submit">Add Invoice</button>
    </form>
    <?php if ($msg): ?>
      <div class="msg"><?= $msg ?></div>
    <?php endif; ?>
  </div>
</body>
</html>
