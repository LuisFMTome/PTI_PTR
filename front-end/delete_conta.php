<?php
include "openconn.php";
session_start();

if (isset($_POST["delete_conta"])) {
    $userTipe = $_SESSION["tipo"];
    $email = $_SESSION["email"];
    $name = $_SESSION["nome"];
    $password = htmlspecialchars($_POST["password"]);
    $password1 = md5($password);
    //echo $userTipe. "<br>";
    //echo $email. "<br>";
    //echo $password. "<br>";
    //echo $password1. "<br>";

    if($userTipe === "Consumidor"){
        $query = "SELECT * FROM [dbo].[Consumidor] WHERE email='{$email}' AND pwd = '{$password1}'";
        $results = sqlsrv_query($conn, $query);
        if ($results === false) {
            echo ("Result = false");
            die(print_r(sqlsrv_errors(), true));
        }else{
            if (sqlsrv_has_rows($results) != -1) {
                echo ("email/password not found");
                $_SESSION["status"] = "Conta com o email inserido não existe";
                $_SESSION["statusCode"] = "error";
                header("location: perfilUtilizador.php");
            } else {
                $row = sqlsrv_fetch_array($results);
                $cid = $row['cid'];
                $delete_c = "DELETE FROM [dbo].[Consumidor] WHERE cid = '{$cid}'";
                $res1 = sqlsrv_query($conn, $delete_c);
                if($res1){
                    echo "dados eleminados com sucesso";
                    header( "refresh:5; url=logout.php" );
                } else {
                    echo "Erro: nao foi possivel apagar utilizador" . $query . "<br>" . mysqli_error($conn);
                    header( "refresh:5; url=logout.php" );
                }
            }
        }
    
    }elseif($userTipe === "Fornecedor"){
    $query = "SELECT * FROM [dbo].[Fornecedor] WHERE email = '{$email}' AND pwd = '{$password1}'";
    $results = sqlsrv_query($conn, $query);
    if ($results === false) {
        echo ("Result = false");
        die(print_r(sqlsrv_errors(), true));
    }else{
        if (sqlsrv_has_rows($results) != -1) {
            echo ("email/password not found");
            $_SESSION["status"] = "Conta com o email inserido não existe";
            $_SESSION["statusCode"] = "error";
            header("location: perfilFornecedor.php");
        } else {
            $row = sqlsrv_fetch_array($results);
            $fid = $row['fid'];
            $delete_c = "DELETE FROM [dbo].[Fornecedor] WHERE fid = '{$fid}'";
            $res1 = sqlsrv_query($conn, $delete_c);
            if($res1){
                echo "dados eleminados com sucesso";
                header( "refresh:5; url=logout.php" );
            } else {
                echo "Erro: nao foi possivel apagar Fornecedor" . $query . "<br>" . mysqli_error($conn);
                header( "refresh:5; url=logout.php" );
            }
        }
    }

    }elseif($userTipe === "Transportadora"){
        $query = "SELECT * FROM [dbo].[Transportadora] WHERE email = '{$email}' AND pwd = '{$password1}'";
        $results = sqlsrv_query($conn, $query);
        if ($results === false) {
            echo ("Result = false <br>");
            die(print_r(sqlsrv_errors(), true));
        }else{
            if (sqlsrv_has_rows($results) != -1) {
                echo ("email/password not found");
                $_SESSION["status"] = "Conta com o email inserido não existe";
                $_SESSION["statusCode"] = "error";
                header("location: perfilTransportadora.php");
            } else {
                $row = sqlsrv_fetch_array($results);
                $nif = $row['nif'];
                $delete_c = "DELETE FROM [dbo].[Transportadora] WHERE nif = '{$nif}'";
                $res1 = sqlsrv_query($conn, $delete_c);
                if($res1){
                    echo "dados eleminados com sucesso";
                    header( "refresh:5; url=logout.php" );
                } else {
                    echo "Erro: nao foi possivel apagar Transportadora" . $query . "<br>" . mysqli_error($conn);
                    header( "refresh:5; url=logout.php" );
                }
            }
        }
    }else{
    echo "Tipo de Utilizador inexistente";
    }

sqlsrv_close($conn);

}
?>