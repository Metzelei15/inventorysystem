<?php
session_start();
include('dbconn.php');

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        //Prepare the query to join `account` and `account role` tables
        $query = "
            SELECT `INTaccntid`, `INTroleid`
            FROM `account`
            WHERE `STRusername` = :username AND `STRpassword` = :password
        ";

        //Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $_SESSION["role"] = $row['INTroleid'];
            $_SESSION["accntid"] = $row['INTaccntid'];

            //Redirect based on role
            if ($row['INTroleid'] == '1') {
                $_SESSION["role"] = "admin";
                echo "<script>document.location.href='adminhomepage.php';</script>";
            } elseif ($row['INTroleid'] == '2') {
                $_SESSION["role"] = "staff";
                echo "<script>document.location.href='staffhomepage.php';</script>";
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

      <div class="checkbox-group">
        <label>
          <input type="checkbox" id="remember-me" name="remember-me"><span class="remember-text"> Remember Me</span>
        </label>
        <a href="#" class="forgot-password">Forgot Password?</a>
      </div>

      <button type="submit" class="Login"> 
        Login
      </button>
    </form>
    <div class="Header-login">
    <p>Not registered yet?</p><span class="create-account"><a href="" class="create-account">create a new account</a></span>
  </div>
  </div>
  <?php
    if (isset($_POST['username']) && isset($_POST['password']) && isset($stmt) && $stmt->rowCount() === 0) {
        echo "<div class='error-message'>Invalid username or password. Please try again.</div>";
    }
    ?>
</body>
</html>
