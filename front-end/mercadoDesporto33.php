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
    $Queryprodutos = "SELECT * FROM [dbo].[Produto] WHERE subtipo = '33' ORDER BY nome OFFSET " . $produtoInicial . " ROWS FETCH NEXT " . $produtosPágina . " ROWS ONLY";

    //$Queryprodutos = "SELECT * FROM [dbo].[Produto] p, [dbo].[Subtipo] s WHERE p.subtipo = s.sid AND s.tipo = '1' ORDER BY nome OFFSET " . $produtoInicial . " ROWS FETCH NEXT " . $produtosPágina . " ROWS ONLY";
    $QueryTotalProdutos = "SELECT * FROM [dbo].[Produto] WHERE subtipo = '33'";
    $queryProdutos_execute = sqlsrv_query($conn, $Queryprodutos, array(), array( "Scrollable" => 'static' ));
    $total_produtos_execute = sqlsrv_query($conn,$QueryTotalProdutos,array(),array( "Scrollable" => 'static' ));
    $total_produtos = sqlsrv_num_rows($total_produtos_execute);
    
    $numeroPaginas = ceil($total_produtos/$produtosPágina);

    

if(isset($_POST["addCart"])){

    $idTemp = $_GET["id"];

    $query = "SELECT * FROM [dbo].[Produto] WHERE pid='{$idTemp}'";
    $result = sqlsrv_query($conn, $query);
    if( $result === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_fetch( $result ) === false) {
        die( print_r( sqlsrv_errors(), true));
    }
    $preco = sqlsrv_get_field( $result, 5);

    if(isset($_SESSION["cart"])){

        $item_array_id = array_column($_SESSION["cart"], "item_id");        
        if(!in_array($_GET["id"], $item_array_id)){

            $count = count($_SESSION["cart"]);
            $item_array = array(
                'item_id' => $_GET["id"],
                'item_price' => $preco
                //'item_price' => 12
            );
            $_SESSION["cart"][$count] = $item_array;

        }else{

            //echo '<script>alert("item ja no carrinho")</script>';
            ?>
            <script>
            
                document.addEventListener("DOMContentLoaded", function(event) {
                    
                    Swal.fire({
                    title: "item ja no carrinho",
                    text: "clique ok",
                    icon: "error", //warning
                });
                
                });
        
            </script>

            <?php


        }

    }else{

        $item_array = array(
            'item_id' => $_GET["id"],
            'item_price' => $preco
        );
        $_SESSION["cart"][0] = $item_array;

    }
    //$temp = $_SESSION["cart"][0];
    //echo $temp;
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
    <script src="sweetalert2.all.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<script type="text/javascript">
    var preco1 = null
    var preco2 = null
    var poluicao1 = null
    var poluicao2 = null
    var nome1 = null
    var nome2 = null
    var flag = false
    function produto(nome,morada,preco,poluicao){
        console.log("ola");
        //var produto1IsEmpty = document.getElementById('produto1').innerHTML == "";
        //var produto2IsEmpty = document.getElementById('produto2').innerHTML == "";
        //console.log(produto1IsEmpty)
        if( $('#produto1').is(':empty') ) {
            
            var linkMaps1 = "http://maps.google.com/?q=" + morada;
            preco1 = parseInt(preco)
            poluicao1 = parseInt(poluicao)
            nome1 = nome
            document.getElementById('produto1').innerHTML += "<h5>"+nome+"</h5>";
            document.getElementById('produto1').innerHTML += "<h5>Morada:</h5>" + "<a href="+linkMaps1+" class='text-decoration-none'>" + morada + "</a>";
            document.getElementById('produto1').innerHTML += "<h5>Preço:</h5>"+"<p>"+preco+ "€" +"</p>";
            document.getElementById('produto1').innerHTML += "<h5>Poluição:</h5>"+"<p>"+poluicao+"</p>";

       }else{
        if( $('#produto2').is(':empty') ) {
            preco2 = parseInt(preco)
            poluicao2 = parseInt(poluicao)
            nome2 = nome
            flag = true
                var linkMaps1 = "http://maps.google.com/?q=" + morada
                document.getElementById('produto2').innerHTML += "<h5>"+nome+"</h5>";
                document.getElementById('produto2').innerHTML += "<h5>Morada:</h5>" + "<a href="+linkMaps1+"class='text-decoration-none'>" + morada + "</a>";
                document.getElementById('produto2').innerHTML += "<h5>Preço:</h5>" + "<p>"+preco+"€"+"</p>";
                document.getElementById('produto2').innerHTML += "<h5>Poluição:</h5>"+"<p>"+poluicao+"</p>";

            }
            

        }
        

    }

    function reset(){
        
        document.getElementById('produto1').innerHTML = "";
        document.getElementById('produto1').innerHTML = "";
        document.getElementById('produto1').innerHTML = "";
        document.getElementById('produto1').innerHTML = "";

        document.getElementById('produto2').innerHTML = "";
        document.getElementById('produto2').innerHTML = "";
        document.getElementById('produto2').innerHTML = "";
        document.getElementById('produto2').innerHTML = "";

        document.getElementById('comparacao').innerHTML = "";
        document.getElementById('comparacao').innerHTML = "";
        document.getElementById('comparacao').innerHTML = "";
        document.getElementById('comparacao').innerHTML = "";

        var preco1 = null
        var preco2 = null
        var poluicao1 = null
        var poluicao2 = null
        var nome1 = null
        var nome2 = null
   

    }

    function resultado(){
        if( $('#comparacao').is(':empty') ) {
        absPreco = Math.abs(preco1-preco2)
        absPoluicao = Math.abs(poluicao1-poluicao2)
        if(preco1>preco2){
            strPreco = nome2 + " é mais barato " + absPreco+"€";
        }else if(preco1<preco2){
            strPreco = nome1 + " é mais barato " + absPreco+"€";

        }else{
            strPreco = "Ambos custam o mesmo";

        }


        if(poluicao1>poluicao2){
            strPoluicao = nome2 + " gasta menos " + absPoluicao + "kwH na sua produção";
        }else if(preco1<preco2){
            strPoluicao = nome1 + " gastam menos " + absPoluicao + "kwH na sua produção";

        }else{
            strPoluicao = "Ambos gastam o mesmo na sua produção";

        }
        if(flag === true){
            document.getElementById('comparacao').innerHTML += "<h5>Diferença preços:</h5>" + "<p>"+strPreco+"</p>";
            document.getElementById('comparacao').innerHTML += "<h5>Diferença na poluição:</h5>" + "<p>"+strPoluicao+"</p>";

        }
        
        

    }
}

    
</script>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: green;">
    <div class="container-fluid">
        <i class="fa fa-bars" id="menu-btn" onclick="openmenu()"></i>
        <i class="fa fa-times" id="close-btn" onclick="closemenu()"></i>
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
                        <a class="nav-link active" href=faq.php><i class="bi bi-question-circle"></i></a> 
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
    <section class="header">
        <div class="side-menu" id="side-menu">
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
                
                <h2>Basket</h2>
            </div>
            <div class="row">
            <div class="col-8 card">
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
                            <form method="post" action="mercado.php?action=add&id=<?php echo $row2['pid']; ?>">
                                <div class="card-body text-center mx-auto">
                                    <div class='cvp'>
                                        <h5 class="card-title font-weight-bold"><?php  echo $row2['nome'];?></h5>
                                        <p class="card-text"><?php  echo $row2['preco'] . "€";?></p>
                                        <br/>
                                        <button type="submit" name="addCart" class="btn btn-secondary" title="Adicionar ao Carrinho">
                                            <i class="fa fa-shopping-cart"></i>
                                        </button>
                                        
                                    </div>
                                </div>
                            </form>
                            <button onclick="produto('<?php echo $row2['nome']?>','<?php  echo $row2['morada']?>','<?php  echo $row2['preco']?>','<?php  echo $row2['poluicao']?>')" class="btn btn-secondary" title="Comparar produto">
                                                Comparar produto
                                            </button>
                        </div>

                    
                
                <?php ++$counter;
                
                    if($counter % 3 == 0){
                        
                        echo "</div>";
                        echo "<div class='row'>";
                        
                    }
                }
                    
            }
        }

                
                               
                    ?>
            </div>
            </div>
            
            <div class="col-4 p-5 t-1 card sticky-top">
                
                <div class="row">
                    <div class="d-table-cell align-middle">
                        
                
                            <h3><b>Comparar produtos</b></h3>
                        
                        </div>
                </div>
                <div class="row">
                    <div class="d-table-cell align-middle">
                        
                
                        <h3><b>Primeiro produto:</b></h3>
                        
                        <div id="produto1"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="d-table-cell align-middle">
                        
                
                            <h3><b>Segundo produto:</b></h3>
                        
                        <div id="produto2"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="d-table-cell align-middle">
                        <h3><b>Diferença entre ambos:<b></h3>
                        <div id="comparacao"></div>
                    </div>   
                </div> 
                <div class="row">
                    <div class="d-table-cell align-middle">
                    <button onclick="reset()" class="btn btn-secondary" title="Reset Dados de Comparação">
                                                Reset
                                            </button>
                    </div> 
                    <button onclick="resultado()" class="btn btn-secondary" title="Resultado Dados de Comparação">
                                                Resultado
                                            </button>
                    </div>   
                </div> 
                 
            </div>
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
    <script>
        function openmenu()
            {
                document.getElementById("side-menu").style.display="block";
                document.getElementById("menu-btn").style.display="none";
                document.getElementById("close-btn").style.display="block";
            }
        function closemenu()
            {
                document.getElementById("side-menu").style.display="none";
                document.getElementById("menu-btn").style.display="block";
                document.getElementById("close-btn").style.display="none";
            }
    </script>  
</body>
</html>