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
        case 'editJournal';
            $journal = new Journal();
            $journal->editJournal($_POST['journalID'], $_POST['journalname'], $_POST['description'], $_POST['url'], $_POST['imageurl']);
           break;
        case 'fetchJournalMonthly':
            $journal = new Journal();
            $journal->fetchJournalMonthly();
            break;
        case 'deleteJournal':
            $journal = new Journal();
            $journal->deleteJournal($_POST['journal_id']);
            break;
        case 'addJournal':
            $journal = new Journal();
            $journal->addJournal($_POST['journalname'], $_POST['description'], $_POST['url'], $_POST['imageurl']);
            break;
        case 'fetchAllEbooksCrud':
            $ebooks = new Ebook();
            $ebooks->fetchAllEbooks();
            break;
        case 'fetchCategorySelection':
            $category = new EbookCategory();
            $category->makeSelection();
            break;
        case 'fetchEbookByIDCrud':
            $journal = new Ebook();
            $journal->fetchEbookByID($_POST['ebook_id']);
            break;
        case 'editEbook':
            $journal = new Ebook();
            $journal->editEbook($_POST['ebookID'], $_POST['catID'], $_POST['ebookname'], $_POST['description'], $_POST['url'], $_POST['imageurl']);
            break;
        case 'deleteEbook':
            $journal = new Ebook();
            $journal->deleteEbook($_POST['ebook_id']);
            break;
        case 'fetchCategoryCRUD':
            $category = new EbookCategory();
            $category->fetchAllCategory();
            break;
        case 'fetchCategoryByID':
            $category = new EbookCategory();
            $category->fetchCategoryByID($_POST['catID']);
            break;
        case 'editCategory':
            $category = new EbookCategory();
            $category->editCategory($_POST['catID'], $_POST['catname'], $_POST['description'], $_POST['image']);
            break;
        case 'deleteCategory':
            $category = new EbookCategory();
            $category->deleteCategory($_POST['catID']);
            break;
        default:
            echo "No action specified";
    }


}
