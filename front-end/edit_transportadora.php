<?php
include "openconn.php";
session_start();

$nome = htmlspecialchars($_POST["nome_empresa"]);
$email = htmlspecialchars($_POST["email_empresa"]);
$morada = htmlspecialchars($_POST["morada_empresa"]);
$codigo_postal = htmlspecialchars($_POST["codPostal_empresa"]);

$name = $_SESSION["nome"];

$update_v = "UPDATE [Transportadora] SET nome = '$nome', email = '$email', morada = '$morada', codigoPostal = '$codigo_postal' WHERE nome = '{$name}'";

$res1 = sqlsrv_query($conn, $update_v);

if ($res1 === false) {
    echo "Result = false";
    die(print_r(sqlsrv_errors(), true));
} else {
    if (sqlsrv_has_rows($res1) != -1) {
        echo ("session name not found");
        $_SESSION["status"] = "conta com sessao iniciada nao encontrada";
        $_SESSION["statusCode"] = "error";
        header("Location: perfilTransportadora.php");
    } else {
        echo ("Dados mudados com sucesso");
        $_SESSION["nome"] = $nome;
        $_SESSION["email"] = $email;
        header("Location: perfilTransportadora.php");
    }
}
   
?>