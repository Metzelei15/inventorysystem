<?php
if (isset($_GET['deleteID'])){
	$INTmatid = $_GET['deleteID'];
	try {
		require_once "dbconn.php";
		$query = "DELETE FROM materialtable WHERE INTmatid = :INTmatid LIMIT 1";
        $stmt = $conn->prepare($query);

		$stmt->bindParam(":INTmatid", $INTmatid, PDO::PARAM_INT);
		$stmt->execute();

		header("Location: ../inventorysystem/materialpage.php");

		die();

		} catch (PDOException $e) {
			die("Query failed: " . $e->getMessage());
		}
	} else {
		header("Location: ../inventorysystem/materialpage.php");
	}
