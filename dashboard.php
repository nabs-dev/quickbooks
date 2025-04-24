<?php
session_start();
if (!isset($_SESSION["user"])) {
    echo "<script>window.location.href='index.php';</script>";
    exit();
}
include 'db.php';

// Fetch total income
$income = $conn->query("SELECT SUM(amount) AS total_income FROM invoices WHERE user='{$_SESSION["user"]}'");
$total_income = $income->fetch_assoc()['total_income'] ?? 0;

// Fetch total expenses
$expense = $conn->query("SELECT SUM(amount) AS total_expense FROM expenses WHERE user='{$_SESSION["user"]}'");
$total_expense = $expense->fetch_assoc()['total_expense'] ?? 0;

// Fetch recent invoices
$recent_invoices = $conn->query("SELECT * FROM invoices WHERE user='{$_SESSION["user"]}' ORDER BY id DESC LIMIT 5");

// Fetch recent expenses
$recent_expenses = $conn->query("SELECT * FROM expenses WHERE user='{$_SESSION["user"]}' ORDER BY id DESC LIMIT 5");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard - QuickBooks Clone</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f3f6f9;
    }
    header {
      background: #0077cc;
      color: white;
      padding: 20px;
      text-align: center;
      font-size: 24px;
      font-weight: bold;
      position: relative;
    }
    .logout {
      position: absolute;
      right: 30px;
      top: 25px;
      background: #dc3545;
      color: white;
      border: none;
      padding: 10px 14px;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
    }
    .logout:hover {
      background: #c82333;
    }
    .container {
      padding: 30px;
      max-width: 1200px;
      margin: auto;
    }
    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }
    .card {
      background: white;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      transition: 0.3s ease;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .card h3 {
      color: #333;
      font-size: 18px;
      margin-bottom: 10px;
    }
    .card p {
      font-size: 24px;
      color: #28a745;
      font-weight: bold;
    }
    .section {
      margin-top: 40px;
    }
    h2 {
      font-size: 20px;
      margin-bottom: 15px;
      color: #444;
    }
    table {
      width: 100%;
      background: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 14px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }
    th {
      background: #f0f4f8;
      color: #333;
    }
    tr:hover {
      background: #f9f9f9;
    }
    .actions {
      margin: 20px 0;
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
    }
    .action-btn {
      background: #0077cc;
      color: white;
      padding: 12px 20px;
      border-radius: 8px;
      font-weight: bold;
      border: none;
      cursor: pointer;
      font-size: 16px;
      transition: 0.3s ease;
    }
    .action-btn:hover {
      background: #005fa3;
    }
  </style>
</head>
<body>

<header>
  Welcome to Your Dashboard
  <form method="post" style="display:inline;">
    <button class="logout" name="logout">Logout</button>
  </form>
</header>

<?php
if (isset($_POST['logout'])) {
    session_destroy();
    echo "<script>window.location.href='index.php';</script>";
}
?>

<div class="container">

  <div class="cards">
    <div class="card">
      <h3>Total Income</h3>
      <p>Rs. <?= number_format($total_income) ?></p>
    </div>
    <div class="card">
      <h3>Total Expenses</h3>
      <p style="color:#dc3545;">Rs. <?= number_format($total_expense) ?></p>
    </div>
    <div class="card">
      <h3>Account Balance</h3>
      <p style="color:#0077cc;">Rs. <?= number_format($total_income - $total_expense) ?></p>
    </div>
  </div>

  <!-- 🔘 Action Buttons -->
  <div class="actions">
    <button class="action-btn" onclick="window.location.href='add_invoice.php'">+ Add Invoice</button>
    <button class="action-btn" onclick="window.location.href='add_expense.php'">+ Add Expense</button>
    <button class="action-btn" onclick="window.location.href='report.php'">📊 View Report</button>
  </div>

  <div class="section">
    <h2>Recent Invoices</h2>
    <table>
      <tr><th>Client</th><th>Amount</th><th>Due Date</th></tr>
      <?php while($row = $recent_invoices->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row["client"]) ?></td>
          <td>Rs. <?= number_format($row["amount"]) ?></td>
          <td><?= $row["due_date"] ?></td>
        </tr>
      <?php endwhile; ?>
    </table>
  </div>

  <div class="section">
    <h2>Recent Expenses</h2>
    <table>
      <tr><th>Category</th><th>Amount</th><th>Date</th></tr>
      <?php while($row = $recent_expenses->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row["category"]) ?></td>
          <td>Rs. <?= number_format($row["amount"]) ?></td>
          <td><?= $row["date"] ?></td>
        </tr>
      <?php endwhile; ?>
    </table>
  </div>

</div>

</body>
</html>
