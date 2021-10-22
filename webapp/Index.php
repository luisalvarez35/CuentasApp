<?php
// Initialize the session
session_start();
include "contadorVisitas.php";
// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ("Cabecera.php") ?>
</head>
<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">CuentasApp</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="active"><a href="Inicio.php">Inicio</a></li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Paginas <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="IngresosGastos.php">IngresosGastos</a></li>
                    <li><a href="Cuentas.php">Cuentas</a></li>
                    <li><a href="Usuarios.php">Usuarios</a></li>
                    <li><a href="Categorias.php.php">Usuarios</a></li>
                </ul>
            </li>

        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="registro.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
            <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
        </ul>
    </div>
</nav>


</body>
</html>

