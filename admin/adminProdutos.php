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
              <a href="indexAdmin.html" class="nav-link px-3 active">
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
              <span>Veículos</span>
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
                <span>Armazéns</span>
              
            </li>
            <li>
            <li>
              <a href="adminConsumidores.php" class="nav-link px-3">
                <span class="me-2"><i class="bi bi-book-fill"></i></span>
                <span>Consumidores</span>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
    <!-- offcanvas -->
    <main class="mt-5 pt-3">
      <div class="container-fluid mt-lg-1">
        <div class="row">
        <div class="mb-4">
            <select class="form-select" aria-label="Default select example" name="fornecedores" method="post">
            <option selected>Selecionar Fornecedor:</option>
            <?php
                $counter = 0;
                $fornecedores = "SELECT * FROM [dbo].[Fornecedor]";
                $queryFornecedores = sqlsrv_query($conn, $fornecedores, array(), array( "Scrollable" => 'static' ));
               
                while($row = sqlsrv_fetch_array( $queryFornecedores, SQLSRV_FETCH_ASSOC)){
                        ?>
                    
                    <option value="<?php ++$counter; echo $counter;?>"><?php echo $row['fid']; ?></option>
                    <?php } ?>
            </select>
        </div>
          <div class="col-md-12 mb-3">
            <div class="card">
              <div class="card-header">
                <span><i class="bi bi-table me-2"></i></span> Tabela de Produtos
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table
                    id="example"
                    class="table table-striped data-table"
                    style="width: 100%"
                  >
                    <thead>
                      <tr>
                        <th>Pid</th>
                        <th>Nome</th>
                        <th>Morada</th>
                        <th>Código Postal</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        if(!empty($_POST['fornecedores'])) {
                            $selected = $_POST['fornecedores'];
                            
                        }else{
                            $selected = "";
                            
                        }
                        $produtos = "SELECT pid, nome, morada, codigoPostal FROM [dbo].[Produto]";
                        $queryProdutos = sqlsrv_query($conn, $produtos, array(), array( "Scrollable" => 'static' ));
                        while($row = sqlsrv_fetch_array( $queryProdutos, SQLSRV_FETCH_ASSOC)){
                          ?>

                          <tr>
                              <td><?php echo $row['pid']; ?></td>
                              <td><?php echo $row['nome']; ?></td>
                              <td><?php echo $row['morada']; ?></td>
                              <td><?php echo $row['codigoPostal']; ?></td>
                          </tr>
                          <?php } ?>

                    </tbody>
                    <tfoot>
                      <tr>
                        <th>Pid</th>
                        <th>Nome Produto</th>
                        <th>Morada</th>
                        <th>Código Postal</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
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