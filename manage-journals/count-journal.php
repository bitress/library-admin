<?php

include_once __DIR__ . '/../config/connect.php';

$sql = "SELECT COUNT(*) AS journal_count
        FROM `journal`";

$result = $conn->query($sql);
$row = $result->fetch_assoc();

echo $row['journal_count'];