<?php
session_start();
// Include config file
require_once "config/configuracion.php";
    $idUsuario = '';
    $descripcion ='';

// Processing form data when form is submitted
 if ( $_SERVER["REQUEST_METHOD"] == "POST" )
    {
        $idUsuario = trim($_POST["idUsuario"]);
        $descripcion =trim($_POST["descripcion"]);
        // Prepare an insert statement
        $sql = "INSERT INTO cuentas(idUsuario, descripcion) VALUES (?, ?)";

     if ($stmt = $mysqli->prepare($sql))
        {
         // Bind variables to the prepared statement as parameters
         $stmt->bind_param("is",$param_idUsuario, $param_descripcion);

         // Set parameters
         $param_idUsuario = $_SESSION["id"];;
         $param_descripcion = $descripcion;

         // Attempt to execute the prepared statement
         if($stmt->execute())
            {
             // Redirect to login page
             header("location: Cuentas.php");
            }
          else
            {
             echo "Oops! Something went wrong. Please try again later.";
            }

        // Close statement
        $stmt->close();
    }
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
        <ul class="nav navbar-nav">
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
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#CuentasModal">Nueva Cuenta</button>
        </div>
    </div>
</div>

    <div class="modal fade" id="CuentasModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 style="align-content: center" class="modal-title">Introducir Cuenta</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["SCRIPT_NAME"]); ?>" method="post">
                        <div class="form-group">
                            <label>Descripcion</label>
                            <input type="text" name="descripcion" class="form-control" value="<?php echo $descripcion; ?>">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary"  value="Submit">
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
        $query = mysqli_query($mysqli, "SELECT * FROM cuentas WHERE id='$id_delete'");
        if ( mysqli_num_rows($query) == 0 )
        {
            echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No se encontro el Registro.</div>';
        }
        else
        {
            $delete = mysqli_query($mysqli, "DELETE FROM cuentas WHERE id='$id_delete'");
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

        <table id="IdTablaCuentas" class="table table-bordered dataTable-responsive table-hover " >
            <thead bgcolor="#ddeeee">
            <tr>
                <th>ID</th>
                <th>Id Usuario</th>
                <th>Descripcion</th>
                <th class="text-center"> Acciones </th>
            </tr>
            </thead>

        </table>
    </div>


    <script>
        $(document).ready(function()
        {
            var dataTable = $('#IdTablaCuentas').DataTable( {
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
                    "targets": [0,1]
                } ],
                "order"      :  [[0, "asc" ]],
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
                    url : "Ajax-Cuentas.php", 		// Obtine los datos en JSON
                    type: "post",  					// Metodo para petición ajax
                    error: function(){  			// Función a ejecutar si se produce un error
                        $(".IdTablaCuentas-error").html("");
                        $("#IdTablaCuentas").append('<tbody class="employee-grid-error"><tr><th colspan="3">No se encontraron datos en el Servidor</th></tr></tbody>');
                        $("#IdTablaCuentas_processing").css("display","none");
                    }
                }
            } );
        } );
    </script>


</div>

</body>
</html>


