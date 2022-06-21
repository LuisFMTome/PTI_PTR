<?php
    session_start();
    include "openconn.php";

    if(isset($_POST["addPro"])){

        $nome =   $_POST["nome"];
        $morada =   $_POST["morada"];
        $tipo =   $_POST["tipo"];
        $subtipo =   $_POST["subtipo"];
        $preco =   $_POST["preco"];
        $poluicao =   $_POST["poluicao"];
        $pid = random_int(0, 9000);

        $mailForn = $_SESSION['email'];

        //echo $nome;
        //echo $morada;
        //echo $tipo;
        //echo $subtipo;
        //echo $preco;
        //echo $poluicao;


        if($tipo != null && $subtipo != "Escolhe um tipo primeiro" ){

            //ir buscar id do fornecedor

            $user_check_query = "SELECT * FROM [dbo].[Fornecedor] WHERE email='{$mailForn}'"; 
            $result = sqlsrv_query($conn, $user_check_query);

            if( $result === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_fetch( $result ) === false) {
                die( print_r( sqlsrv_errors(), true));
            }

            $idF = sqlsrv_get_field( $result, 0);
            //echo $idF;

            //ir buscar codigo postal do armazem

            $user_check_query2 = "SELECT * FROM [dbo].[Armazem] WHERE fornecedor='{$idF}' AND morada='{$morada}'";
            //$result2 = sqlsrv_query($conn, $user_check_query2, array(), array( "Scrollable" => 'static' ));

            $temp = sqlsrv_query($conn, $user_check_query2);

            if( $temp === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_fetch( $temp ) === false) {
                die( print_r( sqlsrv_errors(), true));
            }

            $cPostal = sqlsrv_get_field( $temp, 4);

            //echo $cPostal;

            //criar subtipo

            if($tipo == "Alimentacao"){

                $valor = 1;

                $query = "SELECT * FROM [dbo].[Subtipo] WHERE tipo='{$valor}' and nome='{$subtipo}'";
                $result = sqlsrv_query($conn, $query);
                if( $result === false ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                if( sqlsrv_fetch( $result ) === false) {
                    die( print_r( sqlsrv_errors(), true));
                }
                $idSub = sqlsrv_get_field( $result, 0);

            }elseif($tipo == "Casa"){

                $valor = 2;

                $query = "SELECT * FROM [dbo].[Subtipo] WHERE tipo='{$valor}' and nome='{$subtipo}'";
                $result = sqlsrv_query($conn, $query);
                if( $result === false ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                if( sqlsrv_fetch( $result ) === false) {
                    die( print_r( sqlsrv_errors(), true));
                }
                $idSub = sqlsrv_get_field( $result, 0);

            }elseif($tipo == "Desporto"){

                $valor = 3;

                $query = "SELECT * FROM [dbo].[Subtipo] WHERE tipo='{$valor}' and nome='{$subtipo}'";
                $result = sqlsrv_query($conn, $query);
                if( $result === false ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                if( sqlsrv_fetch( $result ) === false) {
                    die( print_r( sqlsrv_errors(), true));
                }
                $idSub = sqlsrv_get_field( $result, 0);
                
            }elseif($tipo == "Tecnologia"){

                $valor = 4;

                $query = "SELECT * FROM [dbo].[Subtipo] WHERE tipo='{$valor}' and nome='{$subtipo}'";
                $result = sqlsrv_query($conn, $query);
                if( $result === false ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                if( sqlsrv_fetch( $result ) === false) {
                    die( print_r( sqlsrv_errors(), true));
                }
                $idSub = sqlsrv_get_field( $result, 0);
                
            }elseif($tipo == "Vestuário"){

                $valor = 5;

                $query = "SELECT * FROM [dbo].[Subtipo] WHERE tipo='{$valor}' and nome='{$subtipo}'";
                $result = sqlsrv_query($conn, $query);
                if( $result === false ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                if( sqlsrv_fetch( $result ) === false) {
                    die( print_r( sqlsrv_errors(), true));
                }
                $idSub = sqlsrv_get_field( $result, 0);
                
            }
            
            //inserir na base de dados
            $to_insert = "INSERT INTO [dbo].[Produto] ([pid], [nome], [morada], [codigoPostal], [subtipo], [preco], [poluicao]) VALUES ('$pid', '$nome', '$morada', '$cPostal', '$idSub', '$preco', '$poluicao')"; 

            $params = array(1, "inserir produto");
            $var = sqlsrv_query( $conn, $to_insert, $params);

            if( $var === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            
            $_SESSION['statusCode'] = "success";
            $_SESSION['status'] = "Produto registado com sucesso";
            header('location: registoProduto.php');
            
            
        }else{

            //echo "Tem que escolher um tipo e um subtipo primeiro";
            $_SESSION['statusCode'] = "error";
            $_SESSION['status'] = "Tem que escolher um tipo e um subtipo primeiro";
            header('location: registoTransportes.php');
        }


        //arranjar id fornecedor
        /*
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

*/
    }

?>