<?php
session_start();
//$mailTeste = $_SESSION['email'];
//$ola = isset($_SESSION["tipo"]);
//echo "$ola";
//echo "$mailTeste";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"/>
    <link href="style.css" rel="stylesheet"/>
    <script class="u-script" type="text/javascript" src="jquery-1.9.1.min.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="nicepage.js" defer=""></script>
    <link rel="stylesheet" href="Page-2.css" media="screen">
    <link rel="stylesheet" href="nicepage.css" media="screen">
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
                                echo "<li><a class=dropdown-item href=registoArmazem.php>Armazéns</a></li>";
                                echo "<li><a class=dropdown-item href=registoProduto.php>Produtos</a></li>";
                                echo "<li><a class=dropdown-item href=histEncomendasFornecedor.php>Encomendas</a></li>";
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
                    
                    <li class="nav-item"><a class="nav-link active" href="conta.php">Login</a></li>
                    
                <?php } ?>
            </ul>               
            </div>
    </div>
    </nav>
    </div></header>
    <section class="u-align-center u-clearfix u-custom-color-1 u-section-1 d-flex align-items-center justify-content-center" id="carousel_3acf">
      <div class="u-clearfix u-sheet u-sheet-1">
        <h2 class="u-text u-text-default u-text-1"> Perguntas Frequentes</h2>
        <div class="u-accordion u-collapsed-by-default u-faq u-spacing-10 u-accordion-1">
          <div class="u-accordion-item">
            <a class="u-accordion-link u-active-white u-border-2 u-border-active-grey-75 u-border-grey-40 u-border-hover-grey-75 u-button-style u-hover-white u-radius-7 u-text-active-black u-text-grey-50 u-text-hover-black u-white u-accordion-link-1" id="link-accordion-f600" aria-controls="accordion-f600" aria-selected="false">
              <span class="u-accordion-link-text">Como devo fazer para encomendar um produto?</span><span class="u-accordion-link-icon u-icon u-text-active-black u-text-hover-black u-icon-1"><svg class="u-svg-link" preserveAspectRatio="xMidYMin slice" viewBox="0 0 426.66667 426.66667" style=""><use xlink:href="#svg-b6d8"></use></svg><svg class="u-svg-content" viewBox="0 0 426.66667 426.66667" id="svg-b6d8"><path d="m405.332031 192h-170.664062v-170.667969c0-11.773437-9.558594-21.332031-21.335938-21.332031-11.773437 0-21.332031 9.558594-21.332031 21.332031v170.667969h-170.667969c-11.773437 0-21.332031 9.558594-21.332031 21.332031 0 11.777344 9.558594 21.335938 21.332031 21.335938h170.667969v170.664062c0 11.777344 9.558594 21.335938 21.332031 21.335938 11.777344 0 21.335938-9.558594 21.335938-21.335938v-170.664062h170.664062c11.777344 0 21.335938-9.558594 21.335938-21.335938 0-11.773437-9.558594-21.332031-21.335938-21.332031zm0 0"></path></svg></span>
            </a>
            <div class="u-accordion-pane u-container-style u-expanded-width u-white u-accordion-pane-1" id="accordion-f600" aria-labelledby="link-accordion-f600">
              <div class="u-container-layout u-container-layout-1">
                <div class="fr-view u-clearfix u-rich-text u-text">
                  <p>Para efetuar uma encomenda é necessário primeiro que o utilizador esteja logado na sua conta consumidor, caso não tenha basta criar <a href="criar_conta.php" class="text-muted">conta</a>. De seguida o utilizador deve selecionar os produtos que pretende comprar no <a href="mercado.php" class="text-muted">mercado</a> adicionando-os ao <a href="carrinho.php" class="text-muted">carrinho</a> e finalizando a sua compra.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="u-accordion-item">
            <a class="u-accordion-link u-active-white u-border-2 u-border-active-grey-75 u-border-grey-40 u-border-hover-grey-75 u-button-style u-hover-white u-radius-7 u-text-active-black u-text-grey-50 u-text-hover-black u-white u-accordion-link-2" id="link-accordion-72f4" aria-controls="accordion-72f4" aria-selected="false">
              <span class="u-accordion-link-text">Como devo fazer para comparar dois produtos?</span><span class="u-accordion-link-icon u-icon u-text-active-black u-text-hover-black u-icon-2"><svg class="u-svg-link" preserveAspectRatio="xMidYMin slice" viewBox="0 0 426.66667 426.66667" style=""><use xlink:href="#svg-b250"></use></svg><svg class="u-svg-content" viewBox="0 0 426.66667 426.66667" id="svg-b250"><path d="m405.332031 192h-170.664062v-170.667969c0-11.773437-9.558594-21.332031-21.335938-21.332031-11.773437 0-21.332031 9.558594-21.332031 21.332031v170.667969h-170.667969c-11.773437 0-21.332031 9.558594-21.332031 21.332031 0 11.777344 9.558594 21.335938 21.332031 21.335938h170.667969v170.664062c0 11.777344 9.558594 21.335938 21.332031 21.335938 11.777344 0 21.335938-9.558594 21.335938-21.335938v-170.664062h170.664062c11.777344 0 21.335938-9.558594 21.335938-21.335938 0-11.773437-9.558594-21.332031-21.335938-21.332031zm0 0"></path></svg></span>
            </a>
            <div class="u-accordion-pane u-container-style u-expanded-width u-white u-accordion-pane-2" id="accordion-72f4" aria-labelledby="link-accordion-72f4" wfd-invisible="true">
              <div class="u-container-layout u-container-layout-2">
                <div class="fr-view u-clearfix u-rich-text u-text">
                  <p>Na página <a href="mercado.php" class="text-muted">mercado</a> tem de selecionar o botão comparar produto para os dois produtos que pretende comparar e de seguida visualizar os dados de cada produto na aba Comparar Produtos, por fim é só clicar no botão comparar e visualizar as diferenças de poluição e preço entre ambos. Caso se engane a selecionar um dos produtos basta selecionar o botão reset e escolher de novo ambos os produtos.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="u-accordion-item">
            <a class="u-accordion-link u-active-white u-border-2 u-border-active-grey-75 u-border-grey-40 u-border-hover-grey-75 u-button-style u-hover-white u-radius-7 u-text-active-black u-text-grey-50 u-text-hover-black u-white u-accordion-link-3" id="link-accordion-854e" aria-controls="accordion-854e" aria-selected="false">
              <span class="u-accordion-link-text">Como atualizo o meu perfil/Como apago a minha conta?</span><span class="u-accordion-link-icon u-icon u-text-active-black u-text-hover-black u-icon-3"><svg class="u-svg-link" preserveAspectRatio="xMidYMin slice" viewBox="0 0 426.66667 426.66667" style=""><use xlink:href="#svg-4779"></use></svg><svg class="u-svg-content" viewBox="0 0 426.66667 426.66667" id="svg-4779"><path d="m405.332031 192h-170.664062v-170.667969c0-11.773437-9.558594-21.332031-21.335938-21.332031-11.773437 0-21.332031 9.558594-21.332031 21.332031v170.667969h-170.667969c-11.773437 0-21.332031 9.558594-21.332031 21.332031 0 11.777344 9.558594 21.335938 21.332031 21.335938h170.667969v170.664062c0 11.777344 9.558594 21.335938 21.332031 21.335938 11.777344 0 21.335938-9.558594 21.335938-21.335938v-170.664062h170.664062c11.777344 0 21.335938-9.558594 21.335938-21.335938 0-11.773437-9.558594-21.332031-21.335938-21.332031zm0 0"></path></svg></span>
            </a>
            <div class="u-accordion-pane u-container-style u-expanded-width u-white u-accordion-pane-3" id="accordion-854e" aria-labelledby="link-accordion-854e" wfd-invisible="true">
              <div class="u-container-layout u-container-layout-3">
                <div class="fr-view u-clearfix u-rich-text u-text">
                  <p>Tem de aceder à página perfil através da barra de navegação. Após estar na página de perfil tem de alterar nos detalhes de perfil os novos detalhes que pretende e clicar no botão de save profile para salvar alterações</p>
                  <p>Tem de aceder à página perfil através da barra de navegação. Após estar na página de perfil bastar selecionar o botão de eliminar conta</p>

                </div>
              </div>
            </div>
          </div>
          <div class="u-accordion-item u-expanded-width">
            <a class="u-accordion-link u-active-white u-border-2 u-border-active-grey-75 u-border-grey-40 u-border-hover-grey-75 u-button-style u-hover-white u-radius-7 u-text-active-black u-text-grey-50 u-text-hover-black u-white u-accordion-link-4" id="link-accordion-f600" aria-controls="accordion-f600" aria-selected="false">
              <span class="u-accordion-link-text">Enquanto fornecedor como registo um armazém?/Enquanto fornecedor como registo um produto?</span><span class="u-accordion-link-icon u-icon u-text-active-black u-text-hover-black u-icon-4"><svg class="u-svg-link" preserveAspectRatio="xMidYMin slice" viewBox="0 0 426.66667 426.66667" style=""><use xlink:href="#svg-1e29"></use></svg><svg class="u-svg-content" viewBox="0 0 426.66667 426.66667" id="svg-1e29"><path d="m405.332031 192h-170.664062v-170.667969c0-11.773437-9.558594-21.332031-21.335938-21.332031-11.773437 0-21.332031 9.558594-21.332031 21.332031v170.667969h-170.667969c-11.773437 0-21.332031 9.558594-21.332031 21.332031 0 11.777344 9.558594 21.335938 21.332031 21.335938h170.667969v170.664062c0 11.777344 9.558594 21.335938 21.332031 21.335938 11.777344 0 21.335938-9.558594 21.335938-21.335938v-170.664062h170.664062c11.777344 0 21.335938-9.558594 21.335938-21.335938 0-11.773437-9.558594-21.332031-21.335938-21.332031zm0 0"></path></svg></span>
            </a>
            <div class="u-accordion-pane u-container-style u-expanded-width u-white u-accordion-pane-4" id="accordion-f600" aria-labelledby="link-accordion-f600" wfd-invisible="true">
              <div class="u-container-layout u-container-layout-4">
                <div class="fr-view u-clearfix u-rich-text u-text">
                  <p>Para efetuar o registo de um armazém ou produto é necessário primeiro que o utilizador esteja logado na sua conta fornecedor, caso não tenha basta criar <a href="criar_conta.php" class="text-muted">conta</a><div class=""></div></p>
                  <p>Para registar um armazém tem de aceder à página de armazéns através da barra de navegação. De seguida tem de preencher os 6 campos obrigatórios com informação sobre o armazém e clicar no botão registar armazém. Note que após o registo do armazém será possível visualizar o armazém já registado na tabela de Armazéns Registados.</p>
                  <p>Para registar um produto tem de aceder à página de produtos através da barra de navegação. De seguida tem de preencher os 6 campos obrigatórios com informação sobre o produto(de notar que para ser possível ter uma morada disponível para um produto é necessário ter um armazém registado).</p>
                </div>
              </div>
            </div>
          </div>
          
    </section>

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
</html>