<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Circulation</title>
  <link href="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css" rel="stylesheet">
  <script src="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script type="text/javascript">
    let map;
    //Affiche la carte centré sur la position en paramètre
    function afficherMap(lat, long) {
      console.log("display the map...");

      mapboxgl.accessToken = 'pk.eyJ1IjoicGhvcmN5cy1qdWxlcyIsImEiOiJja3k4bnhsN2wxZmtqMnZveWRoMTNieWFnIn0.NJPsNkYoDfVjAh11iCqEUQ';
      map = new mapboxgl.Map({
        container: 'map', // container ID
        style: 'mapbox://styles/mapbox/streets-v11', // style URL
        center: [long, lat], // starting position [lng, lat]
        zoom: 17 // starting zoom
      });
    }

    function createPoint(lat, long, p_titre, p_descritpion) {
      //console.log("place point...", lat, long, p_titre, p_descritpion);

      const geojson = {
        type: 'FeatureCollection',
        features: [{
          type: 'Feature',
          geometry: {
            type: 'Point',
            coordinates: [long, lat]
          },
          properties: {
            title: p_titre,
            description: p_descritpion
          }
        }]
      };

      // add markers to map
      for (const feature of geojson.features) {
        // create a HTML element for each feature
        const el = document.createElement('div');
        el.className = 'marker';

        // make a marker for each feature and add to the map
        new mapboxgl.Marker(el).setLngLat(feature.geometry.coordinates).addTo(map);
      }
    }
    let labels = [];
    let datas = [];
    let datas2 = [];
    
    function configChart(param) {
      param.forEach(function(item){
        //date
        labels.push(item[0]);
        //taux inci
        datas.push(item[1]);
        //nb cas >0
        datas2.push(item[2]);

      });
    }
  </script>
</head>
<link rel="stylesheet" href="../css/style.css">

<body>
  <div id="map">
  </div>

  <div id ="graph">
    <canvas id="myChart"></canvas>
  </div>

  <?php
  //Récupèration de la localisation de l'adresse de la mairie
  $address = "Mairie Notre dame des landes";
  $prepAddr = str_replace(' ', '+', $address);
  $geocode = file_get_contents('https://api-adresse.data.gouv.fr/search/?q=Mairie+Notre+Dames+des+Landes' . $prepAddr) or die("Impossible d'acceder aux services de géolocalisation");
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
  //var_dump($output->records);
  foreach ($output->records as $info) {
    $info = $info->fields;
    $lat = $info->localisation[0];
    $lon = $info->localisation[1];
    $titre = "'" . $info->nature . "'";
    $desc = "'" . $info->type . "'";
    $param = "(" . $lat . $lon . $titre . $desc . ")";
    //$param = $lat. $lon. $titre. $desc;
    echo "<script type='text/javascript'>createPoint($lat, $lon, $titre, $desc) ;</script>";

  }

  ?>


<?php
  //graphe covid

  //localisation avec proxi
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

  //parcourt csv
  while (($row = fgetcsv($f)) !== false) {
    if ($row[0] == '54') { 
      //date, taux incidence, nb positif
      array_push($data,[$row[1], $row[6], $row[14]]);
    }
  }
  $data = json_encode($data);
  echo "<script type='text/javascript'>configChart($data) ;</script>";


  //var_dump($data);

  // close the file
  fclose($f);
  ?>
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