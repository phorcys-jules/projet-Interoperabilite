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
$dep = $geolocData->zip;
$dep = substr($dep,0, 2);
echo 'Vous avez été localisé dans le departement '.$dep.'<br>';




$filename = 'https://www.data.gouv.fr/fr/datasets/r/5c4e1452-3850-4b59-b11c-3dd51d7fb8b5';
$data = [];

// open the file
$f = fopen($filename, 'r');

if ($f === false) {
	die('Cannot open the file ' . $filename);
}

// read each line in CSV file at a time
while (($row = fgetcsv($f)) !== false) {
	if ($row[0] == '54') { 
		//date, taux incidence, nb positif
		array_push($data,[$row[1], $row[7], $row[20]]);
	}
}

var_dump($data);

// close the file
fclose($f);

?>

