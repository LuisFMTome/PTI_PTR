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
                          <a href="registoProduto.php">Registar Produtos</a>
                          <a href="registoArmazem.php">Registar Armazém</a>
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
                                    <option value="Alimentação">Alimentação</option>
                                    <option value="Casa">Casa</option>
                                    <option value="Desporto">Desporto</option>
                                    <option value="Tecnologia">Tecnologia</option>
                                    <option value="Vestuário">Vestuário</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label class="labels">Sub Tipo</label>

                                <select id="tipo2" class="form-control" name="tipo" onchange="getTipo();">
                                    
                                </select>
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
                                        echo "<tr>";
                                        echo "<form action='deleteItem.php' method='post'>";
                                        echo "<td>" . $row['nome'] . "</td>";
                                        echo "<td><input type='hidden' name='itemId' value=".$row2['pid'].">".$row2['nome']."</td>";
                                        echo "<td><input type='submit' value='Eliminar produto' name='delete_produto' class=btnL></td>";
                                        echo "</tr>";
                                        echo "</form>";
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

    <script>

        var tipo = "";
        let lista = ["Escolhe um tipo primeiro"];

        function getTipo(){

            tipo = document.getElementById("tipo1").value;
            console.log(tipo);

            console.log(tipo);
            if(tipo == "Alimentação"){

                lista = ["talheres", "fruta", "outros"];
                console.log("tou ca");
            }else if (tipo == "Desporto"){

                lista = ["calçado", "equipamento", "acessórios"];

            }else if (tipo == "Tecnologia"){

                lista = ["PCs", "Playstation", "Nitendo"];

            }else if (tipo == "Casa"){

                lista = ["Armários", "Cadeiras", "Sofas"];
                
            }else if (tipo == "Vestuário"){

                lista = ["Homem", "Mulher", "Criança"];
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

if (isset($_SESSION['msg']) != "") {

?>

    <script>
            
            document.addEventListener("DOMContentLoaded", function(event) {
                
                Swal.fire({
                title: "<?php echo $_SESSION['msg']; ?>",
                icon: "success",
            });
            
            });


        
    </script>

<?php
    
} 


unset($_SESSION['msg']);

?>
    </body>