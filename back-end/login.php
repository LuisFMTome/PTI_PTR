<?php

$serverName = "sqldb05server1.database.windows.net"; // update me
$connectionOptions = array(

    "Database" => "sqldb1", // update me
    "Uid" => "ptrptisqldb", // update me
    "PWD" => "2SdULWb5ePk83jA" // update me

);
//Establishes the connection
//$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {

    //die(print_r(sqlsrv_errors(), true));

}

if (isset($_POST["login"])) { // nome do botão errado

    $email = $_POST['email']; // nomes errados
    $password = $_POST['pass']; // nomes erradoslogin

    if (empty($username) || empty($password)) {

        //header("Location: ../ php?error=emptyfields"); // URL da página correta
        exit();
    } else {

        $stmt = mysqli_stmt_init($conn);

        $searchUserQuery = "SELECT * FROM [dbo].[Consumidor] WHERE email = ?";

        if (!mysqli_stmt_prepare($stmt, $searchUserQuery)) {

            //header("Location: "); // Redireciona para página de erro
            exit();
        } else {

            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {

                $pwdCheck = password_verify($password, $row["Password"]); // Nome provavlemnte errado

                if ($pwdCheck == false) {

                    //header("Location ...") //Redireciona
                    exit();
                } else if ($pwdCheck == true) {

                    session_start();
                    $_SESSION["userId"] = $row["Username"]; // id da tag no html e nome da coluna na tabela
                    $username = $_SESSION["userId"];
                    //header("Location ../=.$username");
                    exit();
                } else {

                    //header("Location: / .php?error=nouser") //Redireciona para página de erro
                    exit();
                }
            } else {

                //header("Location: ../ .php?error=nouser"); //Redireciona para página de erro
                exit();
            }
        }
    }
} else {

    header("Location: ../index.html"); // URL se alhar está errado
    exit();
}
