<?php
session_start();
if (!isset($_SESSION["username"]) || !isset($_SESSION["role"])) {
    header("Location: ../auth/login.php");
    exit();
}

$role = $_SESSION["role"];
$username = htmlspecialchars($_SESSION["username"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= ucfirst($role) ?> Dashboard</title>
  <style>
    :root {
      --bg: #121212;
      --card: #1e1e1e;
      --primary: #4dabf7;
      --primary-dark: #1c7ed6;
      --danger: #f44336;
      --danger-dark: #c62828;
      --text: #e0e0e0;
      --muted: #aaa;
      --radius: 14px;
      --shadow: 0 6px 18px rgba(0, 0, 0, 0.5);
    }

    body {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: var(--bg);
      margin: 0;
      padding: 0;
      color: var(--text);
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* Header */
    .dashboard-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: var(--card);
      padding: 20px 30px;
      box-shadow: var(--shadow);
      border-bottom: 1px solid #333;
    }

    .dashboard-header h2 {
      margin: 0;
      font-size: 1.5rem;
      color: var(--primary);
    }

    .logout-btn {
      background: var(--danger);
      color: #fff;
      padding: 10px 16px;
      border: none;
      border-radius: var(--radius);
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s, transform 0.2s;
    }

    .logout-btn:hover {
      background: var(--danger-dark);
      transform: translateY(-2px);
    }

    /* Dashboard content */
    .dashboard-content {
      flex: 1;
      max-width: 1100px;
      margin: 30px auto;
      padding: 20px;
    }

    h1 {
      font-size: 1.8rem;
      margin-bottom: 20px;
      color: var(--primary);
    }

    .card {
      background: var(--card);
      padding: 20px;
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      margin-bottom: 20px;
    }

    .card h3 {
      margin: 0 0 10px;
      font-size: 1.2rem;
      color: var(--primary);
    }

    .card ul {
      margin: 0;
      padding: 0;
      list-style: none;
    }

    .card ul li {
      margin: 8px 0;
      padding: 12px;
      background: #2a2a2a;
      border-radius: var(--radius);
      font-size: 15px;
      transition: background 0.2s, transform 0.2s;
    }

    .card ul li a {
      text-decoration: none;
      color: var(--text);
      font-weight: 500;
      display: block;
    }

    .card ul li:hover {
      background: var(--primary-dark);
      transform: translateX(4px);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .dashboard-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
      }

      .dashboard-content {
        margin: 15px;
        padding: 15px;
      }

      .card ul li {
        font-size: 14px;
        padding: 10px;
      }
    }
  </style>
</head>
<body>

  

  <!-- Header -->
  <div class="dashboard-header">
    <h2>Welcome, <?= $username ?> (<?= ucfirst($role) ?>)</h2>
    <form action="../auth/logout.php" method="POST">
      <button type="submit" class="logout-btn">Logout</button>
    </form>
  </div>

  <!-- Content -->
  <div class="dashboard-content">
    <?php if ($role === "admin"): ?>
      <h1>Admin Dashboard</h1>
      <div class="card">
        <h3>System Management</h3>
        <ul>
          <li><a href="../users/manageUsers.php"> Manage Users</a></li>
          <li><a href="../users/manageBlogs.php"> Manage All Blogs</a></li>
          <li><a href="../admin/reports.php"> View Reports & Analytics</a></li>
          <li><a href="../admin/settings.php"> System Settings</a></li>
        </ul>
      </div>

    <?php elseif ($role === "employee"): ?>
      <h1>Employee Dashboard</h1>
      <div class="card">
        <h3>Blogs</h3>
        <ul>
          <li><a href="../blogs/createBlog.php">Create New Blogs</a></li>
          <li><a href="../blogs/manageBlogs.php"> Edit/Delete Blogs</a></li>
          <li><a href="../events/invite.php"> Invite Attendees</a></li>
        </ul>
      </div>

    <?php elseif ($role === "user"): ?>
      <h1>User Dashboard</h1>
      <div class="card">
        <h3>My Activities</h3>
        <ul>
          <li><a href="../blogs/browse.php"> Browse Blogs</a></li>
          <li><a href="../blogs/trending.php"> Trending Blogs</a></li>
          <li><a href="../blogs/myBlogs.php">View My Blogs</a></li>
        </ul>
      </div>

    <?php else: ?>
      <p>Role not recognized. Please contact admin.</p>
    <?php endif; ?>
  </div>

  <!-- Footer -->
  <?php include("../layouts/footer.php"); ?>

</body>
</html>
