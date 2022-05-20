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

    if(isset($_POST["addTra"])){

        $categoria =   $_POST["categoria"];
        $matricula =   $_POST["matricula"];
        $produto =   $_POST["quantidade"];

        //echo "<p>$categoria</p>";
        //echo "<p>$matricula</p>";
        //echo "<p>$produto</p>";
        
        $mailTran = $_SESSION['email'];


        //verificar se a matricula esta em uso ou nao

        $stmt = "SELECT * FROM [dbo].[Veiculo] WHERE matricula='{$matricula}'";
        $queryy = sqlsrv_query($conn, $stmt, array(), array( "Scrollable" => 'static' ));
        $row_count = sqlsrv_num_rows($queryy);

        echo "<p>$queryy</p>";
        echo "<p>$row_count</p>";
        if ($row_count === 0){

            $query = "SELECT * FROM [dbo].[Transportadora] WHERE email='{$mailTran}'";
            $result = sqlsrv_query($conn, $query);

            if( $result === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_fetch( $result ) === false) {
                die( print_r( sqlsrv_errors(), true));
            }

            $nif = sqlsrv_get_field( $result, 0);

            echo "<p>$nif</p>";

            $to_insert = "INSERT INTO [dbo].[Veiculo] ([matricula], [transportadora], [categoria], [quantidade]) VALUES ('$matricula', '$nif', '$categoria', '$produto')"; 

            $params = array(1, "inserir armazem");
            $var = sqlsrv_query( $conn, $to_insert, $params);

            if( $var === false ) {
                die( print_r( sqlsrv_errors(), true));
            }

            $_SESSION['msg'] = "Veículo registado";
            header('location: registoTransportes.php');


        }else{

            $_SESSION['msg'] = "matricula registada anteriormente";
            header('location: registoTransportes.php');

        }

    }
?>