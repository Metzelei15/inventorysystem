<?php include('dbconn.php');
if (isset($_GET['editID'])) 
{
    $INTaccountid = $_GET['editID'];
        $sql = "SELECT * FROM account WHERE INTaccntid = :INTaccnt LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':INTaccnt', $INTaccountid, PDO::PARAM_INT);
        $stmt->execute();
        $result1 = $stmt->fetch(PDO::FETCH_OBJ);

    }
?>
