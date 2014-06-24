<?php

/**
  Web data scraping script for idengue.

  This script will perform daily dengue data scraping from idengue.remotesensing.gov.my
  and store it into configured MySQL database.
 */
//MySQL database configuration
$host = "localhost";
$user = "root";
$password = "qwe123";
$dbname = "dengue";

require('simple_html_dom.php');

$db = new PDO('mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8', $user, $password, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$db->exec("TRUNCATE TABLE daily");

$html = file_get_html('http://idengue.remotesensing.gov.my/idengue/index.php');
foreach ($html->find('div table[width=350]') as $tbl) {
    foreach ($tbl->find('td') as $td) {
        $aryData[] = $td->innertext;
    }
}

$aryChunk3 = array_chunk($aryData, 3);
foreach ($aryChunk3 as $ste) {
    $stmt = $db->prepare("INSERT INTO harian_daily(negeri, jumlah_kes, kawasan_berisiko) VALUES(:state,:case_count,:risk_area_count)");
    try {
        $stmt->execute(array(':state' => trim(strip_tags($ste[0])), ':case_count' => $ste[1], ':risk_area_count' => $ste[2]));
    } catch (PDOException $ex) {
        $ex->getMessage();
    }
}

print "Daily Dengue information copied successfully.";
