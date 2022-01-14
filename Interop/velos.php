<?php

/*
    Dans un premier temps, en local, j'utilise $adresseIP = "176.134.136.84" (IP trouvé grâce à https://ipapi.co/).
    Mais j'utilise $adresseIP = $_SERVER['REMOTE_ADDR'] lorsque mon projet est stocké sur un serveur, comme Webetu.
*/
    $adresseIP = "176.134.136.84";
    //$adresseIP = $_SERVER['REMOTE_ADDR'];
    
    $opts1 = array('http' =>
        array(
            //'proxy' => 'tcp://www-cache:3128',
            //'request_fulluri' => true,
            'method' => 'GET',
            'header' => 'Content-type: application/json',
        )
    );
    $opts2 = array('http' =>
        array(
            //'proxy' => 'tcp://www-cache:3128',
            //'request_fulluri' => true,
            'method' => 'GET',
            'header' => 'Content-type: application/xml',
        )
    );
    $context1 = stream_context_create($opts1);
    $context2 = stream_context_create($opts2);
    
    $velo = simplexml_load_string(file_get_contents("http://www.velostanlib.fr/service/carto", false, $context2));    
    
    $list = array();
    for ($i=1; $i < sizeof($velo->markers->marker) ; $i++) {
        $list[]= simplexml_load_string(file_get_contents("http://www.velostanlib.fr/service/stationdetails/nancy/".$i, false, $context2));
    }
    $jsdispo = json_encode($list);
    $jsarray = json_encode($velo->markers);
    echo '<div id="stations" style="display: none;">' . $jsarray .' </div>';
    echo '<div id="dispodata" style="display: none;">' . $jsdispo .' </div>';

    $json = file_get_contents('http://ip-api.com/json/', false, $context1);
    $result = json_decode($json, true);
    $latitude = $result['lat'];
    $longitude = $result['lon'];
    $xml = file_get_contents('https://www.infoclimat.fr/public-api/gfs/xml?_ll='. $latitude .','. $longitude .'&_auth=ARsDFFIsBCZRfFtsD3lSe1Q8ADUPeVRzBHgFZgtuAH1UMQNgUTNcPlU5VClSfVZkUn8AYVxmVW0Eb1I2WylSLgFgA25SNwRuUT1bPw83UnlUeAB9DzFUcwR4BWMLYwBhVCkDb1EzXCBVOFQoUmNWZlJnAH9cfFVsBGRSPVs1UjEBZwNkUjIEYVE6WyYPIFJjVGUAZg9mVD4EbwVhCzMAMFQzA2JRMlw5VThUKFJiVmtSZQBpXGtVbwRlUjVbKVIuARsDFFIsBCZRfFtsD3lSe1QyAD4PZA%3D%3D&_c=19f3aa7d766b6ba91191c8be71dd1ab2', false, $context2);
    $obj_xml = simplexml_load_string($xml);
    $xsl = new DOMDocument;
    $xsl->load('./xsl/meteo.xsl');
    $proc = new XSLTProcessor;
    $proc->importStyleSheet($xsl);
    $html = $proc->transformToXML($obj_xml);

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>On m'a volé mon vélo</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
              integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
              crossorigin=""/>
        <link href="./css/velos.css" rel="stylesheet">
        <script src="./js/velos.js"></script>
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
                integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
                crossorigin=""></script>
    </head>
    <body>
        <h1>
            Prévisions météo de la ville de <span id="ville"></span> :
        </h1>
        
        <div id="weather">
            <?php echo $html; ?>
        </div>
        
        <p hidden>IP : <span id="loc"><?php echo $adresseIP; ?></span></p>
        
        <h1>Carte des parkings velolib à Nancy :</h1>
        <div id="map">

        </div>
        <h4>Les différentes API utilisés :</h4>
        <ul>
            <li><a href="http://ip-api.com/json/">http://ip-api.com/json/</a></li>
            <li><a href="https://ipapi.co/">https://ipapi.co/</a></li>
            <li><a href="https://api.mapbox.com/styles/v1/">https://api.mapbox.com/styles/v1/</a></li>
            <li><a href="https://www.infoclimat.fr/public-api/gfs/xml">https://www.infoclimat.fr/public-api/gfs/xml</a></li>
            <li><a href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js">https://unpkg.com/leaflet@1.7.1/dist/leaflet.js</a></li>
            <li><a href="http://www.velostanlib.fr/service/carto">http://www.velostanlib.fr/service/carto</a></li>
            <li><a href="http://www.velostanlib.fr/service/stationdetails/nancy/">http://www.velostanlib.fr/service/stationdetails/nancy/</a></li>
        </ul>
        <footer>
            WILT LILIAN - LP CIASIE 2 / Interopérabilité
        </footer>
    </body>
</html>