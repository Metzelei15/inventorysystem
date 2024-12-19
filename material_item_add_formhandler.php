<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$STRmatname = htmlspecialchars($_POST["STRmatname"]);
	$STRmatdesc = htmlspecialchars($_POST["STRmatdesc"]);
	try {
		require_once "dbconn.php";
		$query = "INSERT INTO materialtable(STRmatname, STRmatdesc) 
								VALUES(:STRmatname,:STRmatdesc);";

		$stmt = $conn->prepare($query);

		$stmt ->bindParam(":STRmatname", $STRmatname);
		$stmt ->bindParam(":STRmatdesc", $STRmatdesc);

		$stmt->execute();

		$conn = null;
		$stmt = null;

		header("Location: ../inventorysystem/material_item_add.php");

		die();

		} catch (PDOException $e) {
			die("Query failed: " . $e->getMessage());
		}
	} else {
		header("Location: ../inventorysystem/material_item_add.php");
	}
