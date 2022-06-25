<?php 
session_start();

include "openconn.php";

$mailForn = $_SESSION['email'];
//arranjar id do fornecedor
$user_check_query = "SELECT * FROM [dbo].[Fornecedor] WHERE email='{$mailForn}'"; //Nome da coluna password provavelmente errados
$result = sqlsrv_query($conn, $user_check_query);
if( $result === false ) {
    die( print_r( sqlsrv_errors(), true));
}
if( sqlsrv_fetch( $result ) === false) {
    die( print_r( sqlsrv_errors(), true));
}
$idF = sqlsrv_get_field( $result, 0);

//arranjar numero de armanzens do fornecedor

$user_check_query2 = "SELECT * FROM [dbo].[Armazem] WHERE fornecedor='$idF'";
//$stmt = sqlsrv_query( $conn, $user_check_query );
$armazens = sqlsrv_query($conn, $user_check_query2);
$query = sqlsrv_query($conn, $user_check_query2, array(), array( "Scrollable" => 'static' ));
$row_count = sqlsrv_num_rows($query);
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
            <div class="col-md-5">
                <div class="p-2 py-5">
                    <form action="registarPro.php" method="post">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Registo de Produto</h4>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="labels">Nome do Produto</label>
                                <input type="text" class="form-control" placeholder="Nome do Produto" name="nome" value="" required>
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Morada</label>
                                
                                <select class="form-control" name="morada">
                                    
                                    <?php
                                    
                                        $temp = sqlsrv_query($conn, $user_check_query2);
                                        if ($row_count > 0) {
                                            while ($rowP = sqlsrv_fetch_array($temp)) {

                                                ?>
                                                
                                                <option value='<?php echo $rowP['morada']; ?>'><?php echo $rowP['morada']; ?></option>

                                                <?php

                                            }
                                        }
                                    ?>

                                </select>

                            </div>
                            
                            <div class="col-md-12">
                                <label class="labels">Tipo</label>

                                <select id="tipo1" class="form-control" name="tipo" onchange="getTipo();">

                                    <option value="">Escolha um</option>

                                    <?php
                                        $aux = 0;
                                        $receber_tipos = "SELECT * FROM [dbo].[Tipo] WHERE tid>'$aux'";
                                        $tipos = sqlsrv_query($conn, $receber_tipos);
                                        
                                        while ($rowP = sqlsrv_fetch_array($tipos)) {

                                            ?>
                                            
                                            <option value='<?php echo $rowP['nome']; ?>'><?php echo $rowP['nome']; ?></option>

                                            <?php

                                        }
                                        
                                    ?>
                                    <!--<option value="">Escolha um</option>
                                    <option value="Alimentação">Alimentação</option>
                                    <option value="Casa">Casa</option>
                                    <option value="Desporto">Desporto</option>
                                    <option value="Tecnologia">Tecnologia</option>
                                    <option value="Vestuário">Vestuário</option>-->
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label class="labels">Sub Tipo</label>

                                <select id="tipo2" class="form-control" name="subtipo" onchange="">
                                    
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label class="labels">Preço</label>
                                <input type="number" class="form-control" placeholder="Preco" name="preco" value="" required>
                            </div>

                            <div class="col-md-12">
                                <label class="labels">Poluição</label>
                                <input type="number" class="form-control" placeholder="Poluicao" name="poluicao" value="" required>
                            </div>
                    
                        </div>
                        <div class="mt-5 text-center">
                            <button class="btn btn-success" name="addPro" type="submit">Registar Produto</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
            
                <h4 class="text-right p-4">Produtos Registados</h1>
                <div style="overflow-x:auto;">
                <table class="table table-bordered table-lg table-light align-top">
                    <thead>
                      <tr>
                        <th scope="col" class="text-center">Armazém</th>
                        <th scope="col" class="text-center">Produto</th>
                        <th scope="col" class="text-center">Tipo</th>
                        <th scope="col" class="text-center">Poluição</th>
                        <th scope="col" class="text-center">Preço</th>
                        <th scope="col" class="text-center">Ação</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $_SESSION["itemType"] = "produto";
                        if ($row_count > 0) {
                            while ($row = sqlsrv_fetch_array($armazens)) {

                                //arranjar produtos que estao nesta morada
                                $moradaTemp = $row['morada'];

                                $produtos_query = "SELECT * FROM [dbo].[Produto] WHERE morada='$moradaTemp'";
                                //$stmt = sqlsrv_query( $conn, $user_check_query );
                                $produtos = sqlsrv_query($conn, $produtos_query);

                                $query2 = sqlsrv_query($conn, $produtos_query, array(), array( "Scrollable" => 'static' ));
                                $row_count2 = sqlsrv_num_rows($query2);

                                if($row_count2 > 0){

                                    while ($row2 = sqlsrv_fetch_array($produtos)) {

                                        $queryyy = "SELECT * FROM [dbo].[Subtipo] WHERE sid='{$row2['subtipo']}' ";
                                        $resulttt = sqlsrv_query($conn, $queryyy);
                                        if( $resulttt === false ) {
                                            die( print_r( sqlsrv_errors(), true));
                                        }
                                        if( sqlsrv_fetch( $resulttt ) === false) {
                                            die( print_r( sqlsrv_errors(), true));
                                        }
                                        $SubtipoDoProduto = sqlsrv_get_field( $resulttt, 1);

                                        echo "<tr>";
                                        //echo "<form action='deleteItem.php' method='post'>";
                                        echo "<td>" . $row['nome'] . "</td>";
                                        echo "<td><input type='hidden' name='itemId' value=".$row2['pid'].">".$row2['nome']."</td>";
                                        echo "<td>" . $SubtipoDoProduto . "</td>";
                                        //echo "<td>" . $row2['subtipo'] . "</td>";
                                        echo "<td>" . $row2['poluicao'] . "</td>";
                                        echo "<td>" . $row2['preco'] . "</td>";
                                        //echo "<td><input type='submit' value='Eliminar produto' name='delete_produto' class=btnL></td>";
                                        ?>
                                        <td> <a href='deleteProduto.php?id=<?php echo $row2['pid']; ?>' >Delete</a> </td>
                                        <?php
                                        echo "</tr>";
                                        //echo "</form>";
                                }

                            }
                        }
                    }
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

    <script>

        var tipo = "";
        let lista = ["Escolhe um tipo primeiro"];

        function getTipo(){

            tipo = document.getElementById("tipo1").value;
            console.log(tipo);

            console.log(tipo);
            if(tipo == "Alimentacao"){

                lista = []
                
                <?php
                    $aux = 1;
                    $receber_subtipos = "SELECT * FROM [dbo].[Subtipo] WHERE tipo='$aux'";
                    $subtipos = sqlsrv_query($conn, $receber_subtipos);
                    
                    while ($rowP = sqlsrv_fetch_array($subtipos)) {

                        ?>
                        
                        //<option value='<?php //echo $rowP['nome']; ?>'><?php //echo $rowP['nome']; ?></option>
                        lista.push("<?php echo $rowP['nome']; ?>");
                        <?php

                    }
                    
                ?>
                //lista = ["talheres", "fruta", "outros"];
                //console.log("tou ca");
            }else if (tipo == "Desporto"){

                lista = []

                <?php
                    $aux = 3;
                    $receber_subtipos = "SELECT * FROM [dbo].[Subtipo] WHERE tipo='$aux'";
                    $subtipos = sqlsrv_query($conn, $receber_subtipos);
                    
                    while ($rowP = sqlsrv_fetch_array($subtipos)) {

                        ?>
                        
                        //<option value='<?php //echo $rowP['nome']; ?>'><?php //echo $rowP['nome']; ?></option>
                        lista.push("<?php echo $rowP['nome']; ?>");
                        <?php

                    }
                    
                ?>

                //lista = ["calçado", "equipamento", "acessórios"];

            }else if (tipo == "Tecnologia"){

                lista = []

                <?php
                    $aux = 4;
                    $receber_subtipos = "SELECT * FROM [dbo].[Subtipo] WHERE tipo='$aux'";
                    $subtipos = sqlsrv_query($conn, $receber_subtipos);
                    
                    while ($rowP = sqlsrv_fetch_array($subtipos)) {

                        ?>
                        
                        //<option value='<?php //echo $rowP['nome']; ?>'><?php //echo $rowP['nome']; ?></option>
                        lista.push("<?php echo $rowP['nome']; ?>");
                        <?php

                    }
                    
                ?>

                //lista = ["PCs", "Playstation", "Nitendo"];

            }else if (tipo == "Casa"){

                lista = []

                <?php
                    $aux = 2;
                    $receber_subtipos = "SELECT * FROM [dbo].[Subtipo] WHERE tipo='$aux'";
                    $subtipos = sqlsrv_query($conn, $receber_subtipos);
                    
                    while ($rowP = sqlsrv_fetch_array($subtipos)) {

                        ?>
                        
                        //<option value='<?php //echo $rowP['nome']; ?>'><?php //echo $rowP['nome']; ?></option>
                        lista.push("<?php echo $rowP['nome']; ?>");
                        <?php

                    }
                    
                ?>

                //lista = ["Armarios", "Cadeiras", "Sofas"];
                
            }else if (tipo == "Vestuario"){

                lista = []

                <?php
                    $aux = 5;
                    $receber_subtipos = "SELECT * FROM [dbo].[Subtipo] WHERE tipo='$aux'";
                    $subtipos = sqlsrv_query($conn, $receber_subtipos);
                    
                    while ($rowP = sqlsrv_fetch_array($subtipos)) {

                        ?>
                        
                        //<option value='<?php //echo $rowP['nome']; ?>'><?php //echo $rowP['nome']; ?></option>
                        lista.push("<?php echo $rowP['nome']; ?>");
                        <?php

                    }
                    
                ?>

                //lista = ["Homem", "Mulher", "Criança", "chapeus"];
            }

            var myDiv = document.getElementById("tipo2");
            myDiv.innerHTML = "";

            lista.forEach(function(item){
            let o=document.createElement("option");
            o.text = item;
            o.value = item;
            tipo2.appendChild(o);
            });

        }

        

        lista.forEach(function(item){
            let o=document.createElement("option");
            o.text = item;
            o.value = item;
            tipo2.appendChild(o);
        });

    </script>



<?php
    //echo "<p>teste</p>";
    if (isset($_SESSION['statusCode']) != "") {

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