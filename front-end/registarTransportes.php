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
    session_start();
    if(isset($_POST["addTransporte"])){

        $veiculo =  htmlspecialchars($_POST["email_contacto"]);
        $matricula =  htmlspecialchars($_POST["matricula"]);
        $email_transportadora = $_SESSION['email'];
        $produto =  htmlspecialchars($_POST["produto"]);
        $idTeste = 0;

        $query = "SELECT [nif] FROM [dbo].[Transportadora] WHERE [email]= '$email_transportadora'";
        $results = mysqli_query($conn, $query);
         $id_transportadora = sqlsrv_fetch_object($result);
            echo $id_transportadora.'<br />';
      //}
        $to_insert = "INSERT INTO [dbo].[Veiculo] ([matricula], [transportadora], [categoria], [produto]) VALUES ('$matricula', '$id_transportadora', '$veiculo', '$produto')"; 

        $params = array(1, "inserir armazem");
        $var = sqlsrv_query( $conn, $to_insert, $params);
        if($var){
            echo "dados inseridos com sucesso";
            header( "refresh:5; url=index.html" );
        } else {
            die( print_r( sqlsrv_errors(), true));
        }

    //}

?>