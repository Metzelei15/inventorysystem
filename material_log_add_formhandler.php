<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $INTmatid = (int)$_POST['INTmatid'];
    $INTstockchange = (int)$_POST['INTstockchange'];
    $STRaction = htmlspecialchars($_POST['STRaction']);

    try {
        require_once 'dbconn.php';
        $query = "INSERT INTO materialstockslog (INTmatid, INTstockchange, STRaction) 
                                         VALUES (:INTmatid, :INTstockchange, :STRaction)";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(":INTmatid", $INTmatid);
        $stmt->bindParam(":INTstockchange", $INTstockchange);
        $stmt->bindParam(":STRaction", $STRaction);

        $stmt->execute();

        $conn = null;
        $stmt = null;

        header("Location: ../inventorysystem/material_log_page.php");

        die();

        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    } else {
        header("Location: ../inventorysystem/material_log_add.php");
    }
