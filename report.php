<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION["user"])) {
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

include 'db.php';

$user = $_SESSION["user"];

// Fetch total income
$income_result = $conn->query("SELECT SUM(amount) AS total_income FROM invoices WHERE user='$user'");
$income_row = $income_result->fetch_assoc();
$total_income = $income_row['total_income'] ?? 0;

// Fetch total expenses
$expense_result = $conn->query("SELECT SUM(amount) AS total_expense FROM expenses WHERE user='$user'");
$expense_row = $expense_result->fetch_assoc();
$total_expense = $expense_row['total_expense'] ?? 0;

// Calculate profit/loss
$net_total = $total_income - $total_expense;
$status = $net_total >= 0 ? "Profit" : "Loss";
?>

<!DOCTYPE html>
<html>
<head>
  <title>Financial Report</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f0f4f8;
      padding: 50px;
    }
    .report-box {
      background: white;
      max-width: 700px;
      margin: auto;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #0275d8;
      margin-bottom: 30px;
    }
    .summary {
      display: flex;
      justify-content: space-between;
      font-size: 18px;
      margin-bottom: 20px;
      padding: 15px;
      background-color: #f8f9fa;
      border-radius: 8px;
      box-shadow: inset 0 0 5px rgba(0,0,0,0.05);
    }
    .label {
      font-weight: bold;
      color: #333;
    }
    .value {
      font-weight: bold;
      color: #5cb85c;
    }
    .value.expense {
      color: #d9534f;
    }
    .net-total {
      text-align: center;
      font-size: 24px;
      margin-top: 30px;
      padding: 20px;
      border-top: 2px solid #eee;
      font-weight: bold;
      color: <?= $net_total >= 0 ? '#5cb85c' : '#d9534f' ?>;
    }
  </style>
</head>
<body>
  <div class="report-box">
    <h2>Financial Report</h2>

    <div class="summary">
      <span class="label">Total Income:</span>
      <span class="value">Rs. <?= number_format($total_income) ?></span>
    </div>

    <div class="summary">
      <span class="label">Total Expenses:</span>
      <span class="value expense">Rs. <?= number_format($total_expense) ?></span>
    </div>

    <div class="net-total">
      <?= $status ?>: Rs. <?= number_format(abs($net_total)) ?>
    </div>
  </div>
</body>
</html>
