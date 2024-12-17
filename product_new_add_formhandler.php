<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$STRprodname = htmlspecialchars($_POST["STRprodname"]);
	$STRproddesc = htmlspecialchars($_POST["STRproddesc"]);
	$INTcategoryid = htmlspecialchars($_POST["INTcategoryid"]);
	try {
		require_once "dbconn.php";
		$query = "INSERT INTO producttable(STRprodname, STRproddesc, INTcategoryid) 
								VALUES(:STRprodname,:STRproddesc,:INTcategoryid);";

		$stmt = $conn->prepare($query);

		$stmt ->bindParam(":STRprodname", $STRprodname);
		$stmt ->bindParam(":STRproddesc", $STRproddesc);
		$stmt ->bindParam(":INTcategoryid", $INTcategoryid);

		$stmt->execute();

		$conn = null;
		$stmt = null;

		header("Location: ../inventorysystem/product_new_add.php");

		die();

		} catch (PDOException $e) {
			die("Query failed: " . $e->getMessage());
		}
	} else {
		header("Location: ../inventorysystem/product_new_add.php");
	}
