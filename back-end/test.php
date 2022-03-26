<?php
// PHP Data Objects(PDO) Sample Code:
try {
    $conn = new PDO("sqlsrv:server = tcp:sqldbserver05.database.windows.net,1433; Database = sqldbserver1", "ptrptisqldb", "{2SdULWb5ePk83jA}");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    print("Error connecting to SQL Server.");
    die(print_r($e));
}

// SQL Server Extension Sample Code:
$connectionInfo = array("UID" => "ptrptisqldb", "pwd" => "{2SdULWb5ePk83jA}", "Database" => "sqldbserver1", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:sqldbserver05.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);
?>