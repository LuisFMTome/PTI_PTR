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
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="style.css" rel="stylesheet" />
    <script src="sweetalert2.all.min.js"></script>
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
        
        <div class="row">
          <div class="col-md-12 mb-3">
            <div class="card">
              <div class="card-header">
                <span><i class="bi bi-table me-2"></i></span> Tabela de Consumidores
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
                        <th>Cid</th>
                        <th>Nome Consumidor</th>
                        <th>Email</th>
                        <th>Pwd</th>
                        <th>Morada</th>
                        <th>Codigo Postal</th>
                        <th>Editar</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        $transportadoras = "SELECT cid, nome, email, pwd, morada, codigoPostal FROM [dbo].[Consumidor]";
                        $queryTransportadoras = sqlsrv_query($conn, $transportadoras, array(), array( "Scrollable" => 'static' ));
                        while($row = sqlsrv_fetch_array( $queryTransportadoras, SQLSRV_FETCH_ASSOC)){
                          ?>
                          
                          <tr>
                          <form id="update_consumidor" method="post" action="updateConsumidor.php?id=<?php echo $row['cid']; ?>">
                            <td><?php echo $row['cid']; ?></td>
                            <td><input type="text" class="form-control" placeholder="nome" name="nome" value="<?php echo $row['nome']?>" required></td>
                            <td><input type="email" class="form-control" placeholder="email" name="email" value="<?php echo $row['email'];?>" required></td>
                            <td><input type="text" class="form-control" placeholder="pass" name="pass" value="<?php echo $row['pwd'];?>" required></td>
                            <td><input type="text" class="form-control" placeholder="morada" name="morada" value="<?php echo $row['morada'];?>" required></td>
                            <td><input type="text" class="form-control" placeholder="cPostal" name="cPostal" value="<?php echo $row['codigoPostal'];?>" required pattern="[0-9]{7}" title="7 numeros do codigo postal"></td>
                            <td><input type="submit" value="Update" name="butao" class="btnL"></td>
                            </form>
                          </tr>
                          
                          <!--
                          <tr>
                              <td><?php //echo $row['cid']; ?></td>
                              <td><?php //echo $row['nome']; ?></td>
                              <td><?php //echo $row['email']; ?></td>
                              <td><?php //echo $row['pwd']; ?></td>
                              <td><?php //echo $row['morada']; ?></td>
                              <td><?php //echo $row['codigoPostal']; ?></td>
                              <td></td>
                          </tr>-->
                          <?php } ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>Cid</th>
                        <th>Nome Consumidor</th>
                        <th>Email</th>
                        <th>Pwd</th>
                        <th>Morada</th>
                        <th>Codigo Postal</th>
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

    <?php

    //echo "<p>teste</p>";
    if (isset($_SESSION['statusCode']) != "") {

        echo $_SESSION['statusCode'];
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
</html>