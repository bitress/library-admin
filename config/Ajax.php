<?php

include_once 'init.php';

if(isset($_POST['action'])){

    $action = $_POST['action'];

    switch($action) {
        case 'fetchJournalsCRUD':
            $journal = new Journal();
            $journal->fetchAllJournal();
            break;
        case 'fetchJournalByIDCrud':
            $journal = new Journal();
            $journal->fetchJournalByID($_POST['journal_id']);
            break;
        default:
            echo "No action specified";
    }


}
