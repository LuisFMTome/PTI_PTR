<?php 

function getDistDura($origin, $destination){

    //$origin = "1990-099"; 
    //$destination = "1990-091";
    $api = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=".$origin."&destinations=".$destination."&key=AIzaSyChUftFzx3IhtrNyiOtPgArFECMHKdzT7A");
    $data = json_decode($api);
    $dist = ((int)$data->rows[0]->elements[0]->distance->value / 1000);
    $dura = $data->rows[0]->elements[0]->duration->value; 

    return array($dist, $dura);
}

$boas = getDistDura("2050-294", "1400-069");

echo "<pre>";
print_r ($boas);
//print_r ($boas[1]);
echo "</pre>";

?>
