<?php
require('../db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (!empty($email) && !empty($password)) {
        try {
            // check for user in db
            $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // store session
                $_SESSION["user_id"]   = $user["id"];
                $_SESSION["username"]  = $user["username"];
                $_SESSION["role"]      = $user["role"]; 

                // redirect based on role
                switch ($user["role"]) {
                    case "admin":
                        header("Location: ../users/dashboard.php");
                        break;
                    case "employee":
                        header("Location: ../users/dashboard.php");
                        break;
                    case "user":
                        header("Location: ../users/dashboard.php");
                        break;
                    default:
                        // fallback if role is missing
                        header("Location: ../users/dashboard.php");
                        break;
                }
                exit();
            } else {
                $error = "Invalid email or password!";
            }
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    } else {
        $error = "Please fill in all fields.";
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
    max-width: 400px;
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

  .form-container input {
    width: 100%;
    padding: 10px;
    margin-bottom: 18px;
    border: 1px solid #ccc;
    border-radius: 8px;
    transition: 0.3s;
  }

  .form-container input:focus {
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

  .error {
    background: #ffe6e6;
    color: #cc0000;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
    text-align: center;
    font-size: 14px;
  }

  .extra-links {
    text-align: center;
    margin-top: 12px;
    font-size: 14px;
  }

  .extra-links a {
    color: #007bff;
    text-decoration: none;
  }

  .extra-links a:hover {
    text-decoration: underline;
  }
</style>

<div class="form-container">
  <h3>Login</h3>

  <?php if (!empty($error)) : ?>
    <div class="error"><?php echo $error; ?></div>
  <?php endif; ?>

  <form action="" method="POST">
    <label for="email">Enter Email:</label>
    <input type="email" name="email" id="email" required>

    <label for="password">Enter Password:</label>
    <input type="password" name="password" id="password" required>

    <button type="submit">Login</button>
  </form>

  <div class="extra-links">
    <p>Don't have an account? <a href="register.php">Register</a></p>
  </div>
</div>

<?php include('../layouts/footer.php'); ?>
