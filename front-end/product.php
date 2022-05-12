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
    if(isset($_GET['id'])){
        $query = 'SELECT * FROM [dbo].[Produto] WHERE pid = ?';
        $result = sqlsrv_query($conn, $Queryprodutos, array($_GET['id']), array( "Scrollable" => 'static' ));
        $produto = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC)
        if(!$produto){
            exit("Produto não existe")
        }
    }
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
                    <li><a href="index.html">Home</a></li>
                    <li><a href="produtos.html">Mercado</a></li>
                    <li><a href="conta.html"><i class="fa fa-user"></i></a></li>
                    <li><a href="carinho.html"><i class="fa fa-shopping-basket"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="header">
        <div class="side-menu">
            <ul>
                <li>Descontos<i class="fa fa-angle-right"></i>
                    <ul>
                        <li>Sub Menu 1</li>
                        <li>Sub Menu 1</li>
                        <li>Sub Menu 1</li>
                        <li>Sub Menu 1</li>
                    </ul>
                </li>
                <li>Computadores<i class="fa fa-angle-right"></i>
                    <ul>
                        <li>Sub Menu 2</li>
                        <li>Sub Menu 2</li>
                        <li>Sub Menu 2</li>
                        <li>Sub Menu 2</li>
                    </ul>
                </li>
                <li>Telemóveis<i class="fa fa-angle-right"></i>
                    <ul>
                        <li>Sub Menu 3</li>
                        <li>Sub Menu 3</li>
                        <li>Sub Menu 3</li>
                        <li>Sub Menu 3</li>
                    </ul>
                </li>
                <li>Livros<i class="fa fa-angle-right"></i>
                    <ul>
                        <li>Sub Menu 4</li>
                        <li>Sub Menu 4</li>
                        <li>Sub Menu 4</li>
                        <li>Sub Menu 4</li>
                    </ul>
                </li>
                <li>Jogos<i class="fa fa-angle-right"></i>
                    <ul>
                        <li>Sub Menu 5</li>
                        <li>Sub Menu 5</li>
                        <li>Sub Menu 5</li>
                        <li>Sub Menu 5</li>
                    </ul>
                </li>
                <li>Alimentos<i class="fa fa-angle-right"></i>
                    <ul>
                        <li>Sub Menu 6</li>
                        <li>Sub Menu 6</li>
                        <li>Sub Menu 6</li>
                        <li>Sub Menu 6</li>
                    </ul>
                </li>
            </ul>
        </div>
        
    </section>
    <div class="product-top">
        <img src="img/categoria1.jpeg">
        <div class="overlay-right">
            <button type="button" class="btn btn-secondary" title="Adicionar ao Carrinho">
                <i class="fa fa-shopping-cart"></i>
             </button>
        </div>
    </div>
    <div class="product-bottom text-center">
        <h3><?php echo $row['nome']?></h3>
        <h5>900€</h5>

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