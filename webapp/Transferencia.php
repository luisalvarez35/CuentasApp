<?php
session_start();
// Include config file
require_once "config/configuracion.php";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Prepare an insert statement
    $sql = "INSERT INTO ingresosGastos (tipo, idUsuario, idCategoria, idCuenta, fecha, importe) VALUES (?, ?, ?, ?, ?, ?) ";

    if($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("siiisi", $param_tipo, $param_idUsuario, $param_idCategoria, $param_idCuenta, $param_fecha, $param_importe);

        // Set parameters
        $param_tipo = "T";
        $param_idUsuario = trim($_POST["usuarioDestino"]);
        $param_idCategoria = 1;
        $param_idCuenta = trim($_POST["cuentaDestino"]);
        $param_fecha = date("Y/m/d");
        $param_importe = trim($_POST["importe"]);


        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Redirect to login page
            header("location: IngresosGastos.php");
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement

    }


    $sql = "INSERT INTO ingresosGastos (tipo, idUsuario, idCategoria, idCuenta, fecha, importe) VALUES (?, ?, ?, ?, ?, ?) ";

    if($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("siiisi", $param_tipo, $param_idUsuario, $param_idCategoria, $param_idCuenta, $param_fecha, $param_importe);

        // Set parameters
        $importe = trim($_POST["importe"]);
        $param_tipo = "T";
        $param_idUsuario = $_SESSION["id"];
        $param_idCategoria = 1;
        $param_idCuenta = trim($_POST["cuentaOrigen"]);
        $param_fecha = date("Y/m/d");
        $param_importe = -$importe;

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Redirect to login page
            header("location: IngresosGastos.php");
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        $stmt->close();
    }
    $mysqli->close();
}
?>
