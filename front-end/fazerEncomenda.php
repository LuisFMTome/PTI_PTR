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

        //morada do consumidor
        $cPostal_consumidor = sqlsrv_get_field( $result, 5);
        $id_consumidor = sqlsrv_get_field( $result, 0);
        echo $cPostal_consumidor;

        //no futuro retirar isto (teria que ser o id do veiculo)
        $veiculo = 0;

        if(!(is_null($cPostal_consumidor))){

            foreach($_SESSION["cart"] as $keys => $values){

                //id encomenda
                $pedido = random_int(0, 9000);

                //echo $values["item_id"];
                $idProduto = $values["item_id"];

                //cPostal do produto
                $morada_produto_query = "SELECT * FROM [dbo].[Produto] WHERE pid='{$idProduto}'";
                $result2 = sqlsrv_query($conn, $morada_produto_query);
                $cPostal_produto = sqlsrv_get_field( $result, 3);

                //inserir na bd
                $to_insert = "INSERT INTO [dbo].[Encomenda] ([pedido], [origem], [destino], [produto], [quantidade]) VALUES ('$pedido', '$cPostal_produto', '$cPostal_consumidor', '$idProduto', '$veiculo')"; 

                $params = array(1, "some data");
                $var = sqlsrv_query( $conn, $to_insert, $params);
                if( $var === false ) {
                    die( print_r( sqlsrv_errors(), true));
                }

                echo "<p>$cPostal_produto</p>";
                echo "<p>$cPostal_consumidor</p>";
                echo "<p>$idProduto</p>";
                echo "sucesso";
                    
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