<?php
include "openconn.php";
session_start();

    $nEncomenda = htmlspecialchars($_POST["idEncomenda"]);
    echo $nEncomenda. "<br>";

    $delete_e = "DELETE FROM [dbo].[Encomenda] WHERE pedido = '{$nEncomenda}'";
    $res = sqlsrv_query($conn, $delete_e);
        if($res){
            echo "dados eleminados com sucesso";
            //header( "refresh:5; url=histEncomendas.php" );
            header("Location: histEncomendas.php");
        } else {
            echo "Erro: nao foi possivel apagar o item" . $query . "<br>" . mysqli_error($conn);
            //header( "refresh:5; url=histEncomendas.php" );
            header("Location: histEncomendas.php");
        }

sqlsrv_close($conn);

?>