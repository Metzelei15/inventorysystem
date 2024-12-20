<?php include_once('dbconn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $INTaccntid = $_POST['INTaccntid'];
    $STRusername = $_POST['STRusername'];
    $STRpassword = $_POST['STRpassword'];
    $STRfirstname = $_POST['STRfirstname'];
    $STRlastname = $_POST['STRlastname'];

    try {
        $sql = "UPDATE account SET STRusername = :STRusername, 
                                   STRfirstname = :STRfirstname, 
                                   STRlastname = :STRlastname";
        
        if (!empty($STRpassword)) {
            $sql .= ", STRpassword = :STRpassword";
        }

        $sql .= " WHERE INTaccntid = :INTaccntid";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':STRusername', $STRusername);
        $stmt->bindParam(':STRfirstname', $STRfirstname);
        $stmt->bindParam(':STRlastname', $STRlastname);
        $stmt->bindParam(':INTaccntid', $INTaccntid, PDO::PARAM_INT);

        if (!empty($STRpassword)) {
            $hashedPassword = password_hash($STRpassword, PASSWORD_DEFAULT);
            $stmt->bindParam(':STRpassword', $hashedPassword);
        }

        if ($stmt->execute()) {
            echo "Account updated successfully!";
            header("Location: ../inventorysystem/accountpage.php");
            die();
        } else {
            echo "Error updating account.";
            header("Location: ../inventorysystem/accountpage.php");
            die();
        }
    } catch (PDOException $e) {
        echo "Query error: " . $e->getMessage();
        header("Location: ../inventorysystem/accountpage.php");
        die;
    }
}
?>
