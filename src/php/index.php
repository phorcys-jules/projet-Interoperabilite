<?php
const URL_METEO_NANCY= 'https://www.infoclimat.fr/public-api/gfs/xml?_ll=48.67103,6.15083&_auth=ARsDFFIsBCZRfFtsD3lSe1Q8ADUPeVRzBHgFZgtuAH1UMQNgUTNcPlU5VClSfVZkUn8AYVxmVW0Eb1I2WylSLgFgA25SNwRuUT1bPw83UnlUeAB9DzFUcwR4BWMLYwBhVCkDb1EzXCBVOFQoUmNWZlJnAH9cfFVsBGRSPVs1UjEBZwNkUjIEYVE6WyYPIFJjVGUAZg9mVD4EbwVhCzMAMFQzA2JRMlw5VThUKFJiVmtSZQBpXGtVbwRlUjVbKVIuARsDFFIsBCZRfFtsD3lSe1QyAD4PZA%3D%3D&_c=19f3aa7d766b6ba91191c8be71dd1ab2';

echo "tentative d'accès à la météo de Nancy ".URL_METEO_NANCY."<br/>";
$xml = simpleXML_load_file(URL_METEO_NANCY,"SimpleXMLElement",LIBXML_NOCDATA);
if($xml ===  FALSE)
{
   echo "erreur impossible d'accèder à la météo de Nancy";
}
else { 
    echo $xml;
} 