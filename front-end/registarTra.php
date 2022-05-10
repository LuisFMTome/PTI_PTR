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
        $produto =   $_POST["produto"];
        
        $mailTran = $_SESSION['email'];


        //verificar se a matricula esta em uso ou nao

        $user_check_query = "SELECT * FROM [dbo].[Veiculo] WHERE matricula='{$matricula}'";
        $row_count = sqlsrv_num_rows($user_check_query);

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


        }else{

            $_SESSION['msg'] = "matricula ja registada";

        }

    }
?>