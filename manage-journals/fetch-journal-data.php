<?php

include_once __DIR__ . '/../config/connect.php';

if (isset($_POST['journal_id']) && is_numeric($_POST['journal_id'])) {
    $journal_id = intval($_POST['journal_id']);

    try{
        $sql = "SELECT * FROM `journal` WHERE journalID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $journal_id);
        $stmt->execute();
        $result = $stmt->get_result();
        echo json_encode($result->fetch_assoc());

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        error_log('Error: ' . $e->getMessage());
        echo 'An error occurred while processing the request. Please try again later.';
    }
} else {
    echo 'Invalid journal ID';
}
