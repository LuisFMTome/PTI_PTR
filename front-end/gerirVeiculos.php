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
                                if($_SESSION["tipo"] == "Transportadora"){
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