<?php
session_start();
if (!isset($_SESSION["username"]) || !isset($_SESSION["role"])) {
    header("Location: ../auth/login.php");
    exit();
}

$role = $_SESSION["role"];
$username = $_SESSION["username"];

// Only Admin and Employee can access
if ($role !== "employee" && $role !== "admin") {
    echo "Access denied.";
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

// Get current user ID from users table
$user_id = null;
$stmt = $conn->prepare("SELECT id FROM users WHERE username=? LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$res = $stmt->get_result();
if ($row = $res->fetch_assoc()) {
    $user_id = $row['id'];
}
$stmt->close();

// Delete blog
if (isset($_GET['delete'])) {
    $blogId = intval($_GET['delete']);
    if ($role === "admin") {
        $conn->query("DELETE FROM blogs WHERE id=$blogId");
    } else {
        $conn->query("DELETE FROM blogs WHERE id=$blogId AND author_id=$user_id");
    }
    header("Location: manage_blogs.php");
    exit();
}

// Fetch blogs
if ($role === "admin") {
    $sql = "SELECT blogs.*, users.username AS author_name 
            FROM blogs 
            JOIN users ON blogs.author_id = users.id 
            ORDER BY blogs.created_at DESC";
} else {
    $sql = "SELECT blogs.*, users.username AS author_name 
            FROM blogs 
            JOIN users ON blogs.author_id = users.id 
            WHERE blogs.author_id=$user_id 
            ORDER BY blogs.created_at DESC";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Blogs</title>
  <style>
    :root {
      --primary: #007bff;
      --primary-dark: #0056b3;
      --danger: #dc3545;
      --danger-dark: #b02a37;
      --success: #28a745;
      --success-dark: #1e7e34;
      --bg: #2c2f33;       
      --card: #3a3d41;     
      --shadow: 0 6px 18px rgba(0,0,0,0.4);
      --radius: 10px;
    }

    body {
      font-family: "Segoe UI", Tahoma, sans-serif;
      background: var(--bg);
      margin: 0;
      padding: 0;
      color: #f1f1f1; /* light text for contrast */
    }

    .container {
      max-width: 1100px;
      margin: 40px auto;
      padding: 20px;
      background: var(--card);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
    }

    .header-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
    }

    h1 {
      color: #ffffff;
      margin: 0;
    }

    .actions select {
      padding: 10px 14px;
      border-radius: var(--radius);
      border: 1px solid #ccc;
      font-size: 14px;
      cursor: pointer;
      background: #fff;
      color: #333;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #4a4d52;
      border-radius: var(--radius);
      overflow: hidden;
      box-shadow: var(--shadow);
    }

    th, td {
      padding: 14px;
      text-align: left;
      border-bottom: 1px solid #666;
    }

    th {
      background: var(--primary);
      color: #fff;
      font-weight: 600;
    }

    tr:nth-child(even) {
      background: #5a5d63;
    }

    tr:hover {
      background: #6b6e75;
    }

    .back-link {
      display: inline-block;
      margin-top: 20px;
      text-decoration: none;
      background: var(--primary);
      color: #fff;
      padding: 10px 16px;
      border-radius: var(--radius);
      font-weight: 600;
      transition: background 0.3s;
    }

    .back-link:hover {
      background: var(--primary-dark);
    }

    footer {
      margin-top: 40px;
      padding: 20px;
      text-align: center;
      font-size: 14px;
      background: #1e2124;
      color: #bbb;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <?php include('../layouts/navbar.php'); ?>

  <div class="container">
    <!-- Header with title + actions dropdown -->
    <div class="header-bar">
        <h1>All Blogs</h1>
        <div class="actions">
            <select onchange="handleAction(this.value)">
                <option value="">-- Actions --</option>
                <option value="create">Create Blog</option>
                <option value="edit">Edit Blog</option>
                <option value="delete">Delete Blog</option>
            </select>
        </div>
    </div>

    <!-- Blog Table -->
    <table>
      <tr>
        <th>Select</th>
        <th>Title</th>
        <th>Author</th>
        <th>Date</th>
      </tr>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><input type="radio" name="selectedBlog" value="<?= $row['id'] ?>"></td>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['author_name']) ?></td>
            <td><?= date("F j, Y", strtotime($row['created_at'])) ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="4" style="text-align:center; color:#ccc;">No blogs found.</td></tr>
      <?php endif; ?>
    </table>

    <a href="dashboard.php" class="back-link"> Back to Dashboard</a>
  </div>

  <!-- Footer -->
  <?php include('../layouts/footer.php'); ?>

  <script>
    function getSelectedBlogId() {
        const radios = document.getElementsByName("selectedBlog");
        for (let r of radios) {
            if (r.checked) {
                return r.value;
            }
        }
        return null;
    }

    function handleAction(action) {
        const blogId = getSelectedBlogId();

        if (action === "create") {
            window.location.href = "createBlog.php";
        } 
        else if (action === "edit") {
            if (!blogId) {
                alert("Please select a blog to edit.");
                return;
            }
            window.location.href = "edit_blog.php?id=" + blogId;
        } 
        else if (action === "delete") {
            if (!blogId) {
                alert("Please select a blog to delete.");
                return;
            }
            if (confirm("Are you sure you want to delete this blog?")) {
                window.location.href = "manage_blogs.php?delete=" + blogId;
            }
        }
    }
  </script>
</body>
</html>
