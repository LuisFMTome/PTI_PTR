<?php
session_start();
//include("login.php");
include "openconn.php";

if(isset($_GET["action"])){

    if($_GET["action"] == "delete"){

        foreach($_SESSION["cart"] as $keys => $values){

            if($values["item_id"] == $_GET["id"]){

                unset($_SESSION["cart"][$keys]);
                var_dump($_SESSION["cart"]);
                $count = count($_SESSION["cart"]);
                if($count == 0){
                    unset($_SESSION["cart"]);
                }

                
                //echo $keys;
                
                //echo $_SESSION["cart"][$keys];
                //echo '<script> alert("Item Removido") </script>';
                //echo '<script> window.location="carrinho.php" </script>';
            }
        }
    }
    
}
/*
if(isset($_SESSION["cart"])){

    $count = count($_SESSION["cart"]);

    //echo $_SESSION["cart"][0];
    echo $count;
    
}*/

$user_check_query = "SELECT * FROM [dbo].[Encomenda]";
//$stmt = sqlsrv_query( $conn, $user_check_query );

$query = sqlsrv_query($conn, $user_check_query, array(), array( "Scrollable" => 'static' ));
$row_count = sqlsrv_num_rows($query);

//echo $row_count;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"/>
    <link href="style.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="style.css" rel="stylesheet" />
    <script src="sweetalert2.all.min.js"></script>
</head>
<body>
    <main>
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: green;">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="img/logotipo.png" class="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="font-weight: bold;">
                <li class="nav-item">
                <a class="nav-link active" href="mercado.php">Mercado</a>
                </li>
                <li class="nav-item">
                <a class="nav-link active" href="carrinho.php" >Carrinho</a>
                </li>
                    <?php 
                        if (isset($_SESSION['email']) != "") {?>
                            <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" >
                                <?php echo $_SESSION["nome"] ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="background-color: green;">
                                <?php
                                if($_SESSION["tipo"] == "Consumidor"){
                                    echo "<li><a class=dropdown-item href=perfilUtilizador.php>Perfil</a></li>";
                                    echo "<li><a class=dropdown-item href=histEncomendas.php>Encomendas</a></li>";
                                }elseif($_SESSION["tipo"] == "Fornecedor"){
                                    echo "<li><a class=dropdown-item href=perfilFornecedor.php>Perfil</a></li>";
                                    echo "<li><a class=dropdown-item href=registoArmazem.php>Armazéns</a></li>";
                                    echo "<li><a class=dropdown-item href=registoProduto.php>Produtos</a></li>";
                                    echo "<li><a class=dropdown-item href=histEncomendasFornecedor.php>Encomendas</a></li>";
                                }elseif($_SESSION["tipo"] == "Transportadora"){
                                    echo "<li><a class=dropdown-item href=perfilTransportadora.php>Perfil</a></li>";
                                    echo"<li><a class=dropdown-item href=registoTransportes.php>Registar veiculos</a></li>";
                                    echo "<li><a class=dropdown-item href=gerirVeiculos.php>Ver encomendas</a></li>";
                                }
                                ?>
                            </ul>
                            </li>
            </ul>
            </div>
            <div class="d-flex collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="font-weight: bold;">
                <li class="nav-item">
                    <a class="nav-link active" href="logout.php">Logout</a>
                </li>
                <?php }else{ ?>
                    <li class="nav-item"><a class="nav-link active" href="conta.php">Login</i></a></li>
                <?php } ?>
            </ul>               
        </div>
        </div>
        </nav>
        
        <div class="container small-container carrinho-pagina">
        
        <form method="post" action="fazerEncomenda.php">

            <button type="submit" name="limpar" class='btn btn-secondary'>
            Limpar carrinho
            </button>
    
            <button type="submit" name="encomendar" class='btn btn-secondary'>
            Encomendar
            </button>

        </form>
        
            <table>
                <tr>
                    <th>Produto</th>
                    <th>Preço</th>
                    <!--<th>Total</th>-->
                    <th>Ação</th>
                </tr>

                <?php 
                
                $total = 0;
                if(!empty($_SESSION["cart"])){


                    foreach($_SESSION["cart"] as $keys => $values){

                        $precoDoProduto = $values["item_price"];
                        $total = $total + $precoDoProduto;

                        $idT = $values["item_id"];

                        $query = "SELECT * FROM [dbo].[Produto] WHERE pid='{$idT}'";
                        $result = sqlsrv_query($conn, $query);

                        if( $result === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                        if( sqlsrv_fetch( $result ) === false) {
                            die( print_r( sqlsrv_errors(), true));
                        }

                        $nomeP = sqlsrv_get_field( $result, 1);

                        ?>
                        <tr>
                            <td><?php echo $nomeP?></td>
                            <!--<td><input type="number" value="1"></td>-->
                            <td><?php echo $values["item_price"] . "€" ?></td>
                            <td><a href="carrinho.php?action=delete&id=<?php echo $values["item_id"]; ?>">Remover</a></td>
                        </tr>
                        
                        <?php

                    }

                }
                
                ?>
                
                <!--<tr>
                    <td>
                        <div class="carrinho-info">
                            <p>Produto 8</p>

                        </div>
                    </td>
                    <td><input type="number" value="1"></td>
                    <td>10€</td>
                    <td><a href="">Remover</a></td>
                </tr>-->
            </table>
            
            <div class="total">
                <table>
                    <tr>
                        <td>Total</td>
                        <td id = "total"><?php echo $total . "€"; ?></td>
                        
                    </tr>
                    <tr>
                        <td> <div id="paypal-button-container"></div> </td>
                    </tr>
                </table>
            </div>
        </div>
        <div>
        <footer class="bg-dark text-center text-lg-start text-white">
            <div class="container p-4">
            <div class="row mt-4">
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <img src="img/logofcul.jpg">
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase">Links Úteis</h5>

                <ul class="list-unstyled">
                    <li>
                    <a href="#!" class="text-white"><i class="fas fa-shipping-fast fa-fw fa-sm me-2"></i>Política de Privacidade</a>
                    </li>
                    <li>
                    <a href="#!" class="text-white"><i class="fas fa-backspace fa-fw fa-sm me-2"></i>Termos de Uso</a>
                    </li>
                    <li>
                    <a href="#!" class="text-white"><i class="far fa-file-alt fa-fw fa-sm me-2"></i>Política de Returnos</a>
                    </li>
                    <li>
                    <a href="#!" class="text-white"><i class="far fa-file-alt fa-fw fa-sm me-2"></i>Cupões de Desconto</a>
                    </li>
                </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-3 mb-md-0">
                <h5 class="text-uppercase">Grupo 10</h5>
                <ul class="list-unstyled">
                    <li>
                    <a href="#!" class="text-white">Sobre Nós</a>
                    </li>
                    <li>
                    <a href="#!" class="text-white">Contacta-nos</a>
                    </li>
                    <li>
                    <a href="#!" class="text-white">Faculdade de Ciências</a>
                    </li>
                </ul>
                </div>
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
            © 2022 Copyright
            </div>
        </footer>
    </div>
    </main>
<script src="https://www.paypal.com/sdk/js?client-id=ATCfWOTCqypa0ftAUTCfSLiwM8UaQ0zUkWaDSzUIbFdQoo_bcR4mF_SDi7l-KJ5UXtZ3LcORC6FIhZ50&disable-funding=credit,card&currency=EUR"></script>    <script>
        var price = document.getElementById("total");
        console.log(price.innerText);
        paypal.Buttons({
            style : {
                color: 'blue',
                shape: 'pill'
            },
            createOrder: function (data, actions) {
                return actions.order.create({
                    purchase_units : [{
                        amount: {
                            value: parseInt(price.innerText)
                        }
                    }]
                });
            },
            onApprove: function (data, actions) {
                return actions.order.capture().then(function (details) {
                    console.log(details)
                })
            },
            onCancel: function (data) {
                window.location.replace("index.html")
            }
        }).render('#paypal-button-container');
    </script>

<?php
//echo "<p>teste</p>";
if (isset($_SESSION['statusCode']) != "") {

    //echo $_SESSION['statusCode'];
?>

    <script>
            
            document.addEventListener("DOMContentLoaded", function(event) {
                
                Swal.fire({
                title: "<?php echo $_SESSION['status']; ?>",
                text: "clique ok",
                icon: "<?php echo $_SESSION['statusCode']; ?>", //warning
            });
            
            });


        
    </script>

<?php
    unset($_SESSION['status']);
    unset($_SESSION['statusCode']);
}

    ?>

    <?php
    /*
    $encomendas_query = "SELECT * FROM [dbo].[Encomenda]";
    $enco = sqlsrv_query($conn, $encomendas_query);
    
    while ($row = sqlsrv_fetch_array($enco)) {
        echo "<tr>";
        
        echo "<td>" . $row['produto'] . "</td>";
        
        echo "</tr>";
    }
    */
    ?>
</body>
</html>
