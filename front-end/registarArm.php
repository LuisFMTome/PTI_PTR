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
        $_SESSION['msg'] = "Armazém registado com sucesso";
        header('location: registoArmazem.php');

    }

?>