<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Circulation</title>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js"></script>
    <script type="text/javascript" >
        //Affiche la carte centré sur la position en paramètre
        function afficherMap(lat, long) {
            console.log("display the map...");
            
            mapboxgl.accessToken = 'pk.eyJ1IjoicGhvcmN5cy1qdWxlcyIsImEiOiJja3k4bnhsN2wxZmtqMnZveWRoMTNieWFnIn0.NJPsNkYoDfVjAh11iCqEUQ';
            let map = new mapboxgl.Map({
                container: 'map', // container ID
                style: 'mapbox://styles/mapbox/streets-v11', // style URL
                center: [long, lat], // starting position [lng, lat]
                zoom: 17 // starting zoom
            });
        }

        function createPoint(lat, long, titre) {
          console.log("place point...");

          const geojson = {
              type: 'FeatureCollection',
              features: [
                {
                  type: 'Feature',
                  geometry: {
                    type: 'Point',
                    coordinates: [-77.032, 38.913]
                  },
                  properties: {
                    title: titre,
                    description: 'Washington, D.C.'
                  }
                }
              ]
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
            
            

    </script>
</head>
<link rel="stylesheet" href="../css/style.css">
<body>
    <div id="map">


    </div>
    
    
    <?php
        //Récupèration de la localisation de l'adresse de la mairie
        $address ="Mairie Notre dame des landes";
        $prepAddr = str_replace(' ','+',$address);
        $geocode=file_get_contents('https://api-adresse.data.gouv.fr/search/?q=Mairie+Notre+Dames+des+Landes'.$prepAddr) or die("Impossible d'acceder aux services de géolocalisation");
        $output= json_decode($geocode);

        $latitude = $output->features[0]->geometry->coordinates[1];
        $longitude = $output->features[0]->geometry->coordinates[0];
        $titre = "le point point";

        //création de la carte
        echo "<script type='text/javascript'>afficherMap(${latitude}, ${longitude});</script>";
        echo "<script type='text/javascript'>createPoint(${latitude}, ${longitude}, ${titre});</script>";
       
    ?>

</body>





</html>