<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Transportadora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"/>
    <link href="style.css" rel="stylesheet"/>
</head>
<body>
    <?php 
        session_start();
        include "openconn.php";
    ?>
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
                    <li class="dropdown">
                    <button class="dropbtn">
                        <?php echo $_SESSION["nome"] ?>
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-content">
                        <?php
                            if($_SESSION["tipo"] == "Transportadora"){
                                echo"<a href=registoTransportes.php>Registar veiculos</a>";
                                echo "<a href=gerirVeiculos.php>Ver encomendas</a>";
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
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img class="rounded-circle mt-5" width="200px" src="img/empty.jpeg">
                    <span class="font-weight-bold"><?php echo $_SESSION['nome'] ?></span>
                    <span class="text-black-50">
                        <button type="button" class="btn btn-success">Selecione uma foto</button>
                    </span>
                </div>
            </div>
            <div class="col-md-10">
                <div class="p-2 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Informações atuais de Perfil</h4><br></br>
                    </div>
                    <div class="row mt-3">
                        <?php $transportadora_check_query = "SELECT * FROM [dbo].[Transportadora] WHERE email= '$_SESSION[email]'";

                        $result = sqlsrv_query($conn, $transportadora_check_query);

                        if (sqlsrv_has_rows($result) != -1) {
                            echo ("nenhum dado encontrado");
                        } else {
                            echo"<table>";
                            echo "<tr>";
                                echo"<th>nif</th>";
                                echo"<th>nome</th>";
                                echo"<th>email</th>";
                                echo"<th>morada</th>";
                                echo"<th>codigoPostal</th>";
                            echo "</tr>";
                            while($row = sqlsrv_fetch_array($result)) {
                                echo "<tr>";
                                    echo "<td class='text-center'>".$row['nif']."</td>";
                                    echo "<td class='text-center'>".$row['nome']."</td>";
                                    echo "<td class='text-center'>".$row['email']."</td>";
                                    echo "<td class='text-center'>".$row['morada']."</td>";
                                    echo "<td class='text-center'>".$row['codigoPostal']."</td>";
                                    $nome = $row['nome'];
                                    $email = $row['email'];
                                    $morada = $row['morada'];
                                    $codigoPostal = $row['codigoPostal'];
                                echo "</tr>";
                            }
                            echo"</table>";
                        }
                        echo "<br>";
                        echo "<br>";
                        ?>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Detalhes de Perfil</h4>
                    </div>
                    <form action="edit_transportadora.php" method="post">
                        <div class="row mt-3">
                            <div class="col-md-12">
                            <label class="labels">Nome da Empresa a que o transporte pertence</label>
                            <input type="text" class="form-control" placeholder="Nome" name="nome_empresa" value="<?php echo $nome?>">
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Email</label>
                                <input type="text" class="form-control" placeholder="Email" name="email_empresa" value="<?php echo $email?>">
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Morada</label>
                                <input type="text" class="form-control" placeholder="Morada" name="morada_empresa" value="<?php echo $morada?>">
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Código Postal</label>
                                <!--<input type="text" class="form-control" placeholder="Código Postal" name="codPostal_empresa" value="<?php //echo $codigoPostal?>">-->
                                <input class="form-control" placeholder="Código Postal" type="text" value="<?php echo $codigoPostal?>" required name="codPostal_empresa" pattern="[0-9]{7}" title="7 numeros do codigo postal" />
                            </div>
                        </div>
                        <div class="mt-3 text-center">
                            <div class="col-md-4">
                                <input type="submit" value="Save Profile" name="edit_transportadora" class="btnL">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Eliminar Conta</h4>
                </div>
                <div class="row mt-3">
                    <form action="delete_conta.php" method="post">
                        <div class="col-md-12">
                            <label class="labels">Password</label>
                            <input type="password" class="form-control" placeholder="Password" name = "password" value="">
                        </div>
                        <div class="mt-3 text-center">
                            <div class="col-md-4">
                                <input type="submit" value="Eliminar conta" name="delete_conta" class="btnL">
                           </div>
                        </div>
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
</body>