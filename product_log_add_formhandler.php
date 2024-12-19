<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $INTprodid = (int)$_POST['INTprodid'];
    $INTstockchange = (int)$_POST['INTstockchange'];
    $STRaction = htmlspecialchars($_POST['STRaction']);

    try {
        require_once 'dbconn.php';
        $query = "INSERT INTO productstockslog (INTprodid, INTstockchange, STRaction) 
                                         VALUES (:INTprodid, :INTstockchange, :STRaction)";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(":INTprodid", $INTprodid);
        $stmt->bindParam(":INTstockchange", $INTstockchange);
        $stmt->bindParam(":STRaction", $STRaction);

        $stmt->execute();

        $conn = null;
        $stmt = null;

        header("Location: ../inventorysystem/product_log_page.php");

        die();

        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    } else {
        header("Location: ../inventorysystem/product_log_add.php");
    }
