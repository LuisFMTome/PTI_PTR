<?php 
session_start();
//include('login.php');
//include('registar.php');
include "openconn.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historico de encomendas</title>
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
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-8">
            
                <h3 class="text-right p-4">Lista das encomendas de <?php echo $_SESSION["nome"] ?></h3>
                <div style="overflow-x:auto;">
                <table class="table table-bordered table-lg table-light align-top">
                    <thead>
                      <tr>
                        <th scope="col" class="text-center">Cod_Postal de origem</th>
                        <th scope="col" class="text-center">Cod_Postal de destino</th>
                        <th scope="col" class="text-center">Produto</th>
                        <th scope="col" class="text-center">Poluição</th>
                        <th scope="col" class="text-center">Data limite de cancelamento</th>
                        <th scope="col" class="text-center">Estado</th>
                        <th scope="col" class="text-center">Cancelar</th>

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
                            function EstadoName($conn, $idEst) {
                                $estado_query = "SELECT * FROM [dbo].[Estado] WHERE id = $idEst";
                                $estado = sqlsrv_query($conn, $estado_query);
                                $rowE = sqlsrv_fetch_array($estado);
                                $nome_estado = $rowE['fase'];
                                return $nome_estado;
                            }
                            //if ($_SESSION['tipo'] === "Consumidor"){
                            //}
                            //$cid = 0;
                            $codigoPostal = '';
                            $consumidor_query = "SELECT * FROM [dbo].[Consumidor] WHERE email = '$_SESSION[email]'";
                            $consumidor = sqlsrv_query($conn, $consumidor_query);
                            $row_count1 = sqlsrv_num_rows($consumidor);
                            $row = sqlsrv_fetch_array($consumidor);
                            $cid = $row['cid'];
                            //echo $cid;
                            $codigoPostal = $row['codigoPostal'];
                            $encomenda_query = "SELECT * FROM [dbo].[Encomenda] WHERE consumidor= $cid";
                            //$encomendas = sqlsrv_query($conn, $encomenda_query);
                            $encomendas = sqlsrv_query($conn, $encomenda_query, array(), array( "Scrollable" => 'static' ));
                            $row_count = sqlsrv_num_rows($encomendas);

                            if( $row_count === false ) {
                                die( print_r( sqlsrv_errors(), true));
                            }
                            //echo $row_count;
                            #if ($row_count > 0) {
                            while ($row = sqlsrv_fetch_array($encomendas)) {
                                
                                echo "<tr>";
                                echo "<form action='cancelEncomenda.php' method='post'>";
                                echo "<input type='hidden' name='idEncomenda' value=".$row['pedido'].">";
                                echo "<td class=text-left>" . $row['origem'] . "</td>";
                                echo "<td class=text-left>" . $row['destino'] . "</td>";
                                echo "<td class=text-left>" . ProductName($conn, $row['produto']) . "</td>";
                                echo "<td class=text-left>" . $row['poluicao'] . "</td>";
                                echo "<td class=text-left>" . $row['cancelamento']->format('Y-m-d H:i:sP') . "</td>";
                                echo "<td class=text-left>" . EstadoName($conn, $row['estado']) . "</td>";
                                ?>
                                <td><button type="submit" name="delete_encomenda" class=btn-sm>Cancelar</button></td>
                                <?php
                                //echo "<td class=text-left><input type='submit' value='Cancelar' name='delete_encomenda' class=btn-sm></td>";
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
</body>