<?php
if ( isset($_POST['update']) )
{
    require_once "config/configuracion.php";
    $id			= intval($_POST['id']);
    //$idUsuario  	= mysqli_real_escape_string($mysqli,(strip_tags($_POST['idUsuario'], ENT_QUOTES)));
    $descripcion 		= mysqli_real_escape_string($mysqli,(strip_tags($_POST['descripcion'], ENT_QUOTES)));


    $update = mysqli_query($mysqli, "UPDATE cuentas SET descripcion='$descripcion' WHERE id='$id'") or die(mysqli_error());
    if ( $update )
    {
        header("location: Cuentas.php");
        exit;

    }else
    {
        echo "<script>alert('Error, no se pudo actualizar los datos'); window.location = 'Cuentas.php'</script>";
    }
}?>

