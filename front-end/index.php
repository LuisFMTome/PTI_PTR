<?php
session_start();
//$mailTeste = $_SESSION['email'];
//$ola = isset($_SESSION["tipo"]);
//echo "$ola";
//echo "$mailTeste";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"/>
    <link href="style.css" rel="stylesheet"/>
</head>
<body>
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
                    <li><a href="carrinho.php">Carrinho</a></li>
                    <?php 
                    if (isset($_SESSION['email']) != "") {?>
                        <li class="dropdown">
                        <button class="dropbtn">
                            <?php echo $_SESSION["nome"] ?>
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-content">
                            <?php
                            if($_SESSION["tipo"] == "Consumidor"){
                                echo "<a href=perfilUtilizador.php>Perfil</a>";
                                echo "<a href=histEncomendas.php>Encomendas</a>";
                            }elseif($_SESSION["tipo"] == "Fornecedor"){
                                echo "<a href=perfilFornecedor.php>Perfil</a>";
                            }elseif($_SESSION["tipo"] == "Transportadora"){
                                echo "<a href=perfilTransportadora.php>Perfil</a>";
                            }
                            ?>
                            <a href="logout.php">Logout</a>
                        </div>
                    <?php }else{ ?>
                        <li><a href="conta.php">Login</i></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">   
        <div class="row">
            <div class="col-2"> 
                    <?php  

                        if(isset($_SESSION['nome'])){
                            //echo "<h1>Conta " . $_SESSION['tipo'] . " inicializada</h1>";
                            
                            echo "<h1>Bem Vindo " . $_SESSION['nome'] . " ( " . $_SESSION['tipo'] . " )</h1>";
                        } 
                    ?>
                
                <h2>Dê às suas compras <br> um novo impacto ambiental</h2>
                <p>Todas as suas compras...</p>
                <a href="mercado.php" class="btn">Compre agora<i class="fa fa-arrow-right"></i></a>
            </div>
            <div class="col-2">
                <img src="img/product2.webp">
            </div>
        </div>
        <div class="developers">
            <div class="small-container">
                <div class="row">
                    <h2>Developers</h2>
                    <div class="col-3">
                        <img src="img/andre.jpg">
                        <h3>André Santos</h3>
                    </div>
                    <div class="col-3">
                        <img src="img/goncalo.jpg">
                        <h3>Gonçalo Ferreira</h3>
                    </div>
                    <div class="col-3">
                        <img src="img/joao.jpg">
                        <h3>João Nunes</h3>
                    </div>
                    <div class="col-3">
                        <img src="img/luis.jpg">
                        <h3>Luís Tomé</h3>
                    </div>
                    <div class="col-3">
                        <img src="img/manuel.jpg">
                        <h3>Manuel Vicente</h3>
                    </div>
                    <div class="col-3">
                        <img src="img/viana.jpg">
                        <h3>João Viana</h3>
                    </div>
                </div>
            </div>
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
</body>
</html>