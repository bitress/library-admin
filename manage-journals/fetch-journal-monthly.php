<?php

include_once __DIR__ . '/../config/connect.php';

$sql = "SELECT YEAR(dateposted) AS year, MONTH(dateposted) AS month, COUNT(*) AS journal_count
        FROM `journal`
        GROUP BY YEAR(dateposted), MONTH(dateposted)
        ORDER BY YEAR(dateposted), MONTH(dateposted)";

$result = $conn->query($sql);
$monthlyData = array();
while ($row = $result->fetch_assoc()) {
    $monthlyData[] = $row;
}

$monthlyDataJson = json_encode($monthlyData);

echo $monthlyDataJson;