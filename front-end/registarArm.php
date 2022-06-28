<?php 
    session_start();
    include "openconn.php";
    
    if(isset($_POST["addArm"])){

        $nome =   $_POST["nome"];
        $morada =   $_POST["morada"];
        $cPostal =   $_POST["cPostal"];
        $tipo =   $_POST["tipo"];
        $idArm = random_int(0, 9000);
        $mailForn = $_SESSION['email'];
        $recursos =   $_POST["recursos"];
        $poluicao =   $_POST["poluicao"];

        //echo "<p>$nome</p>";
        //echo "<p>$morada</p>";
        //echo "<p>$cPostal</p>";
        //echo "<p>$tipo</p>";
        //echo "<p>$mailForn</p>";

        //verificar se ja existe algum armazem nesse codigo postal
        $user_check_query = "SELECT * FROM [dbo].[Armazem] WHERE codigoPostal='$cPostal'";
        //$stmt = sqlsrv_query( $conn, $user_check_query );

        $query = sqlsrv_query($conn, $user_check_query, array(), array( "Scrollable" => 'static' ));
        $row_count = sqlsrv_num_rows($query);
        if($row_count == 0){


            $user_check_query = "SELECT * FROM [dbo].[Fornecedor] WHERE email='{$mailForn}'"; //Nome da coluna password provavelmente errados

            $result = sqlsrv_query($conn, $user_check_query);

            if( $result === false ) {
                die( print_r( sqlsrv_errors(), true));
            }

            if( sqlsrv_fetch( $result ) === false) {
                die( print_r( sqlsrv_errors(), true));
            }

            $idF = sqlsrv_get_field( $result, 0);
            //echo "<p>$idF</p>";

            $to_insert = "INSERT INTO [dbo].[Armazem] ([aid], [fornecedor], [nome], [morada], [codigoPostal], [tipo], [recursos], [poluicao]) VALUES ('$idArm', '$idF', '$nome', '$morada', '$cPostal', '$tipo', '$recursos', '$poluicao')"; 

            $params = array(1, "inserir armazem");
            $var = sqlsrv_query( $conn, $to_insert, $params);

            if( $var === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            $_SESSION['statusCode'] = "success";
            $_SESSION['status'] = "Armazem registado";
            header('location: registoArmazem.php');

        }else{

            $_SESSION['statusCode'] = "error";
            $_SESSION['status'] = "codigo postal em uso";
            header('location: registoArmazem.php');

        }

    }

?>