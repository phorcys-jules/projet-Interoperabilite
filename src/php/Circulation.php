<?php


$address ="Notre dame des landes";
$prepAddr = str_replace(' ','+',$address);
$geocode=file_get_contents('https://api-adresse.data.gouv.fr/search/?q=Mairie+Notre+Dames+des+Landes'.$prepAddr) or die("Impossible d'acceder aux services de géolocalisation");
$output= json_decode($geocode);

$latitude = $output->features[0]->geometry->coordinates[0];
$longitude = $output->features[0]->geometry->coordinates[1];


echo $latitude.'<br>';
echo $longitude;
?>