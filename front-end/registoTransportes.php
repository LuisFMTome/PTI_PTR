<?php 
session_start();

$serverName = "sqldb05server1.database.windows.net"; // update me
$connectionOptions = array(
    "Database" => "sqldb1", // update me
    "Uid" => "ptrptisqldb", // update me
    "PWD" => "2SdULWb5ePk83jA" // update me
);
//Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);
if($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>
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
                    <li class="dropdown">
                        <button class="dropbtn"><i class="fa fa-plus-circle"></i>
                          <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-content">
                          <a href="registoTransportes.php">Registar Transporte</a>
                        </div>
                    </li>
                    <li><a href="conta.php"><i class="fa fa-user"></i></a></li>
                    <li><a href="carinho.html"><i class="fa fa-shopping-basket"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-5">
                <form action="registarTra.php" method="post">

                    <div class="p-2 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Veículo</h4>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="labels">Categoria</label>
                                <select id="" class="form-control" name="categoria">
                                    <option value="Ligeiro sem reboque">Ligeiro sem reboque</option>
                                    <option value="Ligeiro com reboque">Ligeiro com reboque</option>
                                    <option value="Pesado">Pesado</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Matrícula</label>
                                <input type="text" class="form-control" placeholder="Matrícula" name="matricula" value="">
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Quantidade de produtos</label>
                                <select id="choose2" name="quantidade" onchange= "getOption()">
                                    <option value="10">10</option>
                                    <option value="20">30</option>
                                    <option value="50">50</option>
                                    <option value="70">70</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            
                    
                        </div>
                        <div class="mt-5 text-center">
                            <button class="btn btn-success" name="addTra" type="submit">Registar Veículos</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
            
                <h4 class="text-right p-4">Veículos Registados</h1>
                <div style="overflow-x:auto;">
                <table class="table table-bordered table-lg table-light align-top">
                    <thead>
                      <tr>
                        <th scope="col" class="text-center">Trasportadora</th>
                        <th scope="col" class="text-center">Matrícula</th>
                        <th scope="col" class="text-center">Categoria</th>
                        <th scope="col" class="text-center">Quantidade</th>
                        <th scope="col" class="text-center">Acção</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
                        # ir buscar nif de transportadora logged in

                        $mailTran = $_SESSION['email'];
                        $query = "SELECT * FROM [dbo].[Transportadora] WHERE email='{$mailTran}'";
                        $result = sqlsrv_query($conn, $query);

                        if( $result === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                        if( sqlsrv_fetch( $result ) === false) {
                            die( print_r( sqlsrv_errors(), true));
                        }

                        $nif = sqlsrv_get_field( $result, 0);
                        $nomeTrans = sqlsrv_get_field( $result, 1);

                        # ir buscar veiculos associados a esta transportadora

                        $user_check_query = "SELECT * FROM [dbo].[Veiculo] WHERE transportadora ='$nif'";
                        //$stmt = sqlsrv_query( $conn, $user_check_query );
                        $veiculos = sqlsrv_query($conn, $user_check_query);
                        $query = sqlsrv_query($conn, $user_check_query, array(), array( "Scrollable" => 'static' ));
                        $row_count = sqlsrv_num_rows($query);


                        if ($row_count > 0) {
                            while ($row = sqlsrv_fetch_array($veiculos)) {

                                echo "<tr>";
                                echo "<td>" . $nomeTrans . "</td>";
                                echo "<td>" . $row['matricula'] . "</td>";
                                echo "<td>" . $row['categoria'] . "</td>";
                                echo "<td>" . $row['quantidade'] . "</td>";
                                echo "<td class='text-center'><a href='Delete'>Delete</a></td>";
                                echo "</tr>";
                            }
                        }
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

    <?php

        //echo "<p>teste</p>";
        if (isset($_SESSION['msg']) != "") {

            //echo "<p>teste2</p>";
        ?>

            <script>
                alert('<?php echo $_SESSION['msg']; ?>');
            </script>

        <?php
            unset($_SESSION['msg']);
        }

        ?>
    </body>