<?php
if (isset($_SESSION['role'])){
	if($_SESSION['role']!='admin'){
		echo "<script>alert('Admin Only');</script>";
		echo "<script>document.location.href='staffhomepage.php';</script>";
	}
}
if (isset($_GET['deleteID'])){
	$INTprodid = $_GET['deleteID'];
	try {
		require_once "dbconn.php";
		$query = "DELETE FROM producttable WHERE INTprodid = :INTprodid LIMIT 1";
        $stmt = $conn->prepare($query);

		$stmt->bindParam(":INTprodid", $INTprodid, PDO::PARAM_INT);
		$stmt->execute();

		header("Location: ../inventorysystem/productpage.php");

		die();

		} catch (PDOException $e) {
			die("Query failed: " . $e->getMessage());
		}
	} else {
		header("Location: ../inventorysystem/productpage.php");
	}
