<?php
session_start();
//include("login.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> 
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="style.css" rel="stylesheet" />
    <script src="sweetalert2.all.min.js"></script>
    <!--<script src="js/libs/jquery.min.js" type="text/javascript"></script>-->
    <!--<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="sweetalert2.all.min.js"></script> -->

    
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

    <div class="account-page">
        <div class="container">
            <div class="col-2">
                <div class="form-container">
                    <h2>Registar</h2>
                    <form id="RegisterForm" action="registar.php" method="post">
                        <label for="users">Escolha o tipo de utilizador:</label>
                        <select id="choose2" name="tipoUtili" onchange= "getOption()">
                            <option value="comprador">Consumidor</option>
                            <option value="transportadora">Transportadora</option>
                            <option value="fornecedor">Fornecedor</option>
                        </select>
                        <input type="text" placeholder="username" name="nome" required>
                        <input type="password" placeholder="password" name="pass" required>
                        <input type="email" placeholder="email" name="email" required>
                        <?php echo "<div id='nif'></div>";?>
                        <input type="submit" value="Registar" name="registar" class="btnL">
                    </form>
                </div>
            </div>

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


    <script>
        var LoginForm = document.getElementById("LoginForm");
        var RegisterForm = document.getElementById("RegisterForm");
        var indicator = document.getElementById("indicator");

        function register() {
            RegisterForm.style.transform = "translateX (0px)";
            LoginForm.style.transform = "translateX (0px)";
        }

        function login() {
            RegisterForm.style.transform = "translateX (300px)";
            LoginForm.style.transform = "translateX (300px)";
        }
    </script>

    <script type="text/javascript">
        function getOption() {
            if (document.getElementById("choose2").value == 'transportadora') {
                document.getElementById("nif").innerHTML = '<input type="nif" placeholder="nif" name="nif">';
            } else if (document.getElementById("choose2").value != 'transportadora') {
                document.getElementById("nif").innerHTML = "";
            }

        }
    </script>

    <?php 
         if(isset($_SESSION['statusCode']) != ""){
                ?>
              
        
        <script>
                document.addEventListener("DOMContentLoaded", function(event) {
                    
                    Swal.fire({
                    title: "Email já utilizado!",
                    text: "Tente outra vez",
                    icon: "error",
                });
                
                });


            
        </script>
        <?php 
    
         }
         unset($_SESSION['status']);
         unset($_SESSION['statusCode']);

        
    

    ?>

</body>

</html>