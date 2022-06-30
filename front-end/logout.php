<?php
session_start();

unset($_SESSION['email']);
unset($_SESSION['tipo']);
unset($_SESSION['nome']);

header("Location: index.php");

?>