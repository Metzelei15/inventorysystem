<?php
if (isset($_POST['product_item_edit'])){
	$INTprodid = htmlspecialchars($_POST["INTprodid"]);
	$STRprodname = htmlspecialchars($_POST["STRprodname"]);
	$STRproddesc = htmlspecialchars($_POST["STRproddesc"]);
	try {
		require_once "dbconn.php";
		$query = "UPDATE producttable 
          SET 	STRprodname = :STRprodname, 
          	  	STRproddesc = :STRproddesc 
          WHERE INTprodid = :INTprodid LIMIT 1";

		$stmt = $conn->prepare($query);

		$stmt ->bindParam(":INTprodid", $INTprodid, PDO::PARAM_INT);
		$stmt ->bindParam(":STRprodname", $STRprodname);
		$stmt ->bindParam(":STRproddesc", $STRproddesc);

		$stmt->execute();

		$conn = null;
		$stmt = null;

		header("Location: ../inventorysystem/productpage.php");

		die();

		} catch (PDOException $e) {
			die("Query failed: " . $e->getMessage());
		}
	} else {
		header("Location: ../inventorysystem/productpage.php");
	}
