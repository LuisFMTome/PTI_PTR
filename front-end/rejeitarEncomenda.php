<?php
include "openconn.php";
session_start();

    $nEncomenda = htmlspecialchars($_POST["idEncomenda"]);
    $matricula = htmlspecialchars($_POST["matricula"]);
    echo $nEncomenda. "<br>";
    $rejeitar_prod = "UPDATE [dbo].[Veiculo] SET produto = null WHERE matricula = '{$matricula}'";
    $rejeitar_prod1 = "UPDATE [dbo].[Encomenda] SET veiculo = null WHERE pedido = '{$nEncomenda}'";
    $res = sqlsrv_query($conn, $rejeitar_prod);
    $res1 = sqlsrv_query($conn, $rejeitar_prod1);
        if($res){
            echo "encomenda rejeitada com sucesso";
            //header( "refresh:5; url=histEncomendas.php" );
            header("Location: gerirVeiculos.php");
        } else {
            echo "Erro: nao foi possivel rejeitar a encomenda" . $query . "<br>" . mysqli_errors();
            //header( "refresh:5; url=histEncomendas.php" );
            header("Location: gerirVeiculos.php");
        }
    
sqlsrv_close($conn);

?>