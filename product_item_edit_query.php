<?php
if(isset($_GET['editID']))
	{
		$INTproductid = $_GET['editID'];
		$sql = "SELECT * FROM producttable WHERE INTprodid = :INTprod LIMIT 1";
		$stmt = $conn->prepare($sql);
		$data = [':INTprod' => $INTproductid];
		$stmt->execute($data);
		$result1 = $stmt->fetch(PDO::FETCH_OBJ);
	}
?>