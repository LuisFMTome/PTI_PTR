<?php
include "openconn.php";
session_start();

$nome = htmlspecialchars($_POST["nome_novo"]);
$email = htmlspecialchars($_POST["email_novo"]);
$morada = htmlspecialchars($_POST["morada_nova"]);
$codigo_postal = htmlspecialchars($_POST["codPostal_novo"]);

$name = $_SESSION["nome"];

//echo $name . "<br>";
//echo $nome . "<br>";

if($nome === "" || $email === "" || $morada === "" || $codigo_postal === ""){
    echo ("Foram inseridos dados invalidos");
    //header("Location: perfilUtilizador.php");
    header( "refresh:5; url=perfilUtilizador.php" );
}else{
    $update_c = "UPDATE [Consumidor] SET nome = '$nome', email = '$email', morada = '$morada', codigoPostal = '$codigo_postal' WHERE nome = '{$name}'";

    $res1 = sqlsrv_query($conn, $update_c);

    if ($res1 === false) {
        echo "Result = false";
        die(print_r(sqlsrv_errors(), true));
    } else {
        if (sqlsrv_has_rows($res1) == -1) {
            echo ("session name not found");
            $_SESSION["status"] = "conta com sessao iniciada nao encontrada";
            $_SESSION["statusCode"] = "error";
            header("Location: perfilUtilizador.php");
            //header( "refresh:5; url=perfilUtilizador.php" );
        } else {
            echo ("Dados mudados com sucesso");
            $_SESSION["nome"] = $nome;
            $_SESSION["email"] = $email;
            header("Location: perfilUtilizador.php");
            //header( "refresh:5; url=perfilUtilizador.php" );
        }
    }
}


sqlsrv_close($conn);
   
?>