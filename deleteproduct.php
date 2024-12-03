<?php
    include('dbconn.php');
    session_start();

    if (!isset($_SESSION["role"])) {
        echo "<script>document.location.href = 'login.php'</script>";
    } else if ($_SESSION["role"] == "admin") {
        echo "<script>document.location.href = 'adminhomepage.php'</script>";
    }

    $accntid = isset($_SESSION['accntid']) ? $_SESSION['accntid'] : null;

    if (!$accntid) {
        echo "<script>alert('Invalid account ID. Please login again.'); window.location.href='login.php';</script>";
        exit;
    }

    $checkAccntQuery = "SELECT 1 FROM `account` WHERE `INTaccntid` = '$accntid' LIMIT 1";
    $accntCheckResult = mysqli_query($conn, $checkAccntQuery);

    if (mysqli_num_rows($accntCheckResult) == 0) {
        echo "<script>alert('Account ID does not exist.'); window.location.href='login.php';</script>";
        exit;
    }

    if (isset($_POST['del_product'])) {
        $prodname = $_POST['prodname'];
        $categoryid = $_POST['categoryid'];
        

        $prodname = $conn->real_escape_string($prodname);
        $categoryid = $conn->real_escape_string($categoryid);
        

        $insertQuery = "INSERT INTO `producttable` (`STRprodname`, `INTcategoryid`) 
                        VALUES ('$prodname', '$categoryid')";
        
        if (mysqli_query($conn, $insertQuery)) {
            $prodid = mysqli_insert_id($conn);  //This gives the last inserted product ID

            $logQuery = "INSERT INTO `productdeletedtable` (`INTprodid`, `INTcategoryid`, `INTaccntid`) 
                        VALUES ('$prodid', '$categoryid', '$accntid')";
            
            if (mysqli_query($conn, $logQuery)) {
                echo "<script>alert('Product deleted and logged successfully!'); window.location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
            } else {
                echo "<script>alert('Error logging product addition: " . mysqli_error($conn) . "'); window.location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
            }
        } else {
            echo "<script>alert('Error deleting product: " . mysqli_error($conn) . "'); window.location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
        }
    }
?>
