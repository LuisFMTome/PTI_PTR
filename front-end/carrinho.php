<?php
session_start();
//include("login.php");
include "openconn.php";

if(isset($_GET["action"])){

    if($_GET["action"] == "delete"){

        foreach($_SESSION["cart"] as $keys => $values){

            if($values["item_id"] == $_GET["id"]){

                unset($_SESSION["cart"][$keys]);
                //echo $keys;
                
                //echo $_SESSION["cart"][$keys];
                //echo '<script> alert("Item Removido") </script>';
                //echo '<script> window.location="carrinho.php" </script>';
            }
        }
    }
    
}


$user_check_query = "SELECT * FROM [dbo].[Encomenda]";
//$stmt = sqlsrv_query( $conn, $user_check_query );

$query = sqlsrv_query($conn, $user_check_query, array(), array( "Scrollable" => 'static' ));
$row_count = sqlsrv_num_rows($query);

echo $row_count;
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
        <nav class="navigation">
            <div class="top-nav-bar">
                <div class="search-box">
                    <a href="index.php">
                        <img src="img/logotipo.png" class="logo">
                    </a>
                    <!--<input type="text" class="form-control">
                    <span class="input-group-text"><i class="fa fa-search"></i></span>-->
                </div>
                <div class="menu-bar">
                    <ul>
                        <!--<li><a href="index.php">Home</a></li>-->
                        <li><a href="mercado.php">Mercado</a></li>
                        <?php 
                        if (isset($_SESSION['email']) != "") {

                            if($_SESSION["tipo"] == "Consumidor"){

                        ?>
                            <li><a href="perfilUtilizador.php">Perfil</a></li>

                        <?php 
                            }elseif($_SESSION["tipo"] == "Fornecedor"){

                                ?>
                                
                                <li><a href="perfilFornecedor.php">Perfil</a></li>

                                <?php
                            }elseif($_SESSION["tipo"] == "Transportadora"){

                                ?>
                                
                                <li><a href="perfilTransportadora.php">Perfil</a></li>

                                <?php
                            }

                        }?>
                        
                        <li><a href="carrinho.php">Carrinho</a></li>

                        <?php 
                        if (isset($_SESSION['email']) != "") {

                        ?>
                        
                        <li><a href="logout.php">Logout</a></li>

                        <?php    
                        }else{

                        ?>
                        
                        <li><a href="conta.php">Login</i></a></li>
                        
                        <?php

                        }
                        ?>
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
                    <th>Quantidade</th>
                    <th>Total</th>
                    <th>Ação</th>
                </tr>

                <?php 
                
                if(!empty($_SESSION["cart"])){

                    $total = 0;
                    foreach($_SESSION["cart"] as $keys => $values){

                        ?>
                        <tr>
                            <td><?php echo $values["item_id"] ?></td>
                            <td><input type="number" value="1"></td>
                            <td>20€</td>
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
                        <td id = "total">80</td>
                        <td>€</td>
                    </tr>
                    <tr>
                        <td> <div id="paypal-button-container"></div> </td>
                    </tr>
                </table>
            </div>
        </div>
        <section class="footer">
            <div class="container text-center">
                <div class="row">
                    <div class="col-md-3">
                        <h1>Links Úteis</h1>
                        <p>Política de Privacidade</p>
                        <p>Termos de Uso</p>
                        <p>Política de Returno</p>
                        <p>Cupões de Desconto</p>
                    </div>
                    <div class="col-md-3">
                        <h1>Grupo 10</h1>
                        <p>Sobre Nós</p>
                        <p>Contacta-nos</p>
                        <p>Faculdade de Ciências</p>
                        <p>Cupões de Desconto</p>
                    </div>
                    <div class="col-md-3 footer-image">
                        <img src="img/logofcul.jpg">
                        <p>Faculdade de Ciências da Universidade de Lisboa</p>
                    </div>
                </div>
            </div>
        </section>
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
if (isset($_SESSION['statusCode']) == "error") {

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
</body>
</html>
