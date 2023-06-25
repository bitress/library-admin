<?php

include_once __DIR__. '/../config/connect.php';

if (isset($_POST['journalID'])) {

    $journalID = $_POST['journalID'];
    $journalname = $_POST['journalname'];
    $description = $_POST['description'];
    $url = $_POST['url'];
    $imageurl = $_POST['imageurl'];

    try {

        $sql = "UPDATE `journal` SET `journalname` = ?, `description` = ?, `url` = ?, `imageurl` = ? WHERE `journalID` = ?";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param('ssssi', $journalname, $description, $url, $imageurl, $journalID);
        if ($stmt->execute()){
            echo "true";
        } else {
            echo "something went wrong";
        }


    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

