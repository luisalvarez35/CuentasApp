<?php

// Include config file
require_once "config/configuracion.php";


// Define variables and initialize with empty values
$email = $password = $confirm_password = $nombre= $fechaNac = "";
$email_err = $password_err = $confirm_password_err = $nombre_err = $fechaNac_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate nombre
    if(empty(trim($_POST["nombre"]))){
        $nombre_err = "Porfavor introduzca un nombre.";
    } else{

        // Prepare a select statement
        $sql = "SELECT id FROM usuarios WHERE nombre = ?";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_nombre);

            // Set parameters
            $param_nombre = trim($_POST["nombre"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();

                if($stmt->num_rows == 1){
                    $nombre_err = "This username is already taken.";
                } else{
                    $nombre = trim($_POST["nombre"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Porfavor introduzca un email.";
    } elseif(!preg_match('/^\S+@\S+\.\S+$/', trim($_POST["email"]))){
        $email_err = "Username can only contain letters, numbers, and underscores.";
    } else{

        // Prepare a select statement
        $sql = "SELECT id FROM usuarios WHERE email = ?";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();

                if($stmt->num_rows == 1){
                    $email_err = "This username is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Validate fechaNac
    if(empty(trim($_POST["fechaNac"]))){
        $fechaNac_err = "Introduzca fecha.";
    } else{
        $fechaNac = trim($_POST["fechaNac"]);
    }

    // Check input errors before inserting in database
    if(empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($nombre_err) && empty($fechaNac_err)){



        // Prepare an insert statement
        $sql = "INSERT INTO usuarios (nombre, password, email, fechaNac) VALUES (?, ?, ?, ?)";



        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssss", $param_nombre, $param_password, $param_email, $param_fechaNac);

            // Set parameters
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_BCRYPT); // Creates a password hash
            $param_nombre = $nombre;
            $param_fechaNac = $fechaNac;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: Usuarios.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $mysqli->close();
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
        <ul class="nav navbar-nav ">
            <li class="nav-link"><a href="IngresosGastos.php"">IngresosGastos</a></li>
            <li class="nav-link"><a href="Cuentas.php">Cuentas</a></li>
            <li class="nav-link"><a href="Usuarios.php">Usuarios</a></li>
            <li class="nav-link"><a href="Categorias.php">Categorias</a></li>

        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="nav-item"><a><?php echo "Numero de visitas: ".$_COOKIE["Visitas"] ;?></a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </ul>
    </div>
</nav>

<div class="container-fluid">

    <div class="panel-body">
        <div class="pull-right">
            <!--<a href="introducirIngresosGastos.php" class="btn btn-sm btn-primary" >Nuevo Movimiento</a>-->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#UsuariosModal">Introducir Usuario</button>
        </div>
    </div>


    <div class="modal fade" id="UsuariosModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 style="align-content: center" class="modal-title">Introducir Usuario</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["SCRIPT_NAME"]); ?>" method="post">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control <?php echo (!empty($nombre_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nombre; ?>">
                            <span class="invalid-feedback"><?php echo $nombre_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Fecha Nacimiento</label>
                            <input type="date" name="fechaNac" class="form-control <?php echo (!empty($fechaNac_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $fechaNac; ?>">
                            <span class="invalid-feedback"><?php echo $fechaNac_err; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <input type="reset" class="btn btn-secondary ml-2" value="Reset">
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <?php
    if ( isset($_GET['action']) == 'delete' )
    {
        $id_delete = intval($_GET['id']);
        $query = mysqli_query($mysqli, "SELECT * FROM usuarios WHERE id='$id_delete'");
        if ( mysqli_num_rows($query) == 0 )
        {
            echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No se encontro el Registro.</div>';
        }
        else
        {
            $delete = mysqli_query($mysqli, "DELETE FROM usuarios WHERE id='$id_delete'");
            if ($delete)
            {
                echo '<div class="alert alert-primary alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>  Registro eliminado correctamente.</div>';
            }
            else
            {
                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Error, no se pudo eliminar el Registro.</div>';
            }
        }
    }
    ?>

<div class="container-fluid">

    <div class="container-fluid">

        <table id="IdTablaUsuarios" class="table table-bordered dataTable-responsive table-hover " >
            <thead bgcolor="#ddeeee">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Password (Hash)</th>
                <th>Email</th>
                <th>Fecha Alta</th>
                <th>Fecha Nacimiento</th>
                <th class="text-center"> Acciones </th>
            </tr>
            </thead>

        </table>
    </div>


    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/keytable/2.6.1/js/dataTables.keyTable.min.js"></script>


    <script>
        $(document).ready(function()
        {
            var dataTable = $('#IdTablaUsuarios').DataTable( {
                "processing" : true,
                "pageLength" : 8,
                "serverSide" : true,
                responsive   : true,
                buttons		 :  [
                    { extend: 'copy', text: 'Copiar' }, 	//	{ extend: 'excel', text: 'Excel' },
                    { extend: 'csv', text: 'CSV' },
                    { extend: 'pdfHtml5', text: 'PDF', orientation: 'landscape', pageSize: 'A4'},
                    { extend: 'print', text: 'Imprimir' },
                    { text: 'Seleccionar Todo',action: function ()      { dataTable.rows().select();	} },
                    { text: 'Deseleccionar Todo', action: function ()   { dataTable.rows().deselect(); } }
                ],
                keys		 : true,
                select	     : { style: 'os' },  //'single','multi','os' ,  items: 'cell', blurable: true
                deferRender  : true,  			 // Representación diferida
                "columnDefs" : [ {
                    "searchable": false,
                    "orderable": false,
                    "targets": [0,6]
                } ],
                "order"      :  [[3, "asc" ]],
                "lengthMenu" :	[[6, 8, 10, 25, 50, 100, 250, 500, 1000, -1], [6, 8, 10, 25, 50, 100, 250, 500, 1000, 'Todo']],
                "dom"		 : '<"top"lBfp<"clear">>rt<"bottom"ip<"clear">>',
                "language":	{
                    "sProcessing":     "Procesando...",
                    "lengthMenu": 	   "Mostrar _MENU_ Registros &nbsp;&nbsp;",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    select: {
                        rows: {
                            _: "Hay %d filas seleccionadas.",
                            0: "Haga Click para seleccionar la fila.",
                            1: "Hay 1 fila seleccionada."
                        }
                    },
                    buttons: {
                        pageLength: "%d Líneas",
                        copySuccess:{
                            1: "Copiada una fila en el Portapapeles",
                            _: "Copiadas %d filas en el Portapapeles"
                        },
                        copyTitle: 'Datos Copiados'
                    }
                },
                "ajax":{
                    url : "Ajax-Usuarios.php", 		// Obtine los datos en JSON
                    type: "post",  					// Metodo para petición ajax
                    error: function(){  			// Función a ejecutar si se produce un error
                        $(".IdTabla-error").html("");
                        $("#IdTablaUsuarios").append('<tbody class="employee-grid-error"><tr><th colspan="3">No se encontraron datos en el Servidor</th></tr></tbody>');
                        $("#IdTabla_processing").css("display","none");
                    }
                }
            } );
        } );
    </script>


</div>

</body>
</html>
