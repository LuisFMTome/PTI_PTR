<?php
include "openconn.php";
session_start();

$id = $_GET['id'];

#echo $matricula;

$delete_V = "DELETE FROM [dbo].[Produto] WHERE pid = '{$id}'";
$apagar = sqlsrv_query($conn, $delete_V);
if($apagar){
    $_SESSION['statusCode'] = "success";
    $_SESSION['status'] = "Produto eliminado com sucesso";
    header('location: registoProduto.php');
} else {
    echo "Erro: nao foi possivel apagar Fornecedor" . $query . "<br>" . mysqli_error($conn);
    header('location: registoProduto.php');
}

?>