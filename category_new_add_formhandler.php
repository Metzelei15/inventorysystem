<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$STRcategoryname = htmlspecialchars($_POST["STRcategoryname"]);
	$STRcategorydesc = htmlspecialchars($_POST["STRcategorydesc"]);
	try {
		require_once "dbconn.php";
		$query = "INSERT INTO categorytable(STRcategoryname, STRcategorydesc) 
								VALUES(:STRcategoryname,:STRcategorydesc);";

		$stmt = $conn->prepare($query);

		$stmt ->bindParam(":STRcategoryname", $STRcategoryname);
		$stmt ->bindParam(":STRcategorydesc", $STRcategorydesc);

		$stmt->execute();

		$conn = null;
		$stmt = null;

		header("Location: ../inventorysystem/category_new_add.php");

		die();

		} catch (PDOException $e) {
			die("Query failed: " . $e->getMessage());
		}
	} else {
		header("Location: ../inventorysystem/category_new_add.php");
	}
