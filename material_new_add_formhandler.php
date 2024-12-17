<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$STRmatname = htmlspecialchars($_POST["STRmatname"]);
	$STRmatdesc = htmlspecialchars($_POST["STRmatdesc"]);
	$INTmatquan = htmlspecialchars($_POST["INTmatquan"]);
	try {
		require_once "dbconn.php";
		$query = "INSERT INTO materialtable(STRmatname, STRmatdesc, INTmatquan) 
								VALUES(:STRmatname,:STRmatdesc,:INTmatquan);";

		$stmt = $conn->prepare($query);

		$stmt ->bindParam(":STRmatname", $STRmatname);
		$stmt ->bindParam(":STRmatdesc", $STRmatdesc);
		$stmt ->bindParam(":INTmatquan", $INTmatquan);

		$stmt->execute();

		$conn = null;
		$stmt = null;

		header("Location: ../inventorysystem/material_new_add.php");

		die();

		} catch (PDOException $e) {
			die("Query failed: " . $e->getMessage());
		}
	} else {
		header("Location: ../inventorysystem/material_new_add.php");
	}
