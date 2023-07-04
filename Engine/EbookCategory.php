<?php

class EbookCategory
{

    /**
     * @var Database
     */
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function makeSelection(){
        $sql = "SELECT catID, catname FROM ebook_cat";
        $stmt = $this->db->query($sql);
        $stmt->execute();
        $options = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $options[] = array(
                'value' => $row['catID'],
                'text' => $row['catname']
            );
        }
        $optionsJson = json_encode($options);
        header('Content-Type: application/json');
        echo $optionsJson;
    }

    public function fetchAllCategory() {
        try {

            $sql = "SELECT * FROM ebook_cat";
            $stmt = $this->db->query($sql);
            if ($stmt->execute()){

                $output = array();
                $output['category'] = array();

                while ($row = $stmt->fetch()) {

                    $data = [
                        "catID" => $row['catID'],
                        "catname" => $row['catname'],
                        "description" =>  strlen($row['description']) > 50 ? substr($row['description'],0,50)."..." : $row['description'],
                        "imageurl" => $row['imageurl'],
                    ];


                    array_push($output['category'], $data);


                }

                echo json_encode($output);

            }


        } catch (Exception $e) {
            echo 'An error occurred';
        }
    }

    public function fetchCategoryByID($id) {
        try{

            $sql = "SELECT * FROM ebook_cat WHERE catID = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                echo json_encode($stmt->fetch());
            }
        } catch (Exception $e) {
            echo 'An error occurred while processing the request. Please try again later.';
        }
    }

    public function editCategory($catID, $catname, $description, $image)
    {

        $sql = "UPDATE ebook_cat SET catID = :catID, catname = :catname, description = :description, imageurl = :image WHERE catID = :catID";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":catID", $catID);
        $stmt->bindParam(":catname", $catname);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":image", $image);
        if ($stmt->execute()){
            echo "true";
        }

    }

    public function deleteCategory($catID)
    {
        try {
            $sql = "DELETE FROM `ebook_cat` WHERE catID = :jid";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":jid", $catID, PDO::PARAM_INT);

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

}