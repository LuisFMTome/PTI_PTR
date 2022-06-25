<?php
include "openconn.php";
session_start();

    $nEncomenda = htmlspecialchars($_POST["idEncomenda"]);
    echo $nEncomenda. "<br>";
    $data =  date("Y-m-d H:i:s"); 
    $aceitar_e = "UPDATE [dbo].[Encomenda] SET estado = 1, cancelamento = '$data' WHERE pedido = '{$nEncomenda}'";

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

sqlsrv_close($conn);

?>