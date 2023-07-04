<?php

class Journal
{

    /**
     * @var Database
     */
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    #----------------------------------------------------------------
    #   CRUD Methods /  Admin Side
    #----------------------------------------------------------------

    public function addJournal($journalname, $journal_description, $journal_url, $journal_image) {

        if (empty($journalname) || empty($journal_description) || empty($journal_url) || empty($journal_image)) {
            echo 'Please fill in all the required fields';
            exit;
        }

        try {

            $date = date('Y-m-d H:i:s');

            $sql = "INSERT INTO journal (journalname, description, url, imageurl, dateposted) VALUES (:journalname, :journaldescription, :url, :image, :date)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':journalname', $journalname);
            $stmt->bindParam(':journaldescription', $journal_description);
            $stmt->bindParam(':url', $journal_url);
            $stmt->bindParam(':image', $journal_image);
            $stmt->bindParam(":date", $date);
            if ($stmt->execute()) {
                echo  "true";
            }

        } catch (Exception $e) {
            echo 'An error occurred';
        }
    }

    /**
     * Returns JSON of all journals, associated with the CRUD
     * @return void
     */
    public function fetchAllJournal(){
        try {

            $sql = "SELECT * FROM journal";
            $stmt = $this->db->query($sql);
            if ($stmt->execute()){

                $output = array();
                $output['journal'] = array();

                while ($row = $stmt->fetch()) {

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

            }


        } catch (Exception $e) {
            echo 'An error occurred';
        }
    }

    public function fetchJournalByID($journal_id) {

        try{
            $sql = "SELECT * FROM `journal` WHERE journalID = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $journal_id);
            $stmt->execute();
            echo json_encode($stmt->fetch());

        } catch (Exception $e) {
            echo 'An error occurred while processing the request. Please try again later.';
        }

    }

    public function editJournal($journal_id,$journalname, $journal_description, $journal_url, $journal_image){

        try {

            $sql = "UPDATE journal SET journalname = :journalname, description = :description, url = :url, imageurl = :image WHERE journalID= :journal_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':journalname', $journalname);
            $stmt->bindParam(':description', $journal_description);
            $stmt->bindParam(':url', $journal_url);
            $stmt->bindParam(':image', $journal_image);
            $stmt->bindParam(':journal_id', $journal_id);
            if ($stmt->execute()) {
                echo "true";
            }
        } catch (Exception $e) {
            echo 'Error has occurred while processing';
        }

    }

    public function countJournal(){

        $sql = "SELECT COUNT(*) AS journal_count FROM `journal`";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        echo $row['journal_count'];

    }

    public function fetchJournalMonthly(){

        $sql = "SELECT YEAR(dateposted) AS year, MONTH(dateposted) AS month, COUNT(*) AS journal_count
        FROM `journal`
        GROUP BY YEAR(dateposted), MONTH(dateposted)
        ORDER BY YEAR(dateposted), MONTH(dateposted)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $monthlyData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $monthlyDataJson = json_encode($monthlyData);

        echo $monthlyDataJson;

    }


    #----------------------------------------------------------------
    #   Client Methods
    #----------------------------------------------------------------


    public function fetchJournals() {

        try {
            $sql = "SELECT * FROM `journal`";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            $output = array();
            $output['journal'] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data = [
                    "journalID" => $row['journalID'],
                    "journalname" => $row['journalname'],
                    "description" => strlen($row['description']) > 50 ? substr($row['description'], 0, 50)."..." : $row['description'],
                    "url" => $row['url'],
                    "imageurl" => $row['imageurl'],
                    "dateposted" => $row['dateposted']
                ];

                array_push($output['journal'], $data);
            }

            echo json_encode($output);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

    }

    public function deleteJournal($journal_id)
    {
        try {

            $sql = "DELETE FROM `journal` WHERE journalID = :jid";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":jid", $journal_id, PDO::PARAM_INT);
            if ($stmt->execute()){

                echo "true";

            }

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

}
