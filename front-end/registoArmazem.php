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
    <title>Registo Armazém</title>
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
                    <!--<li><a href="index.php">Home</a></li>-->
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

                <form id="RegisterArm" action="registarArm.php" method="post">
                    <div class="p-2 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Registo de Armazém</h4>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="labels">Nome do Armazém</label>
                                <input type="text" class="form-control" placeholder="Nome do Armazém" name="nome" value="" Required>
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Morada</label>
                                <input type="text" class="form-control" placeholder="Morada" name='morada' value="" Required>
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Código Postal</label>
                                <!--<input type="text" class="form-control" placeholder="Código Postal" name="cPostal" value="" Required>
                -->                <input class="form-control" placeholder="Código Postal" type="text" required name="cPostal" pattern="[0-9]{7}" title="7 numeros do codigo postal" />
                    
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Tipo</label>
                                <input type="text" class="form-control" placeholder="Tipo" name="tipo" value="" Required>
                            </div>

                            <div class="col-md-12">
                                <label class="labels">Recursos necessários</label>
                                <input type="text" class="form-control" placeholder="Recursos" name="recursos" value="" Required>
                            </div>

                            <div class="col-md-12">
                                <label class="labels">Poluicao gerada por hora</label>
                                <input type="number" class="form-control" placeholder="Poluicao" name="poluicao" value="" Required>
                            </div>
                    
                        </div>
                        <div class="mt-5 text-center">
                            <button class="btn btn-success" name="addArm" type="submit">Registar Armazém</button>
                        </div>
                    </div>
                </form>

            </div>
            <div class="col-md-6">
            
                <h4 class="text-right p-4">Armazéns Registados</h1>
                <div style="overflow-x:auto;">
                <table class="table table-bordered table-lg table-light align-top">
                    <thead>
                      <tr>
                        <!--<th scope="col" class="text-center">#</th>-->
                        <th scope="col" class="text-center">Nome</th>
                        <th scope="col" class="text-center">Morada</th>
                        <th scope="col" class="text-center">Código Postal</th>
                        <th scope="col" class="text-center">Tipo</th>
                        <th scope="col" class="text-center">Recursos</th>
                        <th scope="col" class="text-center">Poluicao por hora</th>
                        <th scope="col" class="text-center">Ação</th>
                      </tr>
                    </thead>
                    <tbody>

                    <?php 
                    $fornecedor_query = "SELECT * FROM [dbo].[Fornecedor] WHERE email= '$_SESSION[email]'";
                    $fornecedor = sqlsrv_query($conn, $fornecedor_query);
                    $row_count1 = sqlsrv_num_rows($fornecedor);
                    #if ($row_count1 > 0) {
                        $row = sqlsrv_fetch_array($fornecedor);
                        $fid = $row['fid'];
                    #    }
                    #echo $fid;
                    $armazem_query = "SELECT * FROM [dbo].[Armazem] WHERE fornecedor= $fid";
                    $armazens = sqlsrv_query($conn, $armazem_query);
                    $row_count = sqlsrv_num_rows($armazens);
                    $_SESSION["itemType"] = "armazem";
                    #if ($row_count > 0) {
                        while ($row = sqlsrv_fetch_array($armazens)) {
                            echo "<tr>";
                            echo "<form action='deleteItem.php' method='post'>";
                            //echo "<td><input type='hidden' name='itemId' value=".$row['aid'].">".$row['aid']."</td>";
                            echo "<td>" . $row['nome'] . "</td>";
                            echo "<td>" . $row['morada'] . "</td>";
                            echo "<td>" . $row['codigoPostal'] . "</td>";
                            echo "<td>" . $row['tipo'] . "</td>";
                            echo "<td>" . $row['recursos'] . "</td>";
                            echo "<td>" . $row['poluicao'] . "</td>";
                            #echo "<td><input type='submit' value='Eliminar armazem' name='delete_armazem' class=btnL></td>";
                            
                            ?>
                            <td> <a href='deleteArmazem.php?id=<?php echo $row['aid']; ?>' >Delete</a> </td>
                            <?php
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
        if (isset($_SESSION['status']) != "") {

            //echo "<p>teste2</p>";
        ?>

            <script>
                    
                    document.addEventListener("DOMContentLoaded", function(event) {
                        
                        Swal.fire({
                        title: "Apagar Armazem",
                        text: "<?php echo $_SESSION['status']; ?>",
                        icon: "warning", //warning
                    });
                    
                    });
                    
                    

            </script>

        <?php
            unset($_SESSION['status']);}
        ?>

    

    </section>
    </body>