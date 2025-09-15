<?php
// process the form

// connection
require('../db.php');

// register
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (!empty($username) && !empty($email) && !empty($password)) {
        // hash password
        $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            // sql
            $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $hashedpassword);

            if ($stmt->execute()) {
                //  Redirect to dashboard after success
                header("Location:../auth/login.php");
                exit;
            }
        } catch (PDOException $e) {
            echo "An error occurred: " . $e->getMessage();
        }
    } else {
        echo "All fields are required";
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
    margin: 50px auto;
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
</style>

<div class="form-container">
  <h3>Register</h3>
  <form action="" method="POST">
    <label for="username">User Name:</label>
    <input type="text" name="username" id="username" required>

    <label for="email">Enter Email:</label>
    <input type="email" name="email" id="email" required>

    <label for="password">Enter Password:</label>
    <input type="password" name="password" id="password" required>

    <button type="submit">Submit</button>
  </form>
</div>

<?php include('../layouts/footer.php'); ?>
