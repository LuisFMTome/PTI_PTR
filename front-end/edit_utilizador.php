<?php
include "openconn.php";
session_start();

$nome = htmlspecialchars($_POST["nome"]);
$email = htmlspecialchars($_POST["email"]);
$morada = htmlspecialchars($_POST["morada"]);
$codigo_postal = htmlspecialchars($_POST["codPostal"]);

$update_v = "UPDATE [Consumidor] SET [dbo].[Consumidor] ([nome], [email], [morada], [codigo_postal]) VALUES ('$nome', '$email', '$morada', '$codigo_postal') WHERE nome='$_SESSION[username]'";
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