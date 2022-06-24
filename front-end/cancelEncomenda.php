<?php
include "openconn.php";
session_start();

    $nEncomenda = htmlspecialchars($_POST["idEncomenda"]);
    echo $nEncomenda. "<br>";

    #$delete_e = "DELETE FROM [dbo].[Encomenda] WHERE pedido = '{$nEncomenda}'";
    $cancel_e = "UPDATE [dbo].[Encomenda] SET estado = 3 WHERE pedido = '{$nEncomenda}'";

    $res = sqlsrv_query($conn, $cancel_e);
        if($res){
            echo "encomenda cancelada com sucesso";
            //header( "refresh:5; url=histEncomendas.php" );
            header("Location: histEncomendas.php");
        } else {
            echo "Erro: nao foi possivel cancelada a encomenda" . $query . "<br>" . mysqli_error($conn);
            //header( "refresh:5; url=histEncomendas.php" );
            header("Location: histEncomendas.php");
        }

sqlsrv_close($conn);

?>