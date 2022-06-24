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
                            }elseif($_SESSION["tipo"] == "Transportadora"){
                                echo "<li><a class=dropdown-item href=perfilTransportadora.php>Perfil</a></li>";
                            }
                            ?>
                        </ul>
                        </li>
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