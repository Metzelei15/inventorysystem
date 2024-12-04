<?php
$servername = "mysql:host=localhost;dbname=inventory";
$dbusername = "root";
$dbpassword = "";

try {
  $conn = new PDO($servername, $dbusername, $dbpassword);

  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>