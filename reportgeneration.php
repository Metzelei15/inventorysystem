<?php
include('dbconn.php');
session_start();

if (!isset($_SESSION["role"])) {
    echo "<script>document.location.href = 'login.php'</script>";
    exit;
} elseif ($_SESSION["role"] != "admin") {
    echo "<script>document.location.href = 'adminhomepage.php'</script>";
    exit;
}

// Check if the `report` parameter is set
if (isset($_GET['report'])) {
    $report = $_GET['report'];

    // Determine the SQL query based on the report type
    $query = "";
    if ($report === "Today") {
        $query = "SELECT * FROM your_table WHERE DATE(date_column) = CURDATE()";
    } elseif ($report === "Week") {
        $query = "SELECT * FROM your_table WHERE WEEK(date_column) = WEEK(CURDATE())";
    } elseif ($report === "Month") {
        $query = "SELECT * FROM your_table WHERE MONTH(date_column) = MONTH(CURDATE())";
    } else {
        echo "Invalid report type.";
        exit;
    }

    try {
        // Execute the SQL query
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Generate the CSV file
        $filename = strtolower($report) . "_report_" . date("Ymd_His") . ".csv";

        // Set headers for the CSV download
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=\"$filename\"");

        // Open output stream for writing the CSV
        $output = fopen("php://output", "w");

        // Write column headers to the CSV
        if (!empty($results)) {
            fputcsv($output, array_keys($results[0]));
        }

        // Write rows to the CSV
        foreach ($results as $row) {
            fputcsv($output, $row);
        }

        fclose($output);
        exit;

    } catch (PDOException $e) {
        echo "Error: " . htmlspecialchars($e->getMessage());
    }
} else {
    echo "No report type selected.";
}
?>