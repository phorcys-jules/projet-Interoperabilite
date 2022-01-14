<?php
const INFO_TRAFFIC= 'https://data.loire-atlantique.fr/api/records/1.0/search/?dataset=224400028_info-route-departementale&q=&facet=nature&facet=type&facet=datepublication&facet=ligne1&facet=ligne2';

$xmldata = file_get_contents(INFO_TRAFFIC) or die("Impossible de charger la météo");
$output = json_decode($xmldata);
//var_dump($output->records);
foreach ($output->records as $info) {
    $info = $info->fields;
    echo $info->localisation[0], $info->localisation[1], $info->nature, ' ', $info->type, '<br>';
}
?>

