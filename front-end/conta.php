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
    <!--<script src="js/libs/jquery.min.js" type="text/javascript"></script>-->
    <!--<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="sweetalert2.all.min.js"></script> -->

    
</head>

<body>
    <nav class="navigation">
        <div class="top-nav-bar">
            <div class="search-box">
                <a href="index.php">
                    <img src="img/logotipo.png" class="logo">
                </a>
                <input type="text" class="form-control">
                <span class="input-group-text"><i class="fa fa-search"></i></span>
            </div>
            <div class="menu-bar">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="produtos.html">Mercado</a></li>
                    <li><a href="conta.php"><i class="fa fa-user"></i></a></li>
                    <li><a href="carinho.html"><i class="fa fa-shopping-basket"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="account-page">
        <div class="container">
            <div class="col-2">
                <div class="form-container">
                    <h2>Login</h2>
                    <form id="LoginForm" method="post" action="login.php">
                        <label for="users">Escolha o tipo de utilizador:</label>
                        <select id="choose1" name="tipoUtili">
                            <option value="comprador">Consumidor</option>
                            <option value="transportadora">Transportadora</option>
                            <option value="fornecedor">Fornecedor</option>
                        </select>
                        <input type="text" placeholder="email" name="email" required>
                        <input type="password" placeholder="password" name="pass" required>
                        <input type="submit" value="Login" class="btnL" name="login">
                        <a href="">Esqueci Password</a>
                    </form>
                </div>
            </div>
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

    //echo "<p>teste</p>";
    if (isset($_SESSION['status']) != "") {

        //echo "<p>teste2</p>";
    ?>

        <script>
            alert('<?php echo $_SESSION['status']; ?>');
        </script>

    <?php
        unset($_SESSION['status']);
    }

    ?>

</body>

</html>