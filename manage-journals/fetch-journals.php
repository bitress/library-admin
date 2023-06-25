<?php

include_once __DIR__ . '/../config/connect.php';

    try {
        $sql = "SELECT * FROM `journal`";
        $result = $conn->query($sql);

        $output = array();
        $output['journal'] = array();

        while ($row = $result->fetch_array()) {

            $data = [
                "journalID" => $row['journalID'],
                "journalname" => $row['journalname'],
                "description" =>  strlen($row['description']) > 50 ? substr($row['description'],0,50)."..." : $row['description'],
                "url" => $row['url'],
                "imageurl" => $row['imageurl'],
                "dateposted" => $row['dateposted']
            ];


            array_push($output['journal'], $data);


        }

        echo json_encode($output);

    } catch (Exception $e){
        echo "Error: " . $e->getMessage();
    }