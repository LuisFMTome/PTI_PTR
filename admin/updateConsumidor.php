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
$id =   $_POST["update"];

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

echo "$row_count";


?>