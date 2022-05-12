<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Consumidor</title>
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
                    <li><a href="index.php">Home</a></li>
                    <li><a href="produtos.html">Mercado</a></li>
                    <li><a href="conta.php"><i class="fa fa-user"></i></a></li>
                    <li><a href="carinho.html"><i class="fa fa-shopping-basket"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img class="rounded-circle mt-5" width="200px" src="img/empty.jpeg">
                    <span class="font-weight-bold"><?php echo $_SESSION["nome"] ?></span>
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
                        <?php 
                        $consumidor_check_query = "SELECT * FROM [dbo].[Consumidor] WHERE email='{$_SESSION["email"]}'";
                        $result = sqlsrv_query($conn, $consumidor_check_query);

                        if (sqlsrv_has_rows($result) != -1) {
                            echo ("nenhum dado encontrado Utilizadores");
                        } else {
                            echo"<table>";
                            echo "<tr>";
                                echo"<th>id</th>";
                                echo"<th>nome</th>";
                                echo"<th>email</th>";
                                echo"<th>morada</th>";
                                echo"<th>codigoPostal</th>";
                            echo "</tr>";
                            while($row = sqlsrv_fetch_array($result)) {
                                echo "<tr>";
                                    echo "<td class='text-center'>".$row['cid']."</td>";
                                    echo "<td class='text-center'>".$row['nome']."</td>";
                                    echo "<td class='text-center'>".$row['email']."</td>";
                                    echo "<td class='text-center'>".$row['morada']."</td>";
                                    echo "<td class='text-center'>".$row['codigoPostal']."</td>";
                                echo "</tr>";
                            }
                            echo"</table>";
                        }
                        echo "<br>";
                        ?>
                    
                </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Detalhes de Perfil</h4>
                    </div>
                    <form action="edit_utilizador.php" method="post">
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="labels">Nome</label>
                                <input type="text" class="form-control" placeholder="Nome" name="nome_novo" value="">
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Email</label>
                                <input type="text" class="form-control" placeholder="Email" name="email_novo" value="">
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Morada</label>
                                <input type="text" class="form-control" placeholder="Morada" name="morada_nova" value="">
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Código Postal</label>
                                <input type="text" class="form-control" placeholder="Código Postal" name="codPostal_novo" value="">
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <button class="btn btn-success" type="button"><input type="submit" value="Save Profile" name="edit_utilizador"></button>
                        </div>
                    </form>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Eliminar Conta</h4>
                    </div>
                    <form action="delete_conta.php" method="post">
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="labels">Password</label>
                                <input type="password" class="form-control" placeholder="Password" name="password" value="">
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <button class="btn btn-success" type="button"><input type="submit" value="Eliminar conta" name="delete_conta"></button>
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