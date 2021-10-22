<?php
if ( isset($_POST['update']) )
{
    require_once "config/configuracion.php";
    $id			= intval($_POST['id']);
    //$idUsuario  	= mysqli_real_escape_string($mysqli,(strip_tags($_POST['idUsuario'], ENT_QUOTES)));
    $nombre 		= mysqli_real_escape_string($mysqli,(strip_tags($_POST['nombre'], ENT_QUOTES)));


    $update = mysqli_query($mysqli, "UPDATE Categorias SET nombre='$nombre' WHERE id='$id'") or die(mysqli_error());
    if ( $update )
    {
        header("location: Categorias.php");
        exit;

    }else
    {
        echo "<script>alert('Error, no se pudo actualizar los datos'); window.location = 'Categorias.php'</script>";
    }
}?>


