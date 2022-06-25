<?php 
session_start();
//include('login.php');
//include('registar.php');

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
    <title>Gerir veiculos e encomendas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"/>
    <link href="histEncStyle.css" rel="stylesheet"/>
    <link href="style.css" rel="stylesheet"/>
    <script src="sweetalert2.all.min.js"></script>
</head>
<body>
    <nav>
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
                    <li class="dropdown">
                        <button class="dropbtn"><i class="fa fa-plus-circle"></i>
                          <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-content">
                          <a href="registoTransportes.php">Registar Transporte</a>
                        </div>
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
                            if($_SESSION["tipo"] == "Consumidor"){
                                echo "<a href=perfilUtilizador.php>Perfil</a>";
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
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-8">
            
                <h3 class="text-right p-4">Lista dos veiculos de <?php echo $_SESSION["nome"] ?> com encomendas pedidas </h3>
                <div style="overflow-x:auto;">
                <table class="table table-bordered table-lg table-light align-top">
                    <thead>
                      <tr>
                        <th scope="col" class="text-center">Matricula</th>
                        <th scope="col" class="text-center">Categoria</th>
                        <th scope="col" class="text-center">Produto</th>
                        <th scope="col" class="text-center">Estado</th>
                        <th scope="col" class="text-center">Aceitar</th>
                        <th scope="col" class="text-center">Rejeitar</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                            function ProductName($conn, $idProd) {
                                $produto_query = "SELECT * FROM [dbo].[Produto] WHERE pid = $idProd";
                                $produto = sqlsrv_query($conn, $produto_query);
                                $rowP = sqlsrv_fetch_array($produto);
                                $nome_prod = $rowP['nome'];
                                return $nome_prod;
                            }
                            function encomendaProduto($conn, $idProd, $veiculo) {
                                $encomenda_query = "SELECT * FROM [dbo].[Encomenda] WHERE produto = '$idProd' AND veiculo = '$veiculo'";
                                $encomenda = sqlsrv_query($conn, $encomenda_query);
                                $rowE = sqlsrv_fetch_array($encomenda);
                                $pedido = $rowE['pedido'];
                                return $pedido;
                            }
                            function encomendaFase($conn, $idEnc) {
                                $encomenda_query = "SELECT * FROM [dbo].[Encomenda] WHERE pedido = $idEnc";
                                $encomenda = sqlsrv_query($conn, $encomenda_query);
                                $rowE = sqlsrv_fetch_array($encomenda);
                                $estado = $rowE['estado'];
                                return $estado;
                            }
                            function EstadoName($conn, $idEst) {
                                $estado_query = "SELECT * FROM [dbo].[Estado] WHERE id = $idEst";
                                $estado = sqlsrv_query($conn, $estado_query);
                                $rowE = sqlsrv_fetch_array($estado);
                                $nome_estado = $rowE['fase'];
                                return $nome_estado;
                            }
                            $transportadora_query = "SELECT * FROM [dbo].[Transportadora] WHERE email= '$_SESSION[email]'";
                            $transportadora = sqlsrv_query($conn, $transportadora_query);
                            $row = sqlsrv_fetch_array($transportadora);
                            $nif = $row['nif'];
                            $veiculos_query = "SELECT * FROM [dbo].[Veiculo] WHERE (transportadora = $nif AND NOT produto IS NULL)";
                            $veiculos = sqlsrv_query($conn, $veiculos_query);
                            $row_count = sqlsrv_num_rows($veiculos);
                            #if ($row_count >= 0) {
                                while ($row = sqlsrv_fetch_array($veiculos)) {
                                    echo "<tr>";
                                    echo "<form action='aceitarEncomenda.php' method='post'>";
                                    $encomenda = encomendaProduto($conn, $row['produto'], $row['matricula']);
                                    $estado = encomendaFase($conn, $encomenda);
                                    echo "<td class=text-center>" . $row['matricula'] . "</td>";
                                    echo "<td class=text-center>" . $row['categoria'] . "</td>";
                                    echo "<td class=text-left>" . ProductName($conn, $row['produto']) . "</td>";
                                    echo "<input type='hidden' name='idEncomenda' value=".$encomenda.">";
                                    echo "<td class=text-left>" . EstadoName($conn, $estado) . "</td>";
                                    if($estado == 0){
                                        echo "<td><input type='submit' value='aceitar' name='aceitar' class=btn-sm></td>";
                                    }
                                    echo "</form>";
                                    echo "<form action='rejeitarEncomenda.php' method='post'>";
                                    echo "<input type='hidden' name='idEncomenda' value=".$encomenda.">";
                                    echo "<input type='hidden' name='matricula' value=".$row['matricula'].">";
                                    if($estado == 0){
                                        echo "<td><input type='submit' value='rejeitar' name='rejeitar' class=btn-sm></td>";
                                    }
                                    echo"</form>";
                                    echo "</tr>";
                                }
                            #}
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