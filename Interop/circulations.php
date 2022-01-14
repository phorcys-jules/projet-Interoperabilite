<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Circulation</title>
  <link href="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/circulations.css">
  <script src="./js/circulations.js"></script>
  <script src="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</head>

<body>
   <h1>Les différents points de difficultés de circulation dans le département de Loire Atlantique</h1> 
        
  <div id="map">
  </div>

  <h1 id="titrecovid">Quelques infos concernant le COVID-19 dans votre département</h1> 

  <div id ="graph">
    <canvas id="myChart"></canvas>
  </div>

  <?php
  
  //Récupèration de la localisation de l'adresse de la mairie

  /*
  * Enlever prochain commentaire avant de deployer sur serveur
  */

  //stream_context_set_default(array('http' => array('proxy' => 'tcp://www-cache:3128', 'request_fulluri' => true), 'ssl' => array('verify_peer' => false, 'verify_peer_name' => false)));
  
  $address = "Mairie Notre dame des landes";
  $prepAddr = str_replace(' ', '+', $address);
  $geocode = file_get_contents('https://api-adresse.data.gouv.fr/search/?q=Mairie+Notre+Dames+des+Landes') or die("Impossible d'acceder aux services de géolocalisation");
  $output = json_decode($geocode);

  $latitude = $output->features[0]->geometry->coordinates[1];
  $longitude = $output->features[0]->geometry->coordinates[0];
  $titre = 'le point point';
  $description = 'ceci est la description';

  //création de la carte
  echo "<script type='text/javascript'>afficherMap(${latitude}, ${longitude});</script>";



  //placement des points : 
  const INFO_TRAFFIC = 'https://data.loire-atlantique.fr/api/records/1.0/search/?dataset=224400028_info-route-departementale&q=&facet=nature&facet=type&facet=datepublication&facet=ligne1&facet=ligne2';

  $xmldata = file_get_contents(INFO_TRAFFIC) or die("Impossible de charger la météo");
  $output = json_decode($xmldata);
  foreach ($output->records as $info) {
    $info = $info->fields;
    $lat = $info->localisation[0];
    $lon = $info->localisation[1];
    $titre = "'" . $info->nature . "'";
    $desc = "'" . $info->type . "'";
    $param = "(" . $lat . $lon . $titre . $desc . ")";
    echo "<script type='text/javascript'>createPoint($lat, $lon, $titre, $desc) ;</script>";

  }

  ?>


<?php
  //graphe covid

  //localisation avec proxi


  // Récupération des données de géolocalisation

  /*
  * Enlever prochain commentaire avant de deployer sur serveur
  */


  //stream_context_set_default(array('http' => array('proxy' => 'tcp://www-cache:3128', 'request_fulluri' => true), 'ssl' => array('verify_peer' => false, 'verify_peer_name' => false)));

  $ipURI = "http://ip-api.com/xml/?lang=fr";
  $geolocData = simplexml_load_string(file_get_contents($ipURI));
  $coo = $geolocData->lat . "," . $geolocData->lon;
  $dep = $geolocData->zip;
  $dep = substr($dep,0, 2);
  echo 'VOUS ETES LOCALISES DANS LE DEPARTEMENT : '.$dep.'<br>';


  $filename = 'https://www.data.gouv.fr/fr/datasets/r/5c4e1452-3850-4b59-b11c-3dd51d7fb8b5';
  $data = [];

  // open the file
  $f = fopen($filename, 'r');

  if ($f === false) {
    die('Cannot open the file ' . $filename);
  }

  //parcourt csv
  while (($row = fgetcsv($f)) !== false) {
    if ($row[0] == $dep) { 
      //date, taux incidence, nb positif
      array_push($data,[$row[1], $row[6], $row[14]]);
    }
  }
  $data = json_encode($data);
  echo "<script type='text/javascript'>configChart($data) ;</script>";



  // close the file
  fclose($f);
  ?>
  <div id="endcontent">
    <h4>Les différentes API utilisés :</h4>
      <ul>
            <li><a href="http://ip-api.com/xml/?lang=fr">http://ip-api.com/xml/?lang=fr</a></li>
            <li><a href="https://www.data.gouv.fr/fr/datasets/r/5c4e1452-3850-4b59-b11c-3dd51d7fb8b5">https://www.data.gouv.fr/fr/datasets/r/5c4e1452-3850-4b59-b11c-3dd51d7fb8b5</a></li>
            <li><a href="https://api.mapbox.com/styles/v1/">https://api.mapbox.com/styles/v1/</a></li>
            <li><a href="https://data.loire-atlantique.fr/api/records/1.0/search/?dataset=224400028_info-route-departementale&q=&facet=nature&facet=type&facet=datepublication&facet=ligne1&facet=ligne2">https://data.loire-atlantique.fr/api/records/1.0/search/?dataset=224400028_info-route-departementale&q=&facet=nature&facet=type&facet=datepublication&facet=ligne1&facet=ligne2</a></li>
            <li><a href="https://api-adresse.data.gouv.fr/search/?q=Mairie+Notre+Dames+des+Landes">https://api-adresse.data.gouv.fr/search/?q=Mairie+Notre+Dames+des+Landes</a></li>
            <li><a href="https://cdn.jsdelivr.net/npm/chart.js">https://cdn.jsdelivr.net/npm/chart.js</a></li>

      </ul>
    <footer>
            WILT Lilian | FRANCOIS Jules | MANGENOT Alex - LP CIASIE 2 / Interopérabilité
    </footer>
  </div>
</body>

<script>
     
    const data = {
      labels: labels,
      datasets: [{
        label: "Taux d'incidencede de la pandémie de Covid-19 pour 100 000 habitants",
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: datas,
        yAxisID: 'y',
      },
      {
        label: "Nombre de nouvelles hospitalisations",
        backgroundColor: 'rgb(0, 99, 132)',
        borderColor: 'rgb(0, 99, 132)',
        data: datas2,
        yAxisID: 'y1',
      }]
    };
    const config = {
      type: 'line',
      data: data,
      options: {
        responsive: true,
        interaction: {
          mode: 'index',
          intersect: false,
        },
        stacked: false,
        plugins: {
          title: {
            display: true,
            text: 'Information pandémie covid 19 dans votre département'
          }
        },
        scales: {
          y: {
            type: 'linear',
            display: true,
            position: 'left',
          },
          y1: {
            type: 'linear',
            display: true,
            position: 'right',
            fill:true,

            // grid line settings
            grid: {
              drawOnChartArea: false, // only want the grid lines for one axis to show up
            },
          },
        }
      },
    };

  var myChart = new Chart(
    document.getElementById('myChart'),
    config
  );
</script>




</html>