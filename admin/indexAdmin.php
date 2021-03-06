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
    $QueryTotalProdutos = "SELECT * FROM [dbo].[Produto]";
    $total_produtos_execute = sqlsrv_query($conn,$QueryTotalProdutos,array(),array( "Scrollable" => 'static' ));
    $total_produtos = sqlsrv_num_rows($total_produtos_execute);

    $QueryTotalConsumidores = "SELECT * FROM [dbo].[Consumidor]";
    $total_consumidores_execute = sqlsrv_query($conn,$QueryTotalConsumidores,array(),array( "Scrollable" => 'static' ));
    $total_consumidores = sqlsrv_num_rows($total_consumidores_execute);

    $QueryTotalFornecedores = "SELECT * FROM [dbo].[Fornecedor]";
    $total_fornecedores_execute = sqlsrv_query($conn,$QueryTotalFornecedores,array(),array( "Scrollable" => 'static' ));
    $total_fornecedores = sqlsrv_num_rows($total_fornecedores_execute);

    $QueryTotalTransportadora = "SELECT * FROM [dbo].[Transportadora]";
    $total_transportadoras_execute = sqlsrv_query($conn,$QueryTotalTransportadora,array(),array( "Scrollable" => 'static' ));
    $total_transportadoras = sqlsrv_num_rows($total_transportadoras_execute);


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Admin</title>
  </head>
  <body>
    <!-- top navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container-fluid">
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="offcanvas"
          data-bs-target="#sidebar"
          aria-controls="offcanvasExample"
        >
          <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
        </button>
        <a
          class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold"
          href="#"
          >ADMIN</a
        >
        <div id="topNavBar">
          <ul class="navbar-nav">
            <li class="nav-item dropdown float-end">
              <a
                class="nav-link dropdown-toggle ms-2"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <i class="bi bi-person-fill"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">Sair</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- top navigation bar -->
    <!-- offcanvas -->
    <div
    class="offcanvas offcanvas-start sidebar-nav bg-dark"
    tabindex="-1"
    id="sidebar"
  >
    <div class="offcanvas-body p-0">
      <nav class="navbar-dark">
        <ul class="navbar-nav">
          <li>
            <div class="text-muted small fw-bold text-uppercase px-3">
              
            </div>
          </li>
          <li>
            <a href="indexAdmin.php" class="nav-link px-3 active">
              <span class="me-2"><i class="bi bi-speedometer2"></i></span>
              <span>Dashboard</span>
            </a>
          </li>
          <li class="my-4"><hr class="dropdown-divider bg-light" /></li>
          <li>
            <div class="text-muted small fw-bold text-uppercase px-3 mb-3">
              Interface
            </div>
          </li>
          <li>
            <a href="adminTransportadoras.php"
              class="nav-link px-3 sidebar-link"
            >
              <span class="me-2"><i class="bi bi-book-fill"></i></span>
              <span>Transportadoras</span>
            </a>
          </li>
          <li>
            <a href="adminVeiculos.php"
              class="nav-link px-3 sidebar-link"
            >
            <span>Ve??culos</span>
          </li>
          <li>
            <a href="adminFornecedores.php" class="nav-link px-3">
              <span class="me-2"><i class="bi bi-book-fill"></i></span>
              <span>Fornecedores</span>
            </a>
          </li>
          <li>
            <a href="adminProdutos.php"
              class="nav-link px-3 sidebar-link"
            >
            <span>Produtos</span>
            
              <a href="adminArmazens.php"
                class="nav-link px-3 sidebar-link"
              >
              <span>Armaz??ns</span>
            
          </li>
          <li>
          <li>
            <a href="adminConsumidores.php" class="nav-link px-3">
              <span class="me-2"><i class="bi bi-book-fill"></i></span>
              <span>Consumidores</span>

            </a>
          </li>
          <li>
            <a href="adminEncomendas.php"
              class="nav-link px-3 sidebar-link"
            >
            <span>Encomendas</span>
          </li>
        </ul>
      </nav>
    </div>
  </div>
    <!-- offcanvas -->
    <main class="mt-5 pt-3">
      <div class="container-fluid mt-lg-1">
        <div class="row">
          <div class="col-md-3 mb-3">
            <div class="card bg-success text-white h-100">
              <div class="card-body py-5">N??mero Consumidores:</div>
              <p class="text-center"> <?php echo $total_consumidores?></p>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card bg-success text-white h-100">
              <div class="card-body py-5">N??mero de Fornecedores:</div>
              <p class="text-center"> <?php echo $total_fornecedores?></p>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card bg-success text-white h-100">
              <div class="card-body py-5">N??mero de Transportes:</div>
              <p class="text-center"> <?php echo $total_transportadoras?></p>
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <div class="card bg-success text-white h-100">
                <div class="card-body py-5">N??mero de Produtos:</div>
                    <p class="text-center"><?php echo $total_produtos?></p>
              </div>
            </div>
          </div>
        </div>
        
        
    </main>
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="./js/jquery-3.5.1.js"></script>
    <script src="./js/jquery.dataTables.min.js"></script>
    <script src="./js/dataTables.bootstrap5.min.js"></script>
    <script src="./js/script.js"></script>
  </body>
</html>
