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

function VerificarSeChegou($dataInicio, $data_atual, $duracao) {
    $data_entrega = date_add($dataInicio, date_interval_create_from_date_string("$duracao"));
    if (intval(date_diff(date_create($data_atual), $dataInicio)->format("%R%a days")) > intval(date_diff($data_entrega, $dataInicio)->format("%R%a days"))){
        return true;
    }
    return false;
}

function updateEncomenda($conn, $encomenda, $poluicao){
    $entrge_e = "UPDATE [dbo].[Encomenda] SET estado = 2, poluicao = '$poluicao', veiculo = null WHERE pedido = '{$encomenda}'";
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

function updateVeiculo($conn, $matricula){
    $entrege_V = "UPDATE [dbo].[Veiculo] SET produto = null, WHERE matriculo = '$matricula'";
    $res = sqlsrv_query($conn, $entrege_V);
    if($res){
        echo "veiculo esvaiado com sucesso";
        
    } else {
        echo "Erro: nao foi possivel esvaziar o veiculo" . $query . "<br>" . sqlsrv_errors($conn);
    }
}

function getDistance($addressFrom, $addressTo, $unit = ''){
    // Google API key
    $apiKey = 'AIzaSyAdJMAIwEnIJqbqAObKsygGg3XV1B9MuEQ';
    
    // Change address format
    $formattedAddrFrom = str_replace(' ', '+', $addressFrom);
    $formattedAddrTo = str_replace(' ', '+', $addressTo);
    
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
    #$time = $outputTo['rows'][0]['elements'][0]['duration']['value'];
    // Get latitude and longitude from the geodata
    $latitudeFrom = $outputFrom->results[0]->geometry->location->lat;
    $longitudeFrom = $outputFrom->results[0]->geometry->location->lng;
    $latitudeTo = $outputTo->results[0]->geometry->location->lat;
    $longitudeTo = $outputTo->results[0]->geometry->location->lng;
    
    // Calculate distance between latitude and longitude
    $theta = $longitudeFrom - $longitudeTo;
    $dist = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    
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

function calcDuracao($distancia){
    $intervalo = intval($distancia * 8/60);
    return "{$intervalo} hours";
    #date_add($data, date_interval_create_from_date_string("40 hours"));
}

function formataCodPostal($cod_postal){
    $codPostalA = str_split($cod_postal);
    $arraycodPostForm = array($codPostalA[0], $codPostalA[1], $codPostalA[2], $codPostalA[3], "-", $codPostalA[4], $codPostalA[5], $codPostalA[6]);
    echo implode($arraycodPostForm);
    return implode($arraycodPostForm);
}

function createNotificacao($conn, $consumidor, $data , $mensagem){
    $id = random_int(0, 9999);
    $to_insert = "INSERT INTO [dbo].[Notificacao] ([nid], [consumidor], [datatime], [mensagem]) VALUES ('$id', '$consumidor', '$data', '$mensagem')";
    $params = array(1, "inserir notificacao");
    $var = sqlsrv_query( $conn, $to_insert, $params);
        if( $var === false ) {
            die( print_r( sqlsrv_errors(), true));
    }
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
            //echo getDistance($codPostal_T, $codPostal_P, "k");
            $distancia1 = intval(getDistance($codPostal_T, $codPostal_P, "k"));
            $distancia2 = intval(getDistance($codPostal_P, $codPostal_C, "k"));
            $distancia_total = $distancia1 + $distancia2;
            $duracao_armazem = calcDuracao($distancia1);
            $duracaoEntrega = calcDuracao($distancia_total);
            $intDurac_arm = intval($duracao_armazem);
            $intDurac_entr = intval($duracaoEntrega);
            $poluicaoKm = poluicaoVeiculo($conn, $veiculo);
            $poluicaoTotal = intval($poluicaoKm * $distancia_total);
            $poluicao = $row['poluicao'] + $poluicaoTotal;
            if(VerificarSeChegou($dataInicio_entrega, $dataAtual, $duracao_armazem)){
                createNotificacao($conn, $consumidor, date_format(date_add($dataInicio_entrega, date_interval_create_from_date_string("$duracao_armazem")),"Y/m/d H:i:s")  , "O transporte chegou ao armazem e já tem o seu produto");
            }
            if(VerificarSeChegou($dataInicio_entrega, $dataAtual, $duracaoEntrega)){
                updateProduto($conn, $produto, $consumidor);
                updateVeiculo($conn, $matricula);
                updateEncomenda($conn, $encomenda, $poluicaoTotal);
                createNotificacao($conn, $consumidor, date_add($dataInicio_entrega, $duracaoEntrega) , "A sua encomenda Chegou!!!");
            }
        }
    }
sqlsrv_close($conn);

?>