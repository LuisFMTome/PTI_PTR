<?php
session_start(); 
$serverName = "sqldb05server1.database.windows.net"; // update me
$connectionOptions = array(
    "Database" => "sqldb1", // update me
    "Uid" => "ptrptisqldb", // update me
    "PWD" => "2SdULWb5ePk83jA" // update me
);
//Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);
if($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

//$id =   $_POST["id"]; //confirmar
$nome =   $_POST["nome"];
$email =   $_POST["email"]; //confirmar
$pass =   $_POST["pass"];
$morada =   $_POST["morada"];
$cPostal =   $_POST["cPostal"];
$id =   $_GET['id'];

/*
//echo "$id";
echo "$nome";
echo "$email";
echo "$pass";
echo "$morada";
echo "$cPostal";
*/

$user_check_query = "SELECT * FROM [dbo].[Consumidor] WHERE email='$email' and cid!='$id'";
$query = sqlsrv_query($conn, $user_check_query, array(), array( "Scrollable" => 'static' ));
$row_count = sqlsrv_num_rows($query);

//echo "$row_count";

if($row_count == 0){

    $user_check_query2 = "SELECT * FROM [dbo].[Consumidor] WHERE cid='{$id}'"; //Nome da coluna password provavelmente errados
    $result2 = sqlsrv_query($conn, $user_check_query2);
    if( $result2 === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_fetch( $result2 ) === false) {
        die( print_r( sqlsrv_errors(), true));
    }
    $passNaBD = sqlsrv_get_field( $result2, 3);

    if($passNaBD == $pass){

        $update_c = "UPDATE [Consumidor] SET nome = '$nome', email = '$email', morada = '$morada', codigoPostal = '$cPostal' WHERE cid = '{$id}'";

        $res1 = sqlsrv_query($conn, $update_c);

        $_SESSION["status"] = "conta alterada com secesso";
        $_SESSION["statusCode"] = "success";

        $_SESSION["nome"] = $nome;
        $_SESSION["email"] = $email;

        header('location: adminConsumidores.php');

    }else{

        $passEnc = md5($pass);

        $update_c = "UPDATE [Consumidor] SET nome = '$nome', email = '$email', pwd = '$passEnc', morada = '$morada', codigoPostal = '$cPostal' WHERE cid = '{$id}'";

        $res1 = sqlsrv_query($conn, $update_c);

        $_SESSION["status"] = "conta alterada com secesso";
        $_SESSION["statusCode"] = "success";

        $_SESSION["nome"] = $nome;
        $_SESSION["email"] = $email;

        header('location: adminConsumidores.php');

    }


}else{

    $_SESSION["status"] = "email já em uso";
    $_SESSION["statusCode"] = "error";

    header('location: adminConsumidores.php');

}


?>