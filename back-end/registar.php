<?php
    
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
/*
    if ($conn->connect_error) {   

        die("Connection failed: " . $conn->connect_error);
}*/

#echo phpinfo();
$errors = array();


if(isset($_POST["registar"])){

    $nome =   $_POST["nome"];
    $mail =   $_POST["email"];
    $pass =   $_POST["pass"];

    $pass = md5($pass);
    echo "<p>$nome</p>";
    echo "<p>$mail</p>";
    echo "<p>$pass</p>";

    $user_check_query = "SELECT * FROM [dbo].[Consumidor] WHERE email='$mail'";
    //$stmt = sqlsrv_query( $conn, $user_check_query );

    $query = sqlsrv_query($conn, $user_check_query, array(), array( "Scrollable" => 'static' ));
    $row_count = sqlsrv_num_rows($query);
    

    if ($row_count === 0) {

        $id = random_int(0, 9000);
        
        $to_insert = "INSERT INTO [dbo].[Consumidor] ([nome], [email], [pwd], [cid]) VALUES ('$nome', '$mail', '$pass', '$id')"; 

        $params = array(1, "some data");
        $var = sqlsrv_query( $conn, $to_insert, $params);

        if( $var === false ) {
            die( print_r( sqlsrv_errors(), true));
       }
        
    
     }else{

        print("nao");

     }

}
?>