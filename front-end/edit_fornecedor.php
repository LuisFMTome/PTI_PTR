<?php
include "openconn.php";
session_start();

$nome = htmlspecialchars($_POST["nome_fornecedor"]);
$email = htmlspecialchars($_POST["email_fornecedor"]);
$morada = htmlspecialchars($_POST["morada_fornecedor"]);
$codigo_postal = htmlspecialchars($_POST["codigoPostal_fornecedor"]);
$paypalid = htmlspecialchars($_POST["paypalid_fornecedor"]);

$name = $_SESSION["nome"];

if($nome === "" || $email === "" || $morada === "" || $codigo_postal === ""){
    echo ("Foram inseridos dados invalidos");
    //header("Location: perfilFornecedor.php");
    header( "refresh:5; url=perfilFornecedor.php" );
}else{
    $update_v = "UPDATE [Fornecedor] SET nome = '$nome', email = '$email', morada = '$morada', codigoPostal = '$codigo_postal', paypalid = '$paypalid' WHERE nome = '{$name}'";

    $res1 = sqlsrv_query($conn, $update_v);

    if ($res1 === false) {
        echo "Result = false";
        die(print_r(sqlsrv_errors(), true));
    } else {
        if (sqlsrv_has_rows($res1) != -1) {
            echo ("session name not found");
            $_SESSION["status"] = "conta com sessao iniciada nao encontrada";
            $_SESSION["statusCode"] = "error";
            header("Location: perfilFornecedor.php");
        } else {
            echo ("Dados mudados com sucesso");
            $_SESSION["nome"] = $nome;
            $_SESSION["email"] = $email;
            header("Location: perfilFornecedor.php");
        }
    }
}
sqlsrv_close($conn);
   
?>
