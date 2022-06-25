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

    $pagina = isset($_GET['p']) && is_numeric($_GET['p']) ? $_GET['p']: 1;
    //$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id']: -1;

    $produtosPágina = 9;
    $produtoInicial = ($pagina-1)*$produtosPágina;
    
    $Queryprodutos = "SELECT * FROM [dbo].[Produto] WHERE subtipo = '41' ORDER BY nome OFFSET " . $produtoInicial . " ROWS FETCH NEXT " . $produtosPágina . " ROWS ONLY";
    //"SELECT * FROM [dbo].[Produto] ORDER BY nome OFFSET " . $produtoInicial . "ROWS FETCH NEXT" . $produtosPágina . "ROWS ONLY";
    //"SELECT * FROM [dbo].[Produto] ORDER BY nome OFFSET 0 ROWS FETCH NEXT 8 ROWS ONlY";
    $QueryTotalProdutos = "SELECT * FROM [dbo].[Produto] WHERE subtipo = '41'";
    $queryProdutos_execute = sqlsrv_query($conn, $Queryprodutos, array(), array( "Scrollable" => 'static' ));
    $total_produtos_execute = sqlsrv_query($conn,$QueryTotalProdutos,array(),array( "Scrollable" => 'static' ));
    $total_produtos = sqlsrv_num_rows($total_produtos_execute);
    $numeroPaginas = ceil($total_produtos/$produtosPágina);


    
    
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"/>
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
                    <li><a href="index.php">Home</a></li>
                    <li><a href="mercado.php">Mercado</a></li>
                    <?php 
                    if (isset($_SESSION['email']) != "") {

                        if($_SESSION["tipo"] == "Consumidor"){

                    ?>
                        <li><a href="perfilUtilizador.php">Perfil</a></li>

                    <?php 
                        }elseif($_SESSION["tipo"] == "Fornecedor"){

                            ?>
                            
                            <li><a href="perfilFornecedor.php">Perfil</a></li>

                            <?php
                        }elseif($_SESSION["tipo"] == "Transportadora"){

                            ?>
                            
                            <li><a href="perfilTransportadora.php">Perfil</a></li>

                            <?php
                        }

                    }?>
                    
                    <li><a href="carrinho.php">Carrinho</a></li>

                    <?php 
                    if (isset($_SESSION['email']) != "") {

                    ?>
                    
                    <li><a href="logout.php">Logout</a></li>

                    <?php    
                    }else{

                    ?>
                    
                    <li><a href="conta.php">Login</i></a></li>
                    
                    <?php

                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <section class="header">
        <div class="side-menu">
        <ul>
            <a href="mercadoVestuario.php"><li>Vestuario<i class="fa fa-angle-right"></i></a>
                    <ul>
                        <a href="mercadoVestuario51.php"><li>Chapéus<i class="fa fa-angle-right"></i></a>
                        <a href="mercadoVestuario52.php"><li>Camisas<i class="fa fa-angle-right"></i></a>
                        <a href="mercadoVestuario53.php"><li>Casacos<i class="fa fa-angle-right"></i></a>
                        <a href="mercadoVestuario54.php"><li>Calças<i class="fa fa-angle-right"></i></a>
                        <a href="mercadoVestuario55.php"><li>Sapatos<i class="fa fa-angle-right"></i></a>
                    </ul>
                </li>
                <a href="mercadoCasa.php"><li>Casa<i class="fa fa-angle-right"></i></a>
                    <ul>
                        <a href="mercadoCasa21.php"><li>Sala de Estar<i class="fa fa-angle-right"></i></a>
                        <a href="mercadoCasa22.php"><li>Cozinha<i class="fa fa-angle-right"></i></a>
                        <a href="mercadoCasa23.php"><li>Casa de Banho<i class="fa fa-angle-right"></i></a>
                        <a href="mercadoCasa24.php"><li>Quarto<i class="fa fa-angle-right"></i></a>
                        <a href="mercadoCasa25.php"><li>Quintal<i class="fa fa-angle-right"></i></a>
                    </ul>
                </li>
                <a href="mercadoDesporto.php"><li>Desporto<i class="fa fa-angle-right"></i></a>
                    <ul>
                        <a href="mercadoDesporto31.php"><li>Ginasio<i class="fa fa-angle-right"></i></a>
                        <a href="mercadoDesporto32.php"><li>Futebol<i class="fa fa-angle-right"></i></a>
                        <a href="mercadoDesporto33.php"><li>Basket<i class="fa fa-angle-right"></i></a>
                        <a href="mercadoDesporto34.php"><li>Outdoor<i class="fa fa-angle-right"></i></a>
                        <a href="mercadoDesporto35.php"><li>Indoor<i class="fa fa-angle-right"></i></a>
                    </ul>
                </li>
                <a href="mercadoTecnologia.php"><li>Tecnologia<i class="fa fa-angle-right"></i></a>
                    <ul>
                        <a href="mercadoTecnologia41.php"><li>Portatéis<i class="fa fa-angle-right"></i></a>
                        <a href="mercadoTecnologia42.php"><li>Computadores<i class="fa fa-angle-right"></i></a>
                        <a href="mercadoTecnologia43.php"><li>Telemóveis<i class="fa fa-angle-right"></i></a>
                        <a href="mercadoTecnologia44.php"><li>Periféricos<i class="fa fa-angle-right"></i></a>
                        <a href="mercadoTecnologia45.php"><li>Televisões<i class="fa fa-angle-right"></i></a>
                    </ul>
                </li>
                <a href="mercadoAlimentacao.php"><li>Alimentação<i class="fa fa-angle-right"></i></a>
                    <ul>
                        <a href="mercadoAlimentacao11.php"><li>Vegetais<i class="fa fa-angle-right"></i></a>
                        <a href="mercadoAlimentacao12.php"><li>Fruta<i class="fa fa-angle-right"></i></a>
                        <a href="mercadoAlimentacao13.php"><li>Carne<i class="fa fa-angle-right"></i></a>
                        <a href="mercadoAlimentacao14.php"><li>Peixe<i class="fa fa-angle-right"></i></a>
                        <a href="mercadoAlimentacao15.php"><li>Outros<i class="fa fa-angle-right"></i></a>
                    </ul>
                </li>
            </ul>
        </div>
        
    </section>
    <section class="produtos">
        <div class="container">
            <div class="title-box">
                <h2>Portáteis</h2>
            </div>
            <div class="row">
            <?php
                $counter = 0;
               
                if($total_produtos > 0){

                    while ($row2 = sqlsrv_fetch_array($queryProdutos_execute)) {
                        if($counter < $produtosPágina){
                        ?>
                
                    
                    
            
                        <div class="card mx-auto col-md-3 col-10 mt-5">
                                <a href="product.php?id=<?=$row2['pid']?>">
                                <img src="img/categoria1.jpeg" class='mx-auto img-thumbnail' width="auto" height="auto"/>
                                </a>
                                    
                                    <div class="card-body text-center mx-auto">
                                        <div class='cvp'>
                                            <h5 class="card-title font-weight-bold"><?php  echo $row2['nome'];?></h5>
                                            <p class="card-text">299€</p>
                                            <a href="#" class="btn details px-auto">Ver Detalhes</a><br />
                                            <button type="button" class="btn btn-secondary" title="Adicionar ao Carrinho">
                                                <i class="fa fa-shopping-cart"></i>
                                            </button>
                                        </div>
                                    </div>
                        </div>
                <?php ++$counter;
                
                
                    if($counter % 3 == 0){
                        echo "</div>";
                        echo "<div class='row'>";
                        
                    }
                }
                    
                }
                if($counter % 3 != 0){
                    echo "</div>";
                    
                } 
            }

                
                               
                    ?>
                <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php for($pagina=1;$pagina<=$numeroPaginas;$pagina++): 
                        if($pagina = $pagina){?>
                        <li class="page-item">
                            <a href="mercado.php?p=<?=$pagina?>" class="page-link">
                                <?=$pagina?>
                            </a>
                        </li>
                            
                        <?php }else{?>
                            <li class="page-item">
                            <a href="mercado.php?p=<?=$pagina?>" class="page-link">
                                <?=$pagina?>
                            </a>
                        </li>
                        <?php }; ?>
                    <?php endfor;?>
                </ul>
                </nav>
            </div>
            
        </div>

    </section>
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
    <table class="table table-bordered table-lg table-light align-top">
                    <thead>
                      <tr>
                        <th scope="col" class="text-center">#</th>
                        <th scope="col" class="text-center">Nome do Produto</th>
                        <th scope="col" class="text-center">Morada</th>
                        <th scope="col" class="text-center">Código Postal</th>
                        <th scope="col" class="text-center">Tipo</th>
                        <th scope="col" class="text-center">Ação</th>
                        
                      </tr>
                    </thead>
                    <tbody>
<?php 

                        
                            

    $produtos_query = "SELECT * FROM [dbo].[Produto]";
    //$stmt = sqlsrv_query( $conn, $user_check_query );
    $produtos = sqlsrv_query($conn, $produtos_query);

    $query2 = sqlsrv_query($conn, $produtos_query, array(), array( "Scrollable" => 'static' ));
    $row_count2 = sqlsrv_num_rows($query2);

    if($row_count2 > 0){

        while ($row2 = sqlsrv_fetch_array($produtos)) {

            echo "<tr>";
            echo "<td>" . $row2['pid'] . "</td>";
            echo "<td>" . $row2['nome'] . "</td>";
            echo "<td>" . $row2['morada'] . "</td>";
            echo "<td>" . $row2['codigoPostal'] . "</td>";
            echo "<td class='text-center'><a href='Delete'>Delete</a></td>";
            echo "</tr>";

    }


    }

?>
                     
                    </tbody>
                </table>
</body>
</html>