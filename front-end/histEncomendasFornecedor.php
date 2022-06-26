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
                        <th scope="col" class="text-center">Veiculo</th>
                        <th scope="col" class="text-center">Estado</th>
                        <th scope="col" class="text-center">Escolher Veiculo</th>

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
                            $fornecedor_query = "SELECT * FROM [dbo].[Fornecedor] WHERE email = '$_SESSION[email]'";
                            $fornecedor = sqlsrv_query($conn, $fornecedor_query);
                            $row_count1 = sqlsrv_num_rows($fornecedor);
                            $row = sqlsrv_fetch_array($fornecedor);
                            $fid = $row['fid'];
                            //echo $fid;

                            $estadoTemp = 3;
                            $encomendas_query = "SELECT * FROM [dbo].[Encomenda] where estado !='$estadoTemp'";
                            $encomendas = sqlsrv_query($conn, $encomendas_query, array(), array( "Scrollable" => 'static' ));

                            while ($row = sqlsrv_fetch_array($encomendas)) {

                                $idProd = $row['produto'];

                                $produto_query = "SELECT * FROM [dbo].[Produto] WHERE pid='$idProd'";
                                $produto = sqlsrv_query($conn, $produto_query);
                                if( $produto === false ) {
                                    die( print_r( sqlsrv_errors(), true));
                                }
                                if( sqlsrv_fetch( $produto ) === false) {
                                    die( print_r( sqlsrv_errors(), true));
                                }
                                $cPostalArm = sqlsrv_get_field( $produto, 3);

                                //$cPostalArm = $row2['codigoPostal'];

                                $armazem_query = "SELECT * FROM [dbo].[Armazem] WHERE codigoPostal ='$cPostalArm'";
                                $armazem = sqlsrv_query($conn, $armazem_query);
                                $row2 = sqlsrv_fetch_array($armazem);

                                $ifForn = $row2['fornecedor'];

                                if($ifForn == $fid){

                                    echo "<tr>";
                                    echo "<form action='escolherVeiculo.php' method='post'>";
                                    echo "<input type='hidden' name='idEncomenda' value=".$row['pedido'].">";
                                    echo "<td class=text-left>" . $row['origem'] . "</td>";
                                    echo "<td class=text-left>" . $row['destino'] . "</td>";
                                    echo "<td class=text-left>" . ProductName($conn, $row['produto']) . "</td>";
                                    echo "<td class=text-left>" . $row['poluicao'] . "</td>";
                                    echo "<td class=text-left>" . $row['cancelamento']->format('Y-m-d H:i:sP') . "</td>";
                                    echo "<td class=text-left>" . $row['veiculo'] . "</td>";
                                    echo "<td class=text-left>" . EstadoName($conn, $row['estado']) . "</td>";
                                    if($row['veiculo'] == null){

                                    ?>
                                    
                                    <td><button type="submit" name="delete_encomenda" class=btn-sm>Escolher</button></td>
                                    <?php
                                    }
                                    //echo "<td class=text-left><input type='submit' value='Cancelar' name='delete_encomenda' class=btn-sm></td>";
                                    echo"</form>";
                                    echo "</tr>";

                                }

                                


                            }
                            /*
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
                            */
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