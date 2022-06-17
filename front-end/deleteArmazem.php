<?php
include "openconn.php";
session_start();

$id = $_GET['id'];

echo $id;

#ir buscar morada
$morada_check_query = "SELECT * FROM [dbo].[Armazem] WHERE aid='$id'";
$armazens = sqlsrv_query($conn, $morada_check_query);
$row1 = sqlsrv_fetch_array($armazens);

echo $row1['morada'];

$produtos_query = "SELECT * FROM [dbo].[Produto] WHERE morada= '$row1'";
$produtos = sqlsrv_query($conn, $produtos_query, array(), array( "Scrollable" => 'static' ));
$N_produtos = sqlsrv_num_rows($produtos);

echo $N_produtos;

if ($N_produtos === 0) {

    $delete_A = "DELETE FROM [dbo].[Armazem] WHERE aid = '{$id}'";
    $apagar = sqlsrv_query($conn, $delete_A);
    if($apagar){
        echo "dados eleminados com sucesso";
        header('location: registoArmazem.php');
    } else {
        echo "Erro: nao foi possivel apagar Armazem" . $query . "<br>" . mysqli_error($conn);
        header('location: registoArmazem.php');
    }

}else{

    $_SESSION["status"] = "Ainda tem produtos nesse armazem";
    echo "tou mal";
    header('location: registoArmazem.php');

}

/** 

**/

?>