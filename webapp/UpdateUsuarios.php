<?php
if ( isset($_POST['update']) )
{
    require_once "config/configuracion.php";
    $id			= intval($_POST['id']);
    $nombre	= mysqli_real_escape_string($mysqli,(strip_tags($_POST['nombre'], ENT_QUOTES)));
    $password  	= mysqli_real_escape_string($mysqli,(strip_tags($_POST['password'], ENT_QUOTES)));
    $email 		= mysqli_real_escape_string($mysqli,(strip_tags($_POST['email'], ENT_QUOTES)));
    //$fechaAlta  = mysqli_real_escape_string($mysqli,(strip_tags($_POST['fechaAlta'], ENT_QUOTES)));
    $fechaNac  = mysqli_real_escape_string($mysqli,(strip_tags($_POST['fechaNac'], ENT_QUOTES)));

    $passhash = password_hash($password, PASSWORD_BCRYPT);

    $update = mysqli_query($mysqli, "UPDATE usuarios SET id='$id', nombre='$nombre', password='$passhash', email='$email' , fechaNac='$fechaNac' WHERE id='$id'") or die(mysqli_error());
    if ( $update )
    {
        header("location: Usuarios.php");
        exit;

    }else
    {
        echo "<script>alert('Error, no se pudo actualizar los datos'); window.location = 'ingresosGastos.php'</script>";
    }
}?>
