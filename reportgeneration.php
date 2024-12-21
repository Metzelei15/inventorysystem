<?php
include('dbconn.php');
include('session_handling.php');

try {
    $createViewQuery = "
        CREATE OR REPLACE VIEW combined_added_view AS
        SELECT 
            'Material' AS RecordType,
            mat.INTmatlogid AS LogID,
            mat.DTmatdtlog AS DateAdded,
            mat.INTmatid AS ItemID,
            mat.INTmatstockchange AS ChangeInQuantity,
            mat.STRaction AS TypeOfChange,
            mat.INTaccntid AS AccountID
        FROM materialstockslog mat
        UNION ALL
        SELECT 
            'Product' AS RecordType,
            prod.INTprodlogid AS LogID,
            prod.DTproddtlog AS DateAdded,
            prod.INtprodid AS ItemID,
            prod.INTprodstockchange AS ChangeInQuantity,
            prod.STRaction AS TypeOfChange,
            prod.INTaccntid AS AccountID
        FROM productstockslog prod;
    ";
    $conn->exec($createViewQuery);
} catch (PDOException $e) {
    echo "Error creating view: " . htmlspecialchars($e->getMessage());
    exit;
}

if (isset($_GET['report'])) {
    $report = $_GET['report'];

    $query = "SELECT * FROM combined_added_view WHERE ";

    if ($report === "Today") {
        $query .= "DATE(DateAdded) = CURDATE()";
    } elseif ($report === "Week") {
        $query .= "WEEK(DateAdded, 1) = WEEK(CURDATE(), 1) AND YEAR(DateAdded) = YEAR(CURDATE())";
    } elseif ($report === "Month") {
        $query .= "MONTH(DateAdded) = MONTH(CURDATE()) AND YEAR(DateAdded) = YEAR(CURDATE())";
    } else {
        echo "Invalid report type.";
        exit;
    }

    try {
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $filename = strtolower($report) . "_report_" . date("Ymd_His") . ".csv";

        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=\"$filename\"");

        $output = fopen("php://output", "w");

        if (!empty($results)) {
            fputcsv($output, array_keys($results[0]));
        } else {
            fputcsv($output, ['No data available for the selected period']);
        }

        foreach ($results as $row) {
            fputcsv($output, $row);
        }

        fclose($output);
        exit;

    } catch (PDOException $e) {
        echo "Error generating report: " . htmlspecialchars($e->getMessage());
    }
} else {
    echo "No report type selected.";
}
?>

	
<!DOCTYPE html>
<html>
<head>
	<title>Create New Account</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&display=swap">
    <link rel="stylesheet" href="inventory_style_sheet.css">
</head>
<body>

<div class="sidebar">
        <div class="logo"><img src="images/Main_logo_3.png" class="logo-mhaine"></div>
        <ul>
			<li><a href="../inventorysystem/staffhomepage.php">Home</a></li>
            <li><a href="../inventorysystem/productpage.php">Products</a></li>
            <li><a href="../inventorysystem/materialpage.php">Materials</a></li>
            <li><a href="../inventorysystem/reportgeneration.php">Reports</a></li>
            <li><a href="../inventorysystem/accountpage.php">Accounts</a></li>
            <form><button type='submit' name='logout' class="logout-button">Logout</button></form>
        </ul>
    </div>

    <div class="main-content-container">
    <div class="main-content">
	<h2 class="form-header">Select Option</h2>
    <div class="form-container">
        <form action='reportgeneration.php' method='GET'>
            <button class="today-button" input type='submit' name='report' value='Today'>Today</button>
            <button class="week-button" input type='submit' name='report' value='Week'>Week</button>
            <button class="month-button" input type='submit' name='report' value='Month'>Month</button>
        </form>
    </div>
	</div>
	</div>
</body>
</html>