<?php

include_once __DIR__ . '/../config/connect.php';

if (isset($_POST['journalname'])) {
    $journal_name = $_POST['journalname'];
    $journal_description = $_POST['description'];
    $journal_url = $_POST['url'];
    $journal_image = $_POST['imageurl'];

    if (empty($journal_name) || empty($journal_description) || empty($journal_url) || empty($journal_image)) {
        echo 'Please fill in all the required fields';
        exit;
    }

    try {
        $sql = "INSERT INTO `journal` (`journalname`, `description`, `url`, `imageurl`, `dateposted`) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $journal_name, $journal_description, $journal_url, $journal_image);
        if($stmt->execute()){
            echo "true";
        } else {
            echo "Something went wrong";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
