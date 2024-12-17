<?php
if(isset($_GET['editID']))
	{
		$INTmaterialid = $_GET['editID'];
		$sql = "SELECT * FROM materialtable WHERE INTmatid = :INTmat LIMIT 1";
		$stmt = $conn->prepare($sql);
		$data = [':INTmat' => $INTmaterialid];
		$stmt->execute($data);
		$result1 = $stmt->fetch(PDO::FETCH_OBJ);
	}
?>