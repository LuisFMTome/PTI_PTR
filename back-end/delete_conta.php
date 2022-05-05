<?php
include "openconn.php";
session_start();

if (isset($_POST["delete_conta"])) {
    $userTipe = $_SESSION["tipo"];
    $email = $_SESSION("email");
    $password = htmlspecialchars($_POST["password"]);

    if($userTipe === "Consumidor"){
        $query = "SELECT [cid] FROM [dbo].[Consumidor] WHERE email='{$email}' AND pwd = {'$password'}";
        $results = mysqli_query($conn, $query);
        $id_consumidor = sqlsrv_fetch_object( $results );
        echo $id_consumidor.'<br>';

        if(sqlsrv_has_rows($results) != -1){
        $delete_c = "DELETE FROM [dbo].[Consumidor] WHERE [cid]='{$id_consumidor}'";
        $res1 = $sqlsrv_query($conn, $delete_c);
        if($res1){
            echo "dados eleminados com sucesso";
            header( "refresh:5; url=index.html" );
        } else {
            echo "Erro: nao foi possivel apagar utilizador" . $query . "<br>" . mysqli_error($conn);
            header( "refresh:5; url=index.html" );
        }
    }
    }elseif($userTipe === "Fornecedor"){
    $query = "SELECT [fid] FROM [dbo].[Fornecedor] WHERE email = '{$email}' AND pwd = {'$password'}";
    $results = mysqli_query($conn, $query);
    $id_fornecedor = sqlsrv_fetch_object( $results );
    echo $id_fornecedor.'<br>';

    if(sqlsrv_has_rows($results) != -1){
        $delete_f = "DELETE FROM [dbo].[Fornecedor] WHERE fid = '$id_fornecedor'";
        $res1 = $sqlsrv_query($conn, $delete_f);
        if($res1){
            echo "dados eleminados com sucesso";
            header( "refresh:5; url=index.html" );
        } else {
            echo "Erro: nao foi possivel apagar utilizador" . $query . "<br>" . mysqli_error($conn);
            header( "refresh:5; url=index.html" );
        }
    }
    }elseif($userTipe === "Transportadora"){
    $query = "SELECT [nif] FROM [dbo].[Transportadora] WHERE email= {'$email_fornecedor'} AND pwd = {'$password'}";
    $results = mysqli_query($conn, $query);
    $id_transportadora = sqlsrv_fetch_object( $results );
    echo $id_transportadora.'<br />';
    if(sqlsrv_has_rows($results) != -1){
        $delete_t = "DELETE FROM [dbo].[Transportadora] WHERE [nif]='$id_transportadora'";
        $res1 = $sqlsrv_query($conn, $delete_t);
        if($res1){
            echo "dados eleminados com sucesso";
            header( "refresh:5; url=index.html" );
        } else {
            echo "Erro: nao foi possivel apagar utilizador" . $query . "<br>" . mysqli_error($conn);
            header( "refresh:5; url=index.html" );
        }

    }
    }else{
    echo "Tipo de Utilizador inexistente";
    }

mysqli_close($conn);

}



   
?>