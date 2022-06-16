<?php
include "openconn.php";
session_start();

$matricula = $_GET['id'];

#echo $matricula;

$delete_V = "DELETE FROM [dbo].[Veiculo] WHERE matricula = '{$matricula}'";
$apagar = sqlsrv_query($conn, $delete_V);
if($apagar){
    echo "dados eleminados com sucesso";
    header('location: registoTransportes.php');
} else {
    echo "Erro: nao foi possivel apagar Fornecedor" . $query . "<br>" . mysqli_error($conn);
    header('location: registoTransportes.php');
}

?>