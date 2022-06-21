<?php
    session_start();
    include "openconn.php";

    if(isset($_POST["addTra"])){

        $categoria =    $_POST["categoria"];
        $matricula =    $_POST["matricula"];
        $recursos  =    $_POST["recursos"];
        $poluicao  =    $_POST["poluicao"];
        //$produto =   $_POST["produto"];
        $mailTran  =    $_SESSION['email'];
        //echo $matricula;

        //verificar se a matricula esta em uso ou nao

        $user_check_query = "SELECT * FROM [dbo].[Veiculo] WHERE matricula='$matricula'";
        $query = sqlsrv_query($conn, $user_check_query, array(), array( "Scrollable" => 'static' ));
        $row_count = sqlsrv_num_rows($query);
        
        //echo $queryy;
        if ($row_count == 0){

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

            $to_insert = "INSERT INTO [dbo].[Veiculo] ([matricula], [transportadora], [categoria], [recursos], [poluicao]) VALUES ('$matricula', '$nif', '$categoria', '$recursos', '$poluicao')"; 

            $params = array(1, "inserir armazem");
            $var = sqlsrv_query( $conn, $to_insert, $params);

            if( $var === false ) {
                die( print_r( sqlsrv_errors(), true));
            }

            $_SESSION['statusCode'] = "success";
            $_SESSION['status'] = "Veiculo registado com sucesso";
            #header( "refresh:5; url=registoTransportes.php" );
            header('location: registoTransportes.php');

        }else{
            $_SESSION['statusCode'] = "error";
            $_SESSION['status'] = "Matricula registada anteriormente";
            #header( "refresh:5; url=registoTransportes.php" );
            header('location: registoTransportes.php');


        }

    }
?>