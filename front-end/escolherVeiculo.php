<?php 
session_start();
//include('login.php');
//include('registar.php');
include "openconn.php";

//echo $nEncomenda. "<br>";
if(isset($_POST["addVeiculo"])){

    $recebi = $_GET["id"];
    $pieces = explode("/", $recebi);
    $matricula = $pieces[0];
    $nEncomenda = $pieces[1];
    echo $matricula;
    $addV = "UPDATE [dbo].[Encomenda] SET veiculo = '$matricula' WHERE pedido = '{$nEncomenda}'";

    $res = sqlsrv_query($conn, $addV);
    if($res){
        echo "encomenda cancelada com sucesso";
        //header( "refresh:5; url=histEncomendas.php" );
        
    } else {
        echo "Erro: nao foi possivel cancelada a encomenda" . $query . "<br>" . mysqli_error($conn);
        //header( "refresh:5; url=histEncomendas.php" );
        
    }


    $receberId = "SELECT * FROM [dbo].[Encomenda] where pedido='$nEncomenda'";
    $EncomendaEmQuestao = sqlsrv_query($conn, $receberId, array(), array( "Scrollable" => 'static' ));

    if( $EncomendaEmQuestao === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_fetch( $EncomendaEmQuestao ) === false) {
        die( print_r( sqlsrv_errors(), true));
    }
    $idPro = sqlsrv_get_field($EncomendaEmQuestao, 4);

    //dar Update
    $addP = "UPDATE [dbo].[Veiculo] SET produto = '$idPro' WHERE matricula = '{$matricula}'";

    $rest = sqlsrv_query($conn, $addP);
    if($rest){
        echo "encomenda cancelada com sucesso";
        //header( "refresh:5; url=histEncomendas.php" );
        header("Location: histEncomendasFornecedor.php");
    } else {
        echo "Erro: nao foi possivel cancelada a encomenda" . $query . "<br>" . mysqli_error($conn);
        //header( "refresh:5; url=histEncomendas.php" );
        header("Location: histEncomendasFornecedor.php");
    }

}else{

    $nEncomenda = htmlspecialchars($_POST["idEncomenda"]);
    echo $nEncomenda;
}
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
        </ul>
        </div>
        <div class="d-flex collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="font-weight: bold;">
                <li class="nav-item">
                    <a class="nav-link active" href="histEncomendasFornecedor.php">Voltar</a>
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
            
                <h3 class="text-right p-4">Veiculos Disponiveis</h3>
                <div style="overflow-x:auto;">
                <table class="table table-bordered table-lg table-light align-top">
                    <thead>
                      <tr>
                        <th scope="col" class="text-center">Categoria</th>
                        <th scope="col" class="text-center">Transportadora</th>
                        <th scope="col" class="text-center">Matricula</th>
                        <th scope="col" class="text-center">Escolher</th>

                      </tr>
                    </thead>
                    <tbody>

                        <?php
                            
                            $veiculos_query = "SELECT * FROM [dbo].[Veiculo] where produto is null";
                            //$veiculos = sqlsrv_query($conn, $veiculos_query);
                            $veiculos = sqlsrv_query($conn, $veiculos_query, array(), array( "Scrollable" => 'static' ));
                            $row_count1 = sqlsrv_num_rows($veiculos);
                            //echo $row_count1;

                            if( $veiculos === false ) {
                                die( print_r( sqlsrv_errors(), true));
                            }

                            while ($row = sqlsrv_fetch_array($veiculos)) {

                                $aux = $row['transportadora'];

                                $transportadora_query = "SELECT * FROM [dbo].[Transportadora] WHERE nif ='$aux' ";
                                $transportadoraRes = sqlsrv_query($conn, $transportadora_query);
                                
                                if( $transportadoraRes === false ) {
                                    die( print_r( sqlsrv_errors(), true));
                                }
                                if( sqlsrv_fetch( $transportadoraRes ) === false) {
                                    die( print_r( sqlsrv_errors(), true));
                                }
                                $transportadora = sqlsrv_get_field( $transportadoraRes, 1);

                                echo "<tr>";
                                ?>
                                <form action='escolherVeiculo.php?id=<?php echo $row['matricula']; ?>/<?php echo $nEncomenda ?>' method='post'>
                                <?php
                                //echo "<form action='cancelEncomenda.php?id= method='post'>";
                                echo "<td class=text-left>" . $row['categoria'] . "</td>";
                                echo "<td class=text-left>" . $transportadora . "</td>";
                                echo "<td class=text-left>" . $row['matricula'] . "</td>";
                                
                                ?>
                                <td><button type="submit" name="addVeiculo" class=btn-sm>Add</button></td>
                                <?php
                                //echo "<td class=text-left><input type='submit' value='Cancelar' name='delete_encomenda' class=btn-sm></td>";
                                echo"</form>";
                                echo "</tr>";

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
</body>