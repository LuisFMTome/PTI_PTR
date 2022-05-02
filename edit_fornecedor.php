<?php
include "openconn.php";
session_start();

//$areasInteresse = htmlspecialchars($_POST["areas_interesse"]);
//$populacaoAlvo = htmlspecialchars($_POST["populacao_alvo"]);
//$dias_semana = htmlspecialchars($_POST["dias_semana"]);
//$horas_dia = htmlspecialchars($_POST["horas_dia"]);
$nome = htmlspecialchars($_POST["nome"]);
$email = htmlspecialchars($_POST["email"]);
$morada = htmlspecialchars($_POST["morada"]);
$codigo_postal = htmlspecialchars($_POST["codPostal"]);

//Inserting data into table

//$update_v = "UPDATE Voluntario SET areasDeInteresse='$areasInteresse', populacaoAlvo='$populacaoAlvo' WHERE nome='$_SESSION[username]'";
//$update_v = "UPDATE Voluntario SET areasDeInteresse='$areasInteresse', populacaoAlvo='$populacaoAlvo', diasDaSemana='$dias_semana', horasDoDia='$horas_dia' WHERE nome='$_SESSION[username]'";
$update_v = "UPDATE [Consumidor] SET [dbo].[Consumidor] ([nome], [email], [morada], [codigo_postal]) VALUES ('$nome', '$mail', '$morada', '$codigo_postal') WHERE nome='$_SESSION[username]'";
    $res1 = sqlsrv_query($conn, $update_v);
    if($res1){
        echo "dados inseridos com sucesso";
        header( "refresh:5; url=perfil_vol.php" );
    } else {
        echo "Erro: insert failed" . $query . "<br>" . mysqli_error($conn);
        header( "refresh:5; url=conta.html" );
    }

    mysqli_close($conn);
   
?>