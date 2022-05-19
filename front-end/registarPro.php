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


    if(isset($_POST["addPro"])){

        $nome =   $_POST["nome"];
        $morada =   $_POST["morada"];
        $tipo =   $_POST["tipo"];
        //$tipo =   $_POST["tipo"];
        $pid = random_int(0, 9000);

        $mailForn = $_SESSION['email'];

        //arranjar id fornecedor

        $user_check_query = "SELECT * FROM [dbo].[Fornecedor] WHERE email='{$mailForn}'"; 
        $result = sqlsrv_query($conn, $user_check_query);

        if( $result === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        if( sqlsrv_fetch( $result ) === false) {
            die( print_r( sqlsrv_errors(), true));
        }

        $idF = sqlsrv_get_field( $result, 0);


        //verificar se p fornecedor tem um armanzem com aquela morada

        $user_check_query2 = "SELECT * FROM [dbo].[Armazem] WHERE fornecedor='{$idF}' AND morada='{$morada}'";
        //$result2 = sqlsrv_query($conn, $user_check_query2);
        $result2 = sqlsrv_query($conn, $user_check_query2, array(), array( "Scrollable" => 'static' ));
        $row_count = sqlsrv_num_rows($result2);

        echo "<p>$row_count</p>";
        echo "<p>$morada</p>";
        echo "<p>$tipo</p>";

        $temp = sqlsrv_query($conn, $user_check_query2);

        if( $temp === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        if( sqlsrv_fetch( $temp ) === false) {
            die( print_r( sqlsrv_errors(), true));
        }

        $cPostal = sqlsrv_get_field( $temp, 4);

        echo "<p>$cPostal</p>";

        
        if ($row_count === 0) {

            echo "entrar aqui";
            $_SESSION['msg'] = "morada de armanzem nao existente";
            header('location: registoProduto.php');

        }else{

            echo "nao entrar aqui";
            
            $to_insert = "INSERT INTO [dbo].[Produto] ([pid], [nome], [morada], [codigoPostal]) VALUES ('$pid', '$nome', '$morada', '$cPostal')"; 

            $params = array(1, "inserir armazem");
            $var = sqlsrv_query( $conn, $to_insert, $params);

            if( $var === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            
            $_SESSION['msg'] = "Produto registado com sucesso";
            header('location: registoProduto.php');

        }


    }

?>