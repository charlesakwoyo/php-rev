<?php
session_start();
require('../db.php'); 

// Check if user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: ../auth/login.php");
    exit();
}

$username = $_SESSION["username"];
$error = "";
$success = "";
$user_id = null;

try {
    // Get the logged-in user’s ID
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = :username LIMIT 1");
    $stmt->execute([":username" => $username]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $user_id = $row['id'];
    } else {
        $error = " User not found in database.";
    }
} catch (PDOException $e) {
    $error = " Error fetching user: " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $user_id) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (empty($title) || empty($content)) {
        $error = "All fields are required.";
    } else {
        try {
            //  Insert using author_id
            $stmt = $conn->prepare("INSERT INTO blogs (title, content, author_id, created_at) VALUES (:title, :content, :author_id, NOW())");
            $stmt->execute([
                ':title' => $title,
                ':content' => $content,
                ':author_id' => $user_id
            ]);
            $success = " Blog created successfully!";
        } catch (PDOException $e) {
            $error = " Error creating blog: " . $e->getMessage();
        }
    }
}
?>

<?php include('../layouts/navbar.php'); ?>

<style>
  body {
    font-family: Arial, sans-serif;
    background: #f5f6fa;
    margin: 0;
    padding: 0;
  }

  .form-container {
    width: 100%;
    max-width: 600px;
    margin: 60px auto;
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
  }

  .form-container h3 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
  }

  .form-container label {
    display: block;
    font-weight: bold;
    margin-bottom: 6px;
    color: #444;
  }

  .form-container input,
  .form-container textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 18px;
    border: 1px solid #ccc;
    border-radius: 8px;
    transition: 0.3s;
  }

  .form-container input:focus,
  .form-container textarea:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 5px rgba(0,123,255,0.3);
  }

  .form-container button {
    width: 100%;
    padding: 12px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s;
  }

  .form-container button:hover {
    background: #0056b3;
  }

  .message {
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
    text-align: center;
    font-size: 14px;
  }

  .error {
    background: #ffe6e6;
    color: #cc0000;
  }

  .success {
    background: #e6ffe6;
    color: #006600;
  }
</style>

<div class="form-container">
  <h3>Create Blog</h3>

  <?php if (!empty($error)) : ?>
    <div class="message error"><?php echo $error; ?></div>
  <?php endif; ?>

  <?php if (!empty($success)) : ?>
    <div class="message success"><?php echo $success; ?></div>
  <?php endif; ?>

  <form action="" method="POST">
    <label for="title">Blog Title:</label>
    <input type="text" name="title" id="title" required>

    <label for="content">Blog Content:</label>
    <textarea name="content" id="content" rows="6" required></textarea>

    <button type="submit">Create Blog</button>
  </form>
</div>

<?php include('../layouts/footer.php'); ?>
