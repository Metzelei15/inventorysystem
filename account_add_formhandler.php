<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $STRusername = htmlspecialchars($_POST["STRusername"]);
    $STRpassword = htmlspecialchars($_POST["STRpassword"]);
    $STRfirstname = htmlspecialchars($_POST["STRfirstname"]);
    $STRlastname = htmlspecialchars($_POST["STRlastname"]);
    $INTroleid = htmlspecialchars($_POST["INTroleid"]);
    try {
        require_once "dbconn.php";

        $checkQuery = "SELECT COUNT(*) FROM account WHERE STRusername = :STRusername";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bindParam(":STRusername", $STRusername);
        $checkStmt->execute();
        $count = $checkStmt->fetchColumn();

        if ($count > 0) {
            //Username already exists
            $conn = null;
            $checkStmt = null;
            header("Location: ../inventorysystem/accountpage.php?error=UserExists");
            exit();
        }

        $query = "INSERT INTO account(STRusername, STRpassword, STRfirstname, STRlastname, INTroleid) 
                  VALUES(:STRusername, :STRpassword, :STRfirstname, :STRlastname, :INTroleid)";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(":STRusername", $STRusername);
        $stmt->bindParam(":STRpassword", $STRpassword);
        $stmt->bindParam(":STRfirstname", $STRfirstname);
        $stmt->bindParam(":STRlastname", $STRlastname);
        $stmt->bindParam(":INTroleid", $INTroleid);

        $stmt->execute();

        $conn = null;
        $stmt = null;

        header("Location: ../inventorysystem/accountpage.php?success=AccountCreated");
        exit();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../inventorysystem/category_new_add.php");
    exit();
}
?>
