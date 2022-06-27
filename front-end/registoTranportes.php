<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registo Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"/>
    <link href="registoArmazem.css" rel="stylesheet"/>
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
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-5">
                <div class="p-2 py-5">
                <form action="registarTransportadora.php" method="post"></form>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Veículo</h4>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="labels">Veículo</label>
                            <input type="text" class="form-control" placeholder="Veículo" name="veiculo" value="">
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Matrícula</label>
                            <input type="text" class="form-control" placeholder="Matrícula" name="matricula" value="">
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Produto</label>
                            <input type="text" class="form-control" placeholder="Produto" name="produto" value="">
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <button class="btn btn-success" type="button"><input type="submit" value="registar Veiculos" name="addTransporte"></button>
                    </div>
                </form>
                </div>
            </div>
            <div class="col-md-6">
            
                <h4 class="text-right p-4">Veículos Registados</h1>
                <div style="overflow-x:auto;">
                <table class="table table-bordered table-lg table-light align-top">
                    <thead>
                      <tr>
                        <th scope="col" class="text-center">#</th>
                        <th scope="col" class="text-center">Veículo</th>
                        <th scope="col" class="text-center">Matrícula</th>
                        <th scope="col" class="text-center">Produto</th>
                        <th scope="col" class="text-center">Acção</th>
                      </tr>
                    </thead>
                    <tbody>
                    <tr>
                    <th scope="row"class="text-center">1</th>
                        <td class="text-center">Mark</td>
                        <td class="text-center">Otto</td>
                        <td class="text-center">@mdo</td>
                    <td class="text-center"><a href="Delete">Delete</a></td>
                    </tr>
                    <?php
                    $query = "SELECT * FROM [dbo].[Veiculo]";
                    $results = mysqli_query($conn, $query);
                    $row = 0;
                    if (sqlsrv_has_rows($results) != -1) {
                        echo ("nao há veiculos");
                    } else {
                        while($row = mysqli_fetch_array($results)) {
                            echo"<tr>";
                            echo "<th scope="row"class="text-center">1</th>";
                            echo"<td class="text-center">"$row['categoria']"</td>";
                            echo"<td class="text-center">"$row['matricula']"</td>";
                            echo"<td class="text-center">"$row['transportadora']"</td>";
                            echo"<td class="text-center">"$row['categoria']"</td>";
                            echo"<td class="text-center">"$row['produto']"</td>";
                            echo"<tr>"
                        }
                    }
                    ?>
                    </tbody>
                  </table>
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
    </body>
    <form action="registarTransportadora.php" method="post">
        <div class="row padding">
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-6">
                <div class="form-outline mb-4">
                    <input type="text" name="username" id="usernameT" class="form-control form-control-lg" placeholder="Username" />
                </div>
                <div class="form-outline mb-4">
                    <input type="text" name="nome_empresa" id="empresaT" class="form-control form-control-lg" placeholder="Nome da empresa" />
                </div>
                <div class="form-outline mb-4">
                  <input type="password" name="password" id="passT" class="form-control form-control-lg" placeholder="Password" />
                </div>
            <!--</div>-->
            <!--<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-6">-->
                <div class="form-outline mb-4">
                  <input type="email" name="email" id="mailT" class="form-control form-control-lg" placeholder="E-mail de contacto" />
                </div>
                <div class="pt-1 mb-4">
                  <button class="btn btn-dark btn-lg btn-block" type="button"><input type="submit" value="Register" name="register_Transp"></button>
                </div>
            </div>
        </div>
    </form>