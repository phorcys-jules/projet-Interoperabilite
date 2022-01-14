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
      console.log("place point...", lat, long, p_titre, p_descritpion);

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


    const labels = [
      'January',
      'February',
      'March',
      'April',
      'May',
      'June',
    ];
    const data = {
      labels: labels,
      datasets: [{
        label: 'My First dataset',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [0, 10, 5, 2, 20, 30, 45],
      }]
    };
    const config = {
      type: 'line',
      data,
      options: {}
    };
    // === include 'setup' then 'config' above ===
  </script>
</head>
<link rel="stylesheet" href="../css/style.css">

<body>
  <div id="map">


  </div>

  <div>
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
  //echo "<script type='text/javascript'>afficherMap(${latitude}, ${longitude});</script>";



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
    //echo "<script type='text/javascript'>createPoint($lat, $lon, $titre, $desc) ;</script>";
    //$format = '<script type="text/javascript">createPoint(%d, %d, %s, %s) ;</script>';

    // echo sprintf($format, $lat, $lon, $titre, $desc);
  }

  ?>

</body>

<script>
  var myChart = new Chart(
    document.getElementById('myChart'),
    config
  );
</script>




</html>