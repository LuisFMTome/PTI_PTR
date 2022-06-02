<?php
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

$consumidor_check_query = "SELECT * FROM [dbo].[Consumidor]";

$result = sqlsrv_query($conn, $consumidor_check_query);
//$row = sqlsrv_fetch_array($result);

echo "Consumidores: <br>";

if (sqlsrv_has_rows($result) != -1) {
    echo ("não há Consumidores");
} else {
    echo"<table>";
        echo "<tr>";
        echo"<th>id</th>";
        echo"<th>nome</th>";
        echo"<th>email</th>";
        echo"<th>password</th>";
        echo"<th>morada</th>";
        echo"<th>codigoPostal</th>";
        echo "</tr>";
    while($row = sqlsrv_fetch_array($result)) {
        echo "<tr>";
        echo "<td class='text-center'>".$row['cid']."</td>";
        echo "<td class='text-center'>".$row['nome']."</td>";
        echo "<td class='text-center'>".$row['email']."</td>";
        echo "<td class='text-center'>".$row['pwd']."</td>";
        echo "<td class='text-center'>".$row['morada']."</td>";
        echo "<td class='text-center'>".$row['codigoPostal']."</td>";
        echo "</tr>";
    }
    echo"</table>";
}
echo"<br>";

$Transportadora_check_query = "SELECT * FROM [dbo].[Transportadora]"; //Nome da coluna password provavelmente errados

$result1 = sqlsrv_query($conn, $Transportadora_check_query); //, array(), array("Scrollable" => 'static')

echo "Transportadoras: <br>";

if (sqlsrv_has_rows($result1) != -1) {
    echo ("nao há Transportadoras");
} else {
    echo"<table>";
        echo "<tr>";
        echo"<th>nif</th>";
        echo"<th>nome</th>";
        echo"<th>email</th>";
        echo"<th>password</th>";
        echo"<th>morada</th>";
        echo"<th>codigoPostal</th>";
        echo "</tr>";
    while($row = sqlsrv_fetch_array($result1)) {
        echo "<tr>";
        echo "<td class='text-center'>".$row['nif']."</td>";
        echo "<td class='text-center'>".$row['nome']."</td>";
        echo "<td class='text-center'>".$row['email']."</td>";
        echo "<td class='text-center'>".$row['pwd']."</td>";
        echo "<td class='text-center'>".$row['morada']."</td>";
        echo "<td class='text-center'>".$row['codigoPostal']."</td>";
        echo "</tr>";
    }
    echo"</table>";
}
echo"<br>";

$Fornecedor_check_query = "SELECT * FROM [dbo].[Fornecedor]"; //Nome da coluna password provavelmente errados

$result2 = sqlsrv_query($conn, $Fornecedor_check_query); //, array(), array("Scrollable" => 'static')

echo "Fornecedores: <br>";

if (sqlsrv_has_rows($result2) != -1) {
    echo ("nao Fornecedores");
} else {
    echo"<table>";
        echo "<tr>";
        echo"<th>fid</th>";
        echo"<th>nome</th>";
        echo"<th>email</th>";
        echo"<th>password</th>";
        echo"<th>morada</th>";
        echo"<th>codigoPostal</th>";
        echo "</tr>";
    while($row = sqlsrv_fetch_array($result2)) {
        echo "<tr>";
        echo "<td class='text-center'>".$row['fid']."</td>";
        echo "<td class='text-center'>".$row['nome']."</td>";
        echo "<td class='text-center'>".$row['email']."</td>";
        echo "<td class='text-center'>".$row['pwd']."</td>";
        echo "<td class='text-center'>".$row['morada']."</td>";
        echo "<td class='text-center'>".$row['codigoPostal']."</td>";
        echo "</tr>";
    }
    echo"</table>";
}
echo"<br>";

$armazem_query = "SELECT * FROM [dbo].[Armazem]";
$result3 = sqlsrv_query($conn, $armazem_query);

echo "Armazens: <br>";

if (sqlsrv_has_rows($result3) != -1) {
    echo ("nao há Armazens");
} else {
    echo"<table>";
        echo "<tr>";
        echo"<th>aid</th>";
        echo"<th>fornecedor</th>";
        echo"<th>nome</th>";
        echo"<th>morada</th>";
        echo"<th>codigoPostal</th>";
        echo"<th>tipo</th>";
        echo "</tr>";
    while($row = sqlsrv_fetch_array($result3)) {
        echo "<tr>";
        echo "<td>" . $row['aid'] . "</td>";
        echo "<td>" . $row['fornecedor'] . "</td>";
        echo "<td>" . $row['nome'] . "</td>";
        echo "<td>" . $row['morada'] . "</td>";
        echo "<td>" . $row['codigoPostal'] . "</td>";
        echo "<td>" . $row['tipo'] . "</td>";
        echo "</tr>";
    }
    echo"</table>";
}
echo"<br>";

$produto_query = "SELECT * FROM [dbo].[Produto]";
$result4 = sqlsrv_query($conn, $produto_query);

echo "Produtos: <br>";

if (sqlsrv_has_rows($result4) != -1) {
    echo ("nao há Produtos");
} else {
    echo"<table>";
        echo "<tr>";
        echo"<th>pid</th>";
        echo"<th>nome</th>";
        echo"<th>morada</th>";
        echo"<th>codigoPostal</th>";
        #echo"<th>tipo</th>";
        echo "</tr>";
    while($row = sqlsrv_fetch_array($result4)) {
        echo "<tr>";
        echo "<td>" . $row['pid'] . "</td>";
        echo "<td>" . $row['nome'] . "</td>";
        echo "<td>" . $row['morada'] . "</td>";
        echo "<td>" . $row['codigoPostal'] . "</td>";
        #echo "<td>" . $row['tipo'] . "</td>";
        echo "</tr>";
    }
    echo"</table>";
}
echo"<br>";

$transportes_query = "SELECT * FROM [dbo].[Veiculo]";
$result5 = sqlsrv_query($conn, $transportes_query);

echo "Transportes: <br>";

if (sqlsrv_has_rows($result5) != -1) {
    echo ("nao há Transportes");
} else {
    echo"<table>";
        echo "<tr>";
        echo"<th>categoria</th>";
        echo"<th>matricula</th>";
        echo"<th>transportadora</th>";
        echo "</tr>";
    while($row = sqlsrv_fetch_array($result5)) {
        echo "<tr>";
        echo"<td class=text-center>" . $row['categoria'] . "</td>";
        echo"<td class=text-center>" . $row['matricula'] . "</td>";
        echo"<td class=text-center>" . $row['transportadora'] . "</td>";
        #echo"<td class=text-center>" . $row['produto'] . "</td>";
        echo "</tr>";
    }
    echo"</table>";
}
echo"<br>";

?>