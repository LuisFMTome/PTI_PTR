<?php
include "openconn.php";
session_start();

    $itemType = $_SESSION["itemType"];
    $itemId = htmlspecialchars($_POST["itemId"]);
    echo $itemType. "<br>";
    echo $itemId. "<br>";

    if($itemType == "armazem"){
    $delete_a = "DELETE FROM [dbo].[Armazem] WHERE aid = '{$itemId}'";
    $res = sqlsrv_query($conn, $delete_a);
        if($res){
            echo "dados eleminados com sucesso";
            header( "refresh:5; url=registoArmazem.php" );
        } else {
            echo "Erro: nao foi possivel apagar o item" . $query . "<br>" . mysqli_error($conn);
            header( "refresh:5; url=registoArmazem.php" );
        }
    
    
    }elseif($itemType == "produto"){
        $delete_p = "DELETE FROM [dbo].[Produto] WHERE pid = '{$itemId}'";
        $res = sqlsrv_query($conn, $delete_p);
            if($res){
                echo "dados eleminados com sucesso";
                header( "refresh:5; url=registoProduto.php" );
            } else {
                echo "Erro: nao foi possivel apagar o item" . $query . "<br>" . mysqli_error($conn);
                header( "refresh:5; url=registoProduto.php" );
            }

    }elseif($itemType == "tranporte"){
        $delete_t = "DELETE FROM [dbo].[Veiculo] WHERE matricula = '{$itemId}'";
        $res = sqlsrv_query($conn, $delete_t);
        if($res){
            echo "dados eleminados com sucesso";
            header( "refresh:5; url=registoTransportes.php" );
        } else {
            echo "Erro: nao foi possivel apagar o item" . $query . "<br>" . mysqli_error($conn);
            header( "refresh:5; url=registoTransportes.php" );
        }
    }else{
    echo "Tipo de Utilizador inexistente";
    }

sqlsrv_close($conn);

?>