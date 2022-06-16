<?php
include "openconn.php";
session_start();

$id = $_GET['id'];

echo $id;

$delete_A = "DELETE FROM [dbo].[Armazem] WHERE aid = '{$id}'";
$apagar = sqlsrv_query($conn, $delete_A);
if($apagar){
    echo "dados eleminados com sucesso";
    header('location: registoArmazem.php');
} else {
    echo "Erro: nao foi possivel apagar Fornecedor" . $query . "<br>" . mysqli_error($conn);
    header('location: registoArmazem.php');
}

?>