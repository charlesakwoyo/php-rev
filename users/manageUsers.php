<?php
session_start();
if (!isset($_SESSION["username"]) || !isset($_SESSION["role"])) {
    header("Location: ../auth/login.php");
    exit();
}

$role = $_SESSION["role"];
if ($role !== "admin") {
    echo "Access denied. Admins only.";
    exit();
}

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "mydb";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete user (only if not admin)
if (isset($_GET['delete'])) {
    $userId = intval($_GET['delete']);
    $check = $conn->query("SELECT role FROM users WHERE id=$userId");
    if ($check && $check->num_rows > 0) {
        $user = $check->fetch_assoc();
        if ($user['role'] !== 'admin') {
            $conn->query("DELETE FROM users WHERE id=$userId");
        }
    }
    header("Location: manageUsers.php");
    exit();
}

// Fetch registered users
$sql = "SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Manage Users</title>
  <style>
    body {
      font-family: "Segoe UI", Tahoma, sans-serif;
      background: #1e1e2f;
      margin: 0;
      padding: 0;
      color: #e0e0e0;
    }
    .container {
      max-width: 1000px;
      margin: auto;
      padding: 30px;
    }
    h1 {
      color: #4dabf7;
      text-align: center;
      margin-bottom: 25px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background: #2b2b3c;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 6px 20px rgba(0,0,0,0.5);
    }
    th, td {
      padding: 14px;
      border-bottom: 1px solid #3e3e50;
      text-align: left;
    }
    th {
      background: #007bff;
      color: #fff;
      text-transform: uppercase;
      font-size: 14px;
      letter-spacing: 0.05em;
    }
    tr:hover {
      background: #35354a;
    }
    .delete-btn {
      padding: 6px 12px;
      border-radius: 6px;
      text-decoration: none;
      font-size: 13px;
      font-weight: 600;
      background: #e03131;
      color: #fff;
      transition: 0.3s;
    }
    .delete-btn:hover {
      background: #c92a2a;
    }
    .disabled-btn {
      padding: 6px 12px;
      border-radius: 6px;
      font-size: 13px;
      font-weight: 600;
      background: #495057;
      color: #ccc;
      cursor: not-allowed;
    }
    .back-link {
      display: inline-block;
      margin-top: 20px;
      text-decoration: none;
      color: #4dabf7;
      font-weight: 600;
    }
    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <?php include('../layouts/navbar.php'); ?>

  <div class="container">
    <h1>Registered Users</h1>

    <table>
      <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Date Registered</th>
        <th>Action</th>
      </tr>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['role']) ?></td>
            <td><?= date("F j, Y", strtotime($row['created_at'])) ?></td>
            <td>
              <?php if ($row['role'] !== 'admin'): ?>
                <a href="manageUsers.php?delete=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Delete this user?')">Delete</a>
              <?php else: ?>
                <span class="disabled-btn">Protected</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="5" style="text-align:center; padding:20px;">No registered users found.</td></tr>
      <?php endif; ?>
    </table>

    <a href="dashboard.php" class="back-link">⬅ Back to Dashboard</a>
  </div>

  <!-- Footer -->
  <?php include('../layouts/footer.php'); ?>
</body>
</html>
