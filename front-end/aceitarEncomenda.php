<?php
include "openconn.php";
session_start();

function getDistanceDuration($origin, $destination){
    //$origin = "1990-099"; 
    //$destination = "1990-091";
    $api = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=".$origin."&destinations=".$destination."&key=AIzaSyChUftFzx3IhtrNyiOtPgArFECMHKdzT7A");
    $data = json_decode($api);
    #print_r($data);
    $dist = ((int)$data->rows[0]->elements[0]->distance->value / 1000);
    $dura = $data->rows[0]->elements[0]->duration->text; 

    $arrayF = array(
        'distancia' => $dist,
        'duracao' => $dura
    );

    return ($arrayF);
}

function formataCodPostal($cod_postal){
    $codPostalA = str_split($cod_postal);
    $arraycodPostForm = array($codPostalA[0], $codPostalA[1], $codPostalA[2], $codPostalA[3], "-", $codPostalA[4], $codPostalA[5], $codPostalA[6]);
    #echo implode($arraycodPostForm) . "<br>";
    return implode($arraycodPostForm);
}

$transportadora_query = "SELECT * FROM [dbo].[Transportadora] WHERE email= '$_SESSION[email]'";
$transportadora = sqlsrv_query($conn, $transportadora_query);
$row = sqlsrv_fetch_array($transportadora);
$cod_postal = $row['codigoPostal'];

$nEncomenda = htmlspecialchars($_POST["idEncomenda"]);
//echo $nEncomenda. "<br>";
$data =  date("Y-m-d H:i:s"); 
$aceitar_e = "UPDATE [dbo].[Encomenda] SET estado = 1, cancelamento = '$data' WHERE pedido = '{$nEncomenda}'";
    if($cod_postal != null || $cod_postal != ""){

        //###############################################################################################
        //criar notificacao para o fornecedor

        $produtoEnc = "SELECT * FROM [dbo].[Encomenda] WHERE pedido='{$nEncomenda}'";
        $ProdutoE = sqlsrv_query($conn, $produtoEnc);
        if( $ProdutoE === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_fetch( $ProdutoE ) === false) {
            die( print_r( sqlsrv_errors(), true));
        }
        $prodId = sqlsrv_get_field( $ProdutoE, 4);
        //echo "prod : " . $prodId;

        $cPostalEnc_query = "SELECT * FROM [dbo].[Produto] WHERE pid='{$prodId}'";
        $cPostalEnc = sqlsrv_query($conn, $cPostalEnc_query);
        if( $cPostalEnc === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_fetch( $cPostalEnc ) === false) {
            die( print_r( sqlsrv_errors(), true));
        }
        $prod_cpostalEnc = sqlsrv_get_field( $cPostalEnc, 3);
        //echo "sPostal : " . $prod_cpostalEnc;

        //echo "cPostal Pasrtido: " . formataCodPostal($prod_cpostalEnc);

        $armazem_notif_query = "SELECT * FROM [dbo].[Armazem] WHERE codigoPostal='{$prod_cpostalEnc}'";
        $armaz_notif = sqlsrv_query($conn, $armazem_notif_query);
        if( $armaz_notif === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_fetch( $armaz_notif ) === false) {
            die( print_r( sqlsrv_errors(), true));
        }
        $fornecedorNotif = sqlsrv_get_field( $armaz_notif, 1);
        //echo "forne: " . $fornecedorNotif;

        $nid = random_int(0, 9000);
        $data =  date("Y-m-d H:i:s");
        $mensagem = "O Veiculo ja esta a caminho do armazem";

        $to_insertNotif = "INSERT INTO [dbo].[Notificacao] ([nid], [utilizador], [datatime], [mensagem]) VALUES ('$nid', '$fornecedorNotif', '$data', '$mensagem')"; 

        $params = array(1, "inserir notificacao");
        $var = sqlsrv_query( $conn, $to_insertNotif, $params);

        if( $var === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        //###############################################################################################

        //###############################################################################################
        //criar notificacao para o Consumidor
        $consum_notif_query = "SELECT * FROM [dbo].[Encomenda] WHERE pedido='{$nEncomenda}'";
        $consum_notif = sqlsrv_query($conn, $consum_notif_query);
        if( $consum_notif === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_fetch( $consum_notif ) === false) {
            die( print_r( sqlsrv_errors(), true));
        }
        $consumNotif = sqlsrv_get_field( $consum_notif, 1);
        //echo "consum: " . $consumNotif;

        $nid = random_int(0, 9000);
        $data =  date("Y-m-d H:i:s");
        $mensagem = "O Veiculo ja esta a caminho do armazem";

        $to_insertNotif = "INSERT INTO [dbo].[Notificacao] ([nid], [utilizador], [datatime], [mensagem]) VALUES ('$nid', '$consumNotif', '$data', '$mensagem')"; 

        $params = array(1, "inserir notificacao");
        $var = sqlsrv_query( $conn, $to_insertNotif, $params);

        if( $var === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        //###############################################################################################

        //###############################################################################################

        //notificacao ao fornecedor quando o carro chega ao armazem


        //transportadora
        
        $origemEnc = $cod_postal;
        //echo "origem: " . $origemEnc;

        //armazem

        $produtoEnc = "SELECT * FROM [dbo].[Encomenda] WHERE pedido='{$nEncomenda}'";
        $ProdutoE = sqlsrv_query($conn, $produtoEnc);
        if( $ProdutoE === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_fetch( $ProdutoE ) === false) {
            die( print_r( sqlsrv_errors(), true));
        }
        $produtoArm = sqlsrv_get_field( $ProdutoE, 4);

        $produtoEnc_query = "SELECT * FROM [dbo].[Produto] WHERE pid='{$produtoArm}'";
        $ProdutoEdest = sqlsrv_query($conn, $produtoEnc_query);
        if( $ProdutoEdest === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_fetch( $ProdutoEdest ) === false) {
            die( print_r( sqlsrv_errors(), true));
        }
        $destArmazem = sqlsrv_get_field( $ProdutoEdest, 3);

        $origem = formataCodPostal($origemEnc);
        $destino = formataCodPostal($destArmazem);

        $arrayTemp = getDistanceDuration($origem, $destino);
        //echo "distancia: " . (int)$arrayTemp["distancia"];
        //echo "duracao: " . $arrayTemp["duracao"];

        $data =  date("Y-m-d H:i:s");
        $dataAteArm = date_add(date_create($data),date_interval_create_from_date_string($arrayTemp['duracao']));
        if( $dataAteArm === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $dataAteArmFinal = date_format($dataAteArm,"Y-m-d H:i:s");
        //echo $dataAteArmFinal;

        $nid = random_int(0, 9000);
        //$data =  date("Y-m-d H:i:s");
        $mensagem = "O Veiculo ja chegou ao armazem armazem";

        $to_insertNotif = "INSERT INTO [dbo].[Notificacao] ([nid], [utilizador], [datatime], [mensagem]) VALUES ('$nid', '$consumNotif', '$dataAteArmFinal', '$mensagem')"; 

        $params = array(1, "inserir notificacao");
        $var = sqlsrv_query( $conn, $to_insertNotif, $params);

        if( $var === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        //echo $dataAteArmFinal;

        $nid = random_int(0, 9000);
        //$data =  date("Y-m-d H:i:s");
        $mensagem = "O Veiculo ja chegou ao armazem armazem";

        $to_insertNotif = "INSERT INTO [dbo].[Notificacao] ([nid], [utilizador], [datatime], [mensagem]) VALUES ('$nid', '$fornecedorNotif', '$dataAteArmFinal', '$mensagem')"; 

        $params = array(1, "inserir notificacao");
        $var = sqlsrv_query( $conn, $to_insertNotif, $params);

        if( $var === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        //###############################################################################################

        //###############################################################################################

        //notificacao de quando chega ao consumidor

        $produtoEncIni = "SELECT * FROM [dbo].[Encomenda] WHERE pedido='{$nEncomenda}'";
        $ProdutoEIni = sqlsrv_query($conn, $produtoEncIni);
        if( $ProdutoEIni === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_fetch( $ProdutoEIni ) === false) {
            die( print_r( sqlsrv_errors(), true));
        }
        $origemIni = sqlsrv_get_field( $ProdutoEIni, 2);

        $produtoEncFini = "SELECT * FROM [dbo].[Encomenda] WHERE pedido='{$nEncomenda}'";
        $ProdutoEFini = sqlsrv_query($conn, $produtoEncFini);
        if( $ProdutoEFini === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_fetch( $ProdutoEFini ) === false) {
            die( print_r( sqlsrv_errors(), true));
        }
        $destinoFini = sqlsrv_get_field( $ProdutoEFini, 3);

        $arrayTemp2 = getDistanceDuration(formataCodPostal($origemIni), formataCodPostal($destinoFini));
        //echo "duration: " . $arrayTemp2['duracao'];

        $dataAteArm2 = date_add($dataAteArm,date_interval_create_from_date_string($arrayTemp2['duracao']));
        if( $dataAteArm2 === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $segundaDuracao = date_format($dataAteArm2,"Y-m-d H:i:s");
        echo $segundaDuracao;

        //fornecedor
        $nid = random_int(0, 9000);
        //$data =  date("Y-m-d H:i:s");
        $mensagem = "O Veiculo ja deixou a encomenda no consumidor";

        $to_insertNotif = "INSERT INTO [dbo].[Notificacao] ([nid], [utilizador], [datatime], [mensagem]) VALUES ('$nid', '$fornecedorNotif', '$segundaDuracao', '$mensagem')"; 

        $params = array(1, "inserir notificacao");
        $var = sqlsrv_query( $conn, $to_insertNotif, $params);

        if( $var === false ) {
            die( print_r( sqlsrv_errors(), true));
        }


        //consumidor
        $nid = random_int(0, 9000);
        //$data =  date("Y-m-d H:i:s");
        $mensagem = "O Veiculo ja deixou a encomenda no consumidor";

        $to_insertNotif = "INSERT INTO [dbo].[Notificacao] ([nid], [utilizador], [datatime], [mensagem]) VALUES ('$nid', '$consumNotif', '$segundaDuracao', '$mensagem')"; 

        $params = array(1, "inserir notificacao");
        $var = sqlsrv_query( $conn, $to_insertNotif, $params);

        if( $var === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        //###############################################################################################

        $res = sqlsrv_query($conn, $aceitar_e);
        if($res){
            echo "encomenda aceite com sucesso";
            //header( "refresh:5; url=histEncomendas.php" );
            header("Location: gerirVeiculos.php");
        } else {
            echo "Erro: nao foi possivel aceitadar a encomenda" . $query . "<br>" . mysqli_error($conn);
            //header( "refresh:5; url=histEncomendas.php" );
            header("Location: gerirVeiculos.php");
        }

    }else{
        echo "não tem definido codigo postal na sua conta";
        $_SESSION['status'] = "Tem que definir o Código Postal no Perfil antes de fazer encomendas";
        $_SESSION['statusCode'] = "error";
        header("Location: gerirVeiculos.php");
    }
    

sqlsrv_close($conn);

?>