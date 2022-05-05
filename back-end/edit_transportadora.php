<?php
include "openconn.php";
session_start();

$nome = htmlspecialchars($_POST["nome_empresa"]);
$email = htmlspecialchars($_POST["email_empresa"]);
$morada = htmlspecialchars($_POST["morada_empresa"]);
$codigo_postal = htmlspecialchars($_POST["codPostal_empresa"]);

$update_v = "UPDATE [Consumidor] SET [dbo].[Consumidor] ([nome], [email], [morada], [codigoPostal]) VALUES ('$nome', '$email', '$morada', '$codigo_postal') WHERE nome='$_SESSION[username]'";
    $res1 = sqlsrv_query($conn, $update_v);
    if($res1){
        echo "Dados alterados com sucesso";
        header( "refresh:5; url=perfil_vol.php" );
    } else {
        die(print_r(sqlsrv_errors(), true));
        header( "refresh:5; url=conta.html" );
    }

    mysqli_close($conn);
   
?>