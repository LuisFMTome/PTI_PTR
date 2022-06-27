<?php
include "openconn.php";
session_start();

if($_SESSION['tipo'] == "consumidor"){
    $location = "histEncomendas.php";
}elseif($_SESSION['tipo'] == "transportadora"){
    $location = "gerirVeiculos.php";
}elseif($_SESSION['tipo'] == "fornecedor"){
    $location = "histEncomendasFornecedor.php";
}

function codPostalTransportadora($conn, $veiculo) {
    $veiculo_query = "SELECT * FROM [dbo].[veiculo] WHERE matricula = '$veiculo'";
    $veiculo = sqlsrv_query($conn, $veiculo_query);
    $rowV = sqlsrv_fetch_array($veiculo);
    $nif_t = $rowV['transportadora'];
    $transportadora_query = "SELECT * FROM [dbo].[transportadora] WHERE nif = '$nif_t'";
    $transpotadora = sqlsrv_query($conn, $transportadora_query);
    $rowT = sqlsrv_fetch_array($transpotadora);
    $codPost_t = $rowT['codigoPostal'];
    return $codPost_t;
}

function codPostalProduto($conn, $idProduto) {
    $produto_query = "SELECT * FROM [dbo].[Produto] WHERE pid = '$idProduto'";
    $produto = sqlsrv_query($conn, $produto_query);
    $rowP = sqlsrv_fetch_array($produto);
    $codPos_p = $rowP['codigoPostal'];
    return $codPos_p;

}
function poluicaoVeiculo($conn, $veiculo) {
    $veiculo_query = "SELECT * FROM [dbo].[veiculo] WHERE matricula = '$veiculo'";
    $veiculo = sqlsrv_query($conn, $veiculo_query);
    $rowV = sqlsrv_fetch_array($veiculo);
    $policao_V = $rowV['poluicao'];
    return $policao_V;
}

function VerificarSeChegou($conn, $dataInicio, $data_atual, $duracao) {
    $data_entrega = date_add($dataInicio, $duracao);
    if (date_diff($data_atual, $dataInicio) > date_diff($data_entrega, $dataInicio)){
        return true;
    }
    return false;
}

function updateEncomenda($conn, $encomenda, $poluicao){
    $entrge_e = "UPDATE [dbo].[Encomenda] SET estado = 2, poluicao = '$poluicao' WHERE pedido = '{$encomenda}'";
    $res = sqlsrv_query($conn, $entrge_e);
    if($res){
        echo "encomenda entregue com sucesso";
        //header( "refresh:5; url=histEncomendas.php" );
        //header("Location: gerirVeiculos.php");
        //header("Location:" $location);
    } else {
        echo "Erro: nao foi possivel entregar a encomenda" . $query . "<br>" . sqlsrv_errors($conn);
        //header( "refresh:5; url=histEncomendas.php" );
        //header("Location: gerirVeiculos.php");
        //header("Location:" $location);
    }
}

function updateProduto($conn, $produto, $consumidor){
    $consumidor_query = "SELECT * FROM [dbo].[Consumidor] WHERE cid = '$consumidor'";
    $consumidor = sqlsrv_query($conn, $consumidor_query);
    $rowC = sqlsrv_fetch_array($consumidor);
    $codPostNovo = $rowC['codigoPostal'];
    $moradaNova = $rowC['morada'];
    $entrege_p = "UPDATE [dbo].[Produto] SET codigoPostal = '$codPostNovo', morada = '$moradaNova' WHERE pid = '{$produto}'";
    $res = sqlsrv_query($conn, $entrge_e);
    if($res){
        echo "encomenda entregue com sucesso";
        
    } else {
        echo "Erro: nao foi possivel entregar a encomenda" . $query . "<br>" . sqlsrv_errors($conn);
    }
}

function getDistance($addressFrom, $addressTo, $unit = ''){
    // Google API key
    $apiKey = 'AIzaSyAdJMAIwEnIJqbqAObKsygGg3XV1B9MuEQ';
    
    // Change address format
    $formattedAddrFrom    = str_replace(' ', '+', $addressFrom);
    $formattedAddrTo     = str_replace(' ', '+', $addressTo);
    
    // Geocoding API request with start address
    $geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$apiKey);
    $outputFrom = json_decode($geocodeFrom);
    if(!empty($outputFrom->error_message)){
        return $outputFrom->error_message;
    }
    
    // Geocoding API request with end address
    $geocodeTo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrTo.'&sensor=false&key='.$apiKey);
    $outputTo = json_decode($geocodeTo);
    if(!empty($outputTo->error_message)){
        return $outputTo->error_message;
    }
    
    // Get latitude and longitude from the geodata
    $latitudeFrom    = $outputFrom->results[0]->geometry->location->lat;
    $longitudeFrom    = $outputFrom->results[0]->geometry->location->lng;
    $latitudeTo        = $outputTo->results[0]->geometry->location->lat;
    $longitudeTo    = $outputTo->results[0]->geometry->location->lng;
    
    // Calculate distance between latitude and longitude
    $theta    = $longitudeFrom - $longitudeTo;
    $dist    = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
    $dist    = acos($dist);
    $dist    = rad2deg($dist);
    $miles    = $dist * 60 * 1.1515;
    
    // Convert unit and return distance
    $unit = strtoupper($unit);
    if($unit == "K"){
        return round($miles * 1.609344, 2).' km';
    }elseif($unit == "M"){
        return round($miles * 1609.344, 2).' meters';
    }else{
        return round($miles, 2).' miles';
    }
}
    
    #$addressFrom = 'Parque Eduardo VII, 1070-051 Lisboa';
    #$addressTo   = 'Praia da Falésia, Aldeia da Falésia, 8200-593 Albufeira';
    
    // Get distance in km
    #$distance = getDistance($addressFrom, $addressTo, "K");

function calcDuracao($conn, $distancia){

}

function formataCodPostal($cod_postal){
    $codPostalA = str_split($cod_postal);
    $arraycodPostForm = array($codPostalA[0], $codPostalA[1], $codPostalA[2], $codPostalA[3], "-", $codPostalA[4], $codPostalA[5], $codPostalA[6]);
    echo implode($arraycodPostForm);
    return implode($arraycodPostForm);
}

    $encomendas_query = "SELECT * FROM [dbo].[Encomenda] WHERE estado = 1";
    $encomendas = sqlsrv_query($conn, $encomendas_query);
    if (sqlsrv_has_rows($encomendas) != -1) {
        echo ("nao há encomendas nesse estado");
    } else {
        while($row = sqlsrv_fetch_array($encomendas)) {
            $encomenda = $row['pedido'];
            $dataInicio_entrega = $row['cancelamento'];
            $dataAtual = date("Y-m-d H:i:s");
            $veiculo = $row['veiculo'];
            $produto = $row['produto'];
            $consumidor = $row['consumidor'];
            $codPostal_T = codPostalTransportadora($conn, $veiculo);
            $codPostal_P = codPostalProduto($conn, $produto);
            $codPostal_C = $row['destino'];
            $distancia1 = getDistance($conn, $codPostal_T, $codPostal_P);
            $distancia2 = getDistance($conn, $codPostal_P, $codPostal_C);
            $distancia_total = $distancia1 + $distancia2;
            $duracaoEntrega = calcDuracao($conn, $distancia_total);
            $poluicaoKm = poluicaoVeiculo($conn, $veiculo);
            $poluicaoTotal = int($poluicaoKm * $distancia_total);
            $poluicao = $row['poluicao'] + $poluicaoTotal;
            if(VerificarSeChegou($conn, $dataInicio_entrega, $dataAtual, $duracaoEntrega)){
                updateProduto($conn, $produto, $consumidor);
                updateEncomenda($conn, $encomenda, $poluicaoTotal);
            }
            
            
        }
    }

sqlsrv_close($conn);

?>