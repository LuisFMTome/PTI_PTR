<?php
echo ("Estou a correr");
session_start();
$serverName = "sqldb05server1.database.windows.net"; // update me
$connectionOptions = array(
    "Database" => "sqldb1", // update me
    "Uid" => "ptrptisqldb", // update me
    "PWD" => "2SdULWb5ePk83jA" // update me
);
//Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    echo ("Connection error");
    die(print_r(sqlsrv_errors(), true));
}

$errors = array();
$row_count = 0;
echo ("Vou entrar no if");
if (isset($_POST["login"])) {

    $tipo =   $_POST["tipoUtili"];
    $mail =   $_POST["email"];
    $pass =   $_POST["pass"];

    if ($tipo == 'comprador') {

        $pass = md5($pass);

        $user_check_query = "SELECT * FROM [dbo].[Consumidor] WHERE email='{$mail}' AND pwd='{$pass}'"; //Nome da coluna password provavelmente errados

        $result = sqlsrv_query($conn, $user_check_query); //, array(), array("Scrollable" => 'static')

        if ($result === false) {
            echo ("Result = false");
            die(print_r(sqlsrv_errors(), true));
        } else {
            if (sqlsrv_has_rows($result) != -1) {
                echo ("Email/password not found");
                $_SESSION["status"] = "Conta com o email inserido não existe";
                $_SESSION["statusCode"] = "error";
                header("location: conta.php");
            } else {
                echo ("Login feito");
                $_SESSION["email"] = $mail;
                $_SESSION["nome"] = $row["nome"];
                $_SESSION["tipo"] = "Consumidor";
                header("Location: index.php");
            }
        }
    } elseif ($tipo == 'transportadora') {

        $pass = md5($pass);

        $user_check_query = "SELECT * FROM [dbo].[Transportadora] WHERE email='{$mail}' AND pwd='{$pass}'"; //Nome da coluna password provavelmente errados

        $result = sqlsrv_query($conn, $user_check_query); //, array(), array("Scrollable" => 'static')

        if ($result === false) {
            echo ("Result = false");
            die(print_r(sqlsrv_errors(), true));
        } else {
            if (sqlsrv_has_rows($result) != -1) {
                echo ("Email/password not found");
                $_SESSION["status"] = "Conta com o email inserido não existe";
                $_SESSION["statusCode"] = "error";
                header("location: conta.php");
            } else {
                echo ("Login feito");
                $_SESSION["email"] = $mail;
                $_SESSION["nome"] = $row["nome"];
                $_SESSION["tipo"] = "Transportadora";
                header("Location: index.php");
            }
        }
    } elseif ($tipo == 'fornecedor') {

        $pass = md5($pass);

        $user_check_query = "SELECT * FROM [dbo].[Fornecedor] WHERE email='{$mail}' AND pwd='{$pass}'"; //Nome da coluna password provavelmente errados

        $result = sqlsrv_query($conn, $user_check_query); //, array(), array("Scrollable" => 'static')

        if ($result === false) {
            echo ("Result = false");
            die(print_r(sqlsrv_errors(), true));
        } else {
            if (sqlsrv_has_rows($result) != -1) {
                echo ("Email/password not found");
                $_SESSION["status"] = "Conta com o email inserido não existe";
                $_SESSION["statusCode"] = "error";
                header("location: conta.php");
            } else {
                echo ("Login feito");
                $_SESSION["email"] = $mail;
                $_SESSION["nome"] = $row["nome"];
                $_SESSION["tipo"] = "Fornecedor";
                header("Location: index.php");
            }
        }
    }
}
