<?php

require_once "config/configuracion.php";
if ( isset($_POST['update']) )
{

    $id			= intval($_POST['id']);
    $tipo	= mysqli_real_escape_string($mysqli,(strip_tags($_POST['tipo'], ENT_QUOTES)));
    $idUsuario  	= mysqli_real_escape_string($mysqli,(strip_tags($_POST['idUsuario'], ENT_QUOTES)));
    $idCategoria 		= mysqli_real_escape_string($mysqli,(strip_tags($_POST['idCategoria'], ENT_QUOTES)));
    $idCuenta  = mysqli_real_escape_string($mysqli,(strip_tags($_POST['idCuenta'], ENT_QUOTES)));
    $fecha  = mysqli_real_escape_string($mysqli,(strip_tags($_POST['fecha'], ENT_QUOTES)));
    $importe  = mysqli_real_escape_string($mysqli,(strip_tags($_POST['importe'], ENT_QUOTES)));




    $update = mysqli_query($mysqli, "UPDATE ingresosGastos SET id='$id', tipo='$tipo', idUsuario='$idUsuario', idCategoria='$idCategoria', idCuenta='$idCuenta', fecha='$fecha', importe='$importe' WHERE id='$id'") or die(mysqli_error());
    if ( $update )
    {

        header("location: IngresosGastos.php");
        exit;

    }else
    {
        echo "<script>alert('Error, no se pudo actualizar los datos'); window.location = 'ingresosGastos.php'</script>";
    }
}
?>
