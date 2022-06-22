<?php 

session_start();
include "openconn.php";

if(isset($_POST["limpar"])){

    if(isset($_SESSION["cart"])){

        unset($_SESSION["cart"]);
        header("Location: carrinho.php");
    }
}

if(isset($_POST["encomendar"])){

    if(isset($_SESSION["cart"])){

        $emailConsumidor = $_SESSION['email'];

        //ir confirmar se o consumidor tem a morada definida
        $morada_consumidor_query = "SELECT * FROM [dbo].[Consumidor] WHERE email='{$emailConsumidor}'";
        $result = sqlsrv_query($conn, $morada_consumidor_query);
        if( $result === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_fetch( $result ) === false) {
            die( print_r( sqlsrv_errors(), true));
        }
        //morada e id do consumidor
        $cPostal_consumidor = sqlsrv_get_field( $result, 5);
        $id_consumidor = sqlsrv_get_field( $result, 0);
        //echo $cPostal_consumidor;



        if(!(is_null($cPostal_consumidor))){

            foreach($_SESSION["cart"] as $keys => $values){

                //id encomenda
                $pedido = random_int(0, 9000);

                //echo $values["item_id"];
                $idProduto = $values["item_id"];

                //cPostal e poluicao do produto
                $morada_produto_query = "SELECT * FROM [dbo].[Produto] WHERE pid='{$idProduto}'";
                $result2 = sqlsrv_query($conn, $morada_produto_query);
                if( $result2 === false ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                if( sqlsrv_fetch( $result2 ) === false) {
                    die( print_r( sqlsrv_errors(), true));
                }
                $cPostal_produto = sqlsrv_get_field( $result2, 3);
                $poluicao = sqlsrv_get_field( $result2, 5);
                //echo "polui " . $poluicao;           

                //estado da encomenda (encomendado)
                $estado = 0;

                //echo "<p>'produto' . $cPostal_produto</p>";
                //echo "<p>'consumidor' . $cPostal_consumidor</p>";
                //echo "<p>$idProduto</p>";
                $data =  date("Y-m-d H:i:s"); 
                $dataFinal = date('Y-m-d H:i:s', strtotime($data. ' + 7 days'));
                //echo $dataFinal;

                //inserir na bd
                $to_insert = "INSERT INTO [dbo].[Encomenda] ([pedido], [consumidor], [origem], [destino], [produto], [poluicao], [cancelamento], [estado]) VALUES ('$pedido', '$id_consumidor', '$cPostal_produto', '$cPostal_consumidor', '$idProduto', '$poluicao', '$dataFinal', '$estado')"; 

                $params = array(1, "some data");
                $var = sqlsrv_query( $conn, $to_insert, $params);
                if( $var === false ) {
                    die( print_r( sqlsrv_errors(), true));
                }


                
                }

                unset($_SESSION["cart"]);
                $_SESSION['status'] = "Produtos encomendados com sucesso";
                $_SESSION['statusCode'] = "success";
                //header("Location: carrinho.php");

            }else{

                //echo 'Tem que definir a o Código Postal no Perfil antes de fazer encomendas';
                $_SESSION['status'] = "Tem que definir o Código Postal no Perfil antes de fazer encomendas";
                $_SESSION['statusCode'] = "error";
                header("Location: carrinho.php");
            }
        }else{

            //echo 'O carrinho está vazio';
            $_SESSION['status'] = "O carrinho está vazio";
            $_SESSION['statusCode'] = "error";
            header("Location: carrinho.php");
        
        }
        
}
/*
CREATE TABLE Encomenda (
    pedido int,
    origem varchar(255), NOT NULL
    destino varchar(255), NOT NULL
    produto int, NOT NULL
    Veiculo int,
    cancelamento DATETIME
    estado int, NOT NULL
    idConsumidor int

    PRIMARY KEY (pedido),
    FOREIGN KEY (produto) REFERENCES Produto(pid) ON DELETE CASCADE
     */
?>