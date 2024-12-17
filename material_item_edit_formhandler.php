<?php
if (isset($_POST['material_item_edit'])){
	$INTmatid = htmlspecialchars($_POST["INTmatid"]);
	$STRmatname = htmlspecialchars($_POST["STRmatname"]);
	$STRmatdesc = htmlspecialchars($_POST["STRmatdesc"]);
	try {
		require_once "dbconn.php";
		$query = "UPDATE materialtable 
          SET 	STRmatname = :STRmatname, 
          	  	STRmatdesc = :STRmatdesc 
          WHERE INTmatid = :INTmatid LIMIT 1";

		$stmt = $conn->prepare($query);

		$stmt ->bindParam(":INTmatid", $INTmatid, PDO::PARAM_INT);
		$stmt ->bindParam(":STRmatname", $STRmatname);
		$stmt ->bindParam(":STRmatdesc", $STRmatdesc);

		$stmt->execute();

		$conn = null;
		$stmt = null;

		header("Location: ../inventorysystem/materialpage.php");

		die();

		} catch (PDOException $e) {
			die("Query failed: " . $e->getMessage());
		}
	} else {
		header("Location: ../inventorysystem/materialpage.php");
	}
