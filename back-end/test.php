<?php
// PHP Data Objects(PDO) Sample Code:
try {
    $conn = new PDO("sqlsrv:server = tcp:ptiptrdbserver.database.windows.net,1433; Database = ptiptr05db", "ptrptisqldb", "{your_password_here}");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    print("Error connecting to SQL Server.");
    die(print_r($e));
}

// SQL Server Extension Sample Code:
$connectionInfo = array("UID" => "ptrptisqldb", "pwd" => "{your_password_here}", "Database" => "ptiptr05db", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:ptiptrdbserver.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);
?>