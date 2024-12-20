<?php
if (isset($_GET['deleteID'])) {
    $INTaccntid = $_GET['deleteID'];
    try {
        require_once "dbconn.php";
        $query = "DELETE FROM account WHERE INTaccntid = :INTaccntid LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":INTaccntid", $INTaccntid, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: accountpage.php");
        die();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: accountpage.php");
}
?>