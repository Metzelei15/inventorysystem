<?php
session_start();
include('dbconn.php');

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $query = "
            SELECT `INTaccntid`, `INTroleid`
            FROM `account`
            WHERE `STRusername` = :username AND `STRpassword` = :password
        ";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $_SESSION["role"] = $row['INTroleid'];
            $_SESSION["accntid"] = $row['INTaccntid'];
            if ($row['INTroleid'] == '1') {
                $_SESSION["role"] = "admin";
                header("Location: staffhomepage.php");
            } else if ($row['INTroleid'] == '2') {
                $_SESSION["role"] = "staff";
                header("Location: staffhomepage.php");
            }
        } else {
            echo "<script>alert('Invalid username or password');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('An error occurred: " . htmlspecialchars($e->getMessage()) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mhaine Inventory System</title>
    <link rel="stylesheet" href="login_style_sheet.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>
<body>
  <div class="img-holder"><img src="images/Main_logo_2.png"></div>
  <div class="login-div">
    <form action="#" method="POST">
      
    <div class="Header-login">
      <h1>Login</h1>
    </div>
      <div class="input-div">

        <label for="username">Email*</label>
        <input type="text" id="username" name="username" placeholder="Enter your email" required>
      </div>
      
      <div class="input-div">
        <label for="password">Password*</label>
        <input type="password" id="password" name="password" placeholder="Minimum 8 characters" required>
      </div>

      <button type="submit" class="Login"> 
        Login
      </button>
    </form>
    <div class="Header-login">
    <?php
    if (isset($_POST['username']) && isset($_POST['password']) && isset($stmt) && $stmt->rowCount() === 0) {
        echo "<div class='error-message'>Invalid username or password. Please try again.</div>";
    }
    ?>
  </div>
  </div>
  
</body>
</html>
