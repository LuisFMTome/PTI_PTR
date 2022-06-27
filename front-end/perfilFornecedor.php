<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Fornecedor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"/>
    <link href="style.css" rel="stylesheet"/>
</head>
<body>
    <?php 
        session_start();
        include "openconn.php";
        //$notification = 0;

        $emailTemp = $_SESSION["email"];
        $fornecedor_notif_query = "SELECT * FROM [dbo].[Fornecedor] WHERE email='{$emailTemp}'";
        $id_notif = sqlsrv_query($conn, $fornecedor_notif_query);
        if( $id_notif === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_fetch( $id_notif ) === false) {
            die( print_r( sqlsrv_errors(), true));
        }
        $fornecedorNotif = sqlsrv_get_field( $id_notif, 0);
        //echo $fornecedorNotif;
        $false = "False";
        $noti_query = "SELECT * FROM [dbo].[Notificacao] WHERE utilizador='$fornecedorNotif' AND lida= '$false'";
        $notificacoes = sqlsrv_query($conn, $noti_query, array(), array( "Scrollable" => 'static' ));
        $notification = sqlsrv_num_rows($notificacoes);

        if(isset($_GET["action"])){

            $idNotification = $_GET["id"];
            $true = "True";
            $update_v = "UPDATE [Notificacao] SET lida = '$true' WHERE nid = '{$idNotification}'";

            $res1 = sqlsrv_query($conn, $update_v);
            header("Location: perfilFornecedor.php");

        }
        //echo $notification;
    ?>
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
                                echo "<li><a class=dropdown-item href=registoArmazem.php>Armazéns</a></li>";
                                echo "<li><a class=dropdown-item href=registoProduto.php>Produtos</a></li>";
                                echo "<li><a class=dropdown-item href=histEncomendasFornecedor.php>Encomendas</a></li>";
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
                <li class="nav-item dropdown dropstart">
                    <a class="nav-link active dropdown-toggle" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell fa-lg" aria-hidden="true"></i>
                        <?php
                        if($notification != 0){
                        ?>
                        <span class="badge rounded-pill badge-notification bg-danger"><?php echo $notification; ?></span>
                        <?php
                        }
                        ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="background-color: green;">
                        <?php
                        $emailTemp = $_SESSION["email"];
                        $fornecedor_notif_query = "SELECT * FROM [dbo].[Fornecedor] WHERE email='{$emailTemp}'";
                        $id_notif = sqlsrv_query($conn, $fornecedor_notif_query);
                        if( $id_notif === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                        if( sqlsrv_fetch( $id_notif ) === false) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                        $fornecedorNotif = sqlsrv_get_field( $id_notif, 0);
                        //echo $fornecedorNotif;
                        $false = "False";
                        $noti_query = "SELECT * FROM [dbo].[Notificacao] WHERE utilizador='$fornecedorNotif' AND lida= '$false'";
                        $notificacoes = sqlsrv_query($conn, $noti_query);
                        while ($row = sqlsrv_fetch_array($notificacoes)) {

                            ?>
                            <li><a class=dropdown-item href="perfilFornecedor.php?action=delete&id=<?php echo $row["nid"]; ?>"><?php echo $row['mensagem'] ?></a></li>
                            <?php
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
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img class="rounded-circle mt-5" width="200px" src="img/empty.jpeg">
                    <span class="font-weight-bold">Nome do Fornecedor</span>
                    <span class="text-black-50">
                        <button type="button" class="btn btn-success">Selecione uma foto</button>
                    </span>
                </div>
            </div>
            <div class="col-md-10">
                <div class="p-2 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Informações atuais de Perfil</h4><br></br>
                    </div>
                    <div class="row mt-3">
                        <?php $fornecedor_check_query = "SELECT * FROM [dbo].[Fornecedor] WHERE email='{$_SESSION["email"]}'";

                        $result = sqlsrv_query($conn, $fornecedor_check_query);

                        if (sqlsrv_has_rows($result) != -1) {
                            echo ("nenhum dado encontrado");
                        } else {
                            echo"<div class=table-responsive>";
                            echo"<table class=table>";
                            echo"<thead class=table-dark>";
                            echo "<tr>";
                                echo"<th>id</th>";
                                echo"<th>nome</th>";
                                echo"<th>email</th>";
                                echo"<th>morada</th>";
                                echo"<th>codigo Postal</th>";
                                echo"<th>PayPal ID</th>";
                            echo "</tr>";
                            echo"</thead>";
                            while($row = sqlsrv_fetch_array($result)) {
                                echo "<tr>";
                                    echo "<td class='text-center'>".$row['fid']."</td>";
                                    echo "<td class='text-center'>".$row['nome']."</td>";
                                    echo "<td class='text-center'>".$row['email']."</td>";
                                    echo "<td class='text-center'>".$row['morada']."</td>";
                                    echo "<td class='text-center'>".$row['codigoPostal']."</td>";
                                    echo "<td class='text-center'>".$row['paypalid']."</td>";
                                    $nome = $row['nome'];
                                    $email = $row['email'];
                                    $morada = $row['morada'];
                                    $codigoPostal = $row['codigoPostal'];
                                    $paypalid = $row['paypalid'];
                                echo "</tr>";
                            }
                            echo"</table>";
                            echo"</div>";
                        }
                        echo "<br>";
                        echo "<br>";
                        ?>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Detalhes de Perfil</h4>
                    </div>
                    <form action="edit_fornecedor.php" method="post">
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="labels">Nome</label>
                                <input type="text" class="form-control" placeholder="Nome" name="nome_fornecedor" value="<?php echo $nome?>">
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Email</label>
                                <input type="text" class="form-control" placeholder="Email" name="email_fornecedor" value="<?php echo $email?>">
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Morada</label>
                                <input type="text" class="form-control" placeholder="Morada" name="morada_fornecedor" value="<?php echo $morada?>">
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Código Postal</label>
                                <!--<input type="text" class="form-control" placeholder="Código Postal" name="codigoPostal_fornecedor" value="">-->
                                <input class="form-control" placeholder="Código Postal" type="text" value="<?php echo $codigoPostal?>" required name="codigoPostal_fornecedor" pattern="[0-9]{7}" title="7 numeros do codigo postal" />
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Paypal ID</label>
                                <input type="text" class="form-control" placeholder="Morada" name="paypalid_fornecedor" value="<?php echo $paypalid?>">
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <button class="btn btn-success" type="button"><input type="submit" value="Save Profile" name="edit_fornecedor.php"></button>
                        </div>
                    </form>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Eliminar Conta</h4>
                    </div>
                    <div class="row mt-3">
                        <form action="delete_conta.php" method="post">
                            <div class="col-md-12">
                                <label class="labels">Password</label>
                                <input type="password" class="form-control" placeholder="Password" name = "password" value="">
                            </div>
                            <div class="mt-5 text-center">
                                <button class="btn btn-success" type="button"><input type="submit" value="Eliminar conta" name="delete_conta"></button>
                            </div>
                        </form>
                    </div>
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
</body>
