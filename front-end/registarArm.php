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
    
    if(isset($_POST["addArm"])){

        $nome =   $_POST["nome"];
        $morada =   $_POST["morada"];
        $cPostal =   $_POST["cPostal"];
        $tipo =   $_POST["tipo"];
        $idArm = random_int(0, 9000);
        //$idUtil = id que esta associado a este mail $_SESSION['email']
        $idTeste = 0;

        $to_insert = "INSERT INTO [dbo].[Armazem] ([aid], [fornecedor], [nome], [morada], [codigoPostal], [tipo]) VALUES ('$idArm', '$idTeste', '$nome', '$morada', '$cPostal', '$tipo')"; 

        $params = array(1, "inserir armazem");
        $var = sqlsrv_query( $conn, $to_insert, $params);

        if( $var === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

    }

?>