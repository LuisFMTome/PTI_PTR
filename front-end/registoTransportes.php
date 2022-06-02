<?php 
session_start();
include "openconn.php";
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
                    <li><a href="index.php">Home</a></li>
                    <li><a href="mercado.php">Mercado</a></li>
                    <li class="dropdown">
                        <button class="dropbtn"><i class="fa fa-plus-circle"></i>
                          <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-content">
                          <a href="registoTransportes.php">Registar Transporte</a>
                        </div>
                    </li>
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
                                <input type="text" class="form-control" placeholder="Categoria" name="categoria" value="">
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Matrícula</label>
                                <input type="text" class="form-control" placeholder="Matrícula" name="matricula" value="">
                            </div>
                            <!--<div class="col-md-12">

                                <label class="labels">Capacidade</label><br>
                                <label for="10">10</label>
                                <input type="radio" name="produto" value="10">
                                <label for="30">30</label>
                                <input type="radio" name="produto" value="30">
                                <label for="50">50</label>
                                <input type="radio" name="produto" value="50">
                                <label for="70">70</label>
                                <input type="radio" name="produto" value="70">
                                <label for="100">100</label>
                                <input type="radio" name="produto" value="100">
                                <select id="choose2" name="tipoUtili" onchange= "getOption()">
                                <label class="labels">Quantidade de produtos</label>
                                <select id="choose2" name="quantidade" >
                                    <option value="10">10</option>
                                    <option value="20">30</option>
                                    <option value="50">50</option>
                                    <option value="70">70</option>
                                    <option value="100">100</option>
                                    <input type="hidden" class="form-control" name="produto" value="">
                                </select>
                            </div>-->
                            
                    
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
                            <th scope="col" class="text-center">Veículo</th>
                            <th scope="col" class="text-center">Matrícula</th>
                            <th scope="col" class="text-center">Produto</th>
                            <th scope="col" class="text-center">Acção</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $transportadora_query = "SELECT * FROM [dbo].[Transportadora] WHERE email= '$_SESSION[email]'";
                    $transportadora = sqlsrv_query($conn, $transportadora_query);
                    #$row_count1 = sqlsrv_num_rows($fornecedor);
                    #if ($row_count1 > 0) {
                    $row = sqlsrv_fetch_array($transportadora);
                    $nif = $row['nif'];
                    $query = "SELECT * FROM [dbo].[Veiculo] WHERE transportadora= $nif";
                    $results = sqlsrv_query($conn, $query);
                    $row = 0;
                    $_SESSION["itemType"] = "tranporte";
                        while($row = sqlsrv_fetch_array($results)) {
                            echo"<tr>";
                            echo "<form action='deleteItem.php' method='post'>";
                            echo"<td class=text-center>" . $row['categoria'] . "</td>";
                            echo "<td><input type='hidden' name='itemId' value=".$row['matricula'].">".$row['matricula']."</td>";
                            echo"<td class=text-center>" . $row['transportadora'] . "</td>";
                            echo "<td><input type='submit' value='Eliminar transporte' name='delete_transporte' class=btnL></td>";
                            echo "</form>";
                            //echo"<td class=text-center>" . $row['produto'] . "</td>";
                            echo"<tr>";
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

    if (isset($_SESSION['msg']) == "Veículo registado") {

    ?>

        <script>
                
                document.addEventListener("DOMContentLoaded", function(event) {
                    
                    swal({
                    title: "<?php echo $_SESSION['msg']; ?>",
                    icon: "success",
                });
                
                });


            
        </script>

    <?php
        
    }elseif(isset($_SESSION['error']) == "Matricula registada anteriormente"){ ?>

        <script>
                
                document.addEventListener("DOMContentLoaded", function(event) {
                    
                    Swal.fire({
                    title: "<?php echo $_SESSION['error']; ?>",
                    text: "Utilize outra matricula ou registe outro veículo",
                    icon: "warning",
                });
                
                });


            
        </script>
 <?php
    }


    unset($_SESSION['msg']);

    ?>
    </body>