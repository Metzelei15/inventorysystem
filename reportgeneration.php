<?php
include('dbconn.php');
session_start();

if (!isset($_SESSION["role"])) {
    echo "<script>document.location.href = 'login.php'</script>";
    exit;
}

try {
    $createViewQuery = "
        CREATE OR REPLACE VIEW combined_added_view AS
        SELECT 
            'Material' AS RecordType,
            mat.INTmataddlogid AS LogID,
            mat.DTmatadded AS DateAdded,
            mat.INTmatid AS ItemID,
            NULL AS CategoryID,
            mat.INTaccntid AS AccountID
        FROM materialaddedtable mat
        UNION ALL
        SELECT 
            'Product' AS RecordType,
            prod.INTprodaddlogid AS LogID,
            prod.DTprodaddid AS DateAdded,
            prod.INtprodid AS ItemID,
            prod.INTcategoryid AS CategoryID,
            prod.INTaccntid AS AccountID
        FROM productaddedtable prod;
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
