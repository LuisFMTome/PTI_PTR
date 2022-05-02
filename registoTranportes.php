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
    <nav>
        <div class="top-nav-bar">
            <div class="search-box">
                <a href="index.html">
                    <img src="img/logotipo.png" class="logo">
                </a>
                <input type="text" class="form-control">
                <span class="input-group-text"><i class="fa fa-search"></i></span>
            </div>
            <div class="menu-bar">
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="produtos.html">Mercado</a></li>
                    <li class="dropdown">
                        <button class="dropbtn"><i class="fa fa-plus-circle"></i>
                          <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-content">
                          <a href="registoProduto.html">Registar Produtos</a>
                          <a href="registoArmazem.html">Registar Armazém</a>
                          <a href="registoTransportes.html">Registar Transporte</a>
                        </div>
                    </li>
                    <li><a href="conta.html"><i class="fa fa-user"></i></a></li>
                    <li><a href="carinho.html"><i class="fa fa-shopping-basket"></i></a></li>
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
                        <button class="btn btn-success" type="button"><input type="submit" value="registar Veiculos" name="register_Transp"></button>
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
                    while($row = mysqli_fetch_array($results)) {
                        echo"<tr>";
                        echo "<th scope="row"class="text-center">1</th>";
                        echo"<td class="text-center">"$row['categoria']"</td>";
                        echo"<td class="text-center">"$row['matricula']"</td>";
                        echo"<td class="text-center">"$row['transportadora']"</td>";
                        echo"<td class="text-center">"$row['categoria']"</td>";
                        echo"<td class="text-center">"$row['produto']"</td>";
                        echo"<tr>"
                    ?>
                    </tbody>
                  </table>
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