<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$STRusername = htmlspecialchars($_POST["STRusername"]);
	$STRpassword = htmlspecialchars($_POST["STRpassword"]);
	$STRfirstname = htmlspecialchars($_POST["STRfirstname"]);
	$STRlastname = htmlspecialchars($_POST["STRlastname"]);
	$INTroleid = htmlspecialchars($_POST["INTroleid"]);
	try {
		require_once "dbconn.php";
		$query = "INSERT INTO account(STRusername, STRpassword, STRfirstname, STRlastname, INTroleid) 
								VALUES(:STRusername, :STRpassword, :STRfirstname, :STRlastname, :INTroleid);";

		$stmt = $conn->prepare($query);

		$stmt ->bindParam(":STRusername", $STRusername);
		$stmt ->bindParam(":STRpassword", $STRpassword);
		$stmt ->bindParam(":STRfirstname", $STRfirstname);
		$stmt ->bindParam(":STRlastname", $STRlastname);
		$stmt ->bindParam(":INTroleid", $INTroleid);

		$stmt->execute();

		$conn = null;
		$stmt = null;

		header("Location: ../inventorysystem/account_new_add.php");

		die();

		} catch (PDOException $e) {
			die("Query failed: " . $e->getMessage());
		}
	} else {
		header("Location: ../inventorysystem/category_new_add.php");
	}
