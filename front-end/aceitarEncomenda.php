<?php
include "openconn.php";
session_start();

    $transportadora_query = "SELECT * FROM [dbo].[Transportadora] WHERE email= '$_SESSION[email]'";
    $transportadora = sqlsrv_query($conn, $transportadora_query);
    $row = sqlsrv_fetch_array($transportadora);
    $cod_postal = $row['codigoPostal'];

    $nEncomenda = htmlspecialchars($_POST["idEncomenda"]);
    echo $nEncomenda. "<br>";
    $data =  date("Y-m-d H:i:s"); 
    $aceitar_e = "UPDATE [dbo].[Encomenda] SET estado = 1, cancelamento = '$data' WHERE pedido = '{$nEncomenda}'";
    if($cod_postal != null || $cod_postal != ""){
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