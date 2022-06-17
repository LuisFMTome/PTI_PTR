<?php
session_start();

unset($_SESSION['email']);
unset($_SESSION['tipo']);
unset($_SESSION['nome']);
unset($_SESSION["cart"]);

header("Location: index.php");

?>