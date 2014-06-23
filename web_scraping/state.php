<?php
/**
	Web data scraping script for idengue.
	
	This script will perform data scraping from idengue.remotesensing.gov.my
	and store it into configured MySQL database.
*/

//MySQL database configuration
$host		=	"localhost";
$user		=	"root";
$password	=	"qwe123";
$dbname 	=	"dengue";

require('simple_html_dom.php');

$db = new PDO('mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8', $user, $password, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$db->exec("TRUNCATE TABLE state");

$url = "http://idengue.remotesensing.gov.my/idengue/lokaliti_wabakB.php";
$negeri = array('JOHOR','KEDAH','KELANTAN','MELAKA','NEGERI SEMBILAN','PAHANG','PERAK','PERLIS',
'PULAU PINANG','SABAH','SARAWAK','SELANGOR','TERENGGANU','WP KUALA LUMPUR','WP PUTRAJAYA','WP LABUAN');
/*$postdata = array (
    "negeri" => "WP PUTRAJAYA",
    "preview_button" => "Papar"
);*/

$req = curl_init($url);
curl_setopt($req, CURLOPT_POST, true);
//curl_setopt($req, CURLOPT_POSTFIELDS, $postdata);
foreach($negeri as $dtaNegeri){
curl_setopt($req, CURLOPT_POSTFIELDS, array("negeri" => $dtaNegeri, "preview_button" => "Papar"));
curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
$data = curl_exec($req);
$html = str_get_html($data);
//first check on no data. got exact match then skip for next state
//var_dump($html->find('script', 0)->innertext);
if(strlen($html->find('script', 0)->innertext) == 41){
	print "State Dengue information for $dtaNegeri is skipped (no data). <br />";
	continue;
}
foreach($html->find('table[id=contentpaneopen]') as $tbl){
	foreach($tbl->find('td') as $td){
		$aryData[] = $td->innertext;
	}
}
$aryChnk4 = array_chunk($aryData, 4);
//echo '<pre>';print_r($aryChnk4);echo '</pre>';
foreach($aryChnk4 as $dt){
$stmt = $db->prepare("INSERT INTO state(negeri, daerah, lokaliti) VALUES(:state,:area,:local_area)");
    try {
        $stmt->execute(array(':state' => trim(strip_tags($dt[1])), ':area' => $dt[2], ':local_area' => $dt[3]));
    } catch (PDOException $ex) {
        $ex->getMessage();
    }
}
unset($aryData);
unset($aryChnk4);
print "State Dengue information for $dtaNegeri copied successfully. <br />";
	}
