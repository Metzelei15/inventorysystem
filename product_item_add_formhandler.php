<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$STRprodname = htmlspecialchars($_POST["STRprodname"]);
	$STRproddesc = htmlspecialchars($_POST["STRproddesc"]);
	try {
		require_once "dbconn.php";
		$query = "INSERT INTO producttable(STRprodname, STRproddesc) 
								VALUES(:STRprodname,:STRproddesc);";

		$stmt = $conn->prepare($query);

		$stmt ->bindParam(":STRprodname", $STRprodname);
		$stmt ->bindParam(":STRproddesc", $STRproddesc);

		$stmt->execute();

		$conn = null;
		$stmt = null;

		header("Location: ../inventorysystem/product_item_add.php");

		die();

		} catch (PDOException $e) {
			die("Query failed: " . $e->getMessage());
		}
	} else {
		header("Location: ../inventorysystem/product_item_add.php");
	}
