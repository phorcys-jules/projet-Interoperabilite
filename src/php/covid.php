<?php
/*
$opts = array('http' => array('proxy'=> 'tcp://127.0.0.1:8080', 'request_fulluri'=> true));
$context = stream_context_create($opts);


stream_context_set_default($opts);
*/
// Récupération des données de géolocalisation
$ipURI = "http://ip-api.com/xml/?lang=fr";
$geolocData = simplexml_load_string(file_get_contents($ipURI));
$coo = $geolocData->lat . "," . $geolocData->lon;

echo $coo;




$filename = 'https://www.data.gouv.fr/fr/datasets/r/a1466f7f-4ece-4158-a373-f5d4db167eb0';
$data = [];

// open the file
$f = fopen($filename, 'r');

if ($f === false) {
	die('Cannot open the file ' . $filename);
}

// read each line in CSV file at a time
while (($row = fgetcsv($f)) !== false) {
	echo $row->jour;
}

// close the file
fclose($f);

echo 'csv';

?>

