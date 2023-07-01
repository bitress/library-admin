<?php
include_once 'config/init.php';

$journal = new Journal();

$journal->fetchJournalByID(1);