<?php

class Ebook {

    /**
     * @var Database
     */
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Returns JSON of all journals, associated with the CRUD
     * @return void
     */
    public function fetchAllEbooks() {
        try {

            $sql = "SELECT ebook.*, ebook_cat.catID, ebook_cat.catname FROM ebook LEFT JOIN ebook_cat ON ebook_cat.catID = ebook.catID";
            $stmt = $this->db->query($sql);
            if ($stmt->execute()){

                $output = array();
                $output['journal'] = array();

                while ($row = $stmt->fetch()) {

                    $data = [
                        "ebookID" => $row['ebookID'],
                        "catname" => $row['catname'],
                        "ebookname" => $row['ebookname'],
                        "description" =>  strlen($row['description']) > 50 ? substr($row['description'],0,50)."..." : $row['description'],
                        "url" => $row['url'],
                        "imageurl" => $row['imageurl'],
                        "dateposted" => $row['dateposted']
                    ];


                    array_push($output['journal'], $data);


                }

                echo json_encode($output);

            }


        } catch (Exception $e) {
            echo 'An error occurred';
        }
    }


    public function fetchEbookByID($id) {
        try{

        $sql = "SELECT ebook.*, ebook_cat.catID, ebook_cat.catname FROM ebook LEFT JOIN ebook_cat ON ebook_cat.catID = ebook.catID WHERE ebook.ebookID = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                echo json_encode($stmt->fetch());
            }
        } catch (Exception $e) {
            echo 'An error occurred while processing the request. Please try again later.';
        }
    }

    public function deleteEbook($ebookID)
    {
        try {
            $sql = "DELETE FROM `ebook` WHERE ebookID = :jid";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":jid", $ebookID, PDO::PARAM_INT);

            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    echo "true";
                } else {
                    echo "No ebook found with the provided ID.";
                }
            } else {
                echo "Error executing the deletion query.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    public function editEbook($ebook_id, $catID, $ebookname, $description, $url, $image){

       try {

           $sql = "UPDATE ebook SET `ebookname` = :ebookname, `catID` = :catID, `description` = :description, `url` = :url, `imageurl` = :image WHERE ebookID= :ebookID";
           $stmt = $this->db->prepare($sql);
           $stmt->bindParam(':ebookname', $ebookname);
           $stmt->bindParam(':description', $description);
           $stmt->bindParam(':url', $url);
           $stmt->bindParam(':catID', $catID);
           $stmt->bindParam(':image', $image);
           $stmt->bindParam(':ebookID', $ebook_id);
           if ($stmt->execute()) {
               echo "true";
           }
       } catch (Exception $e) {
           echo 'Error has occurred while processing';
       }

   }



}