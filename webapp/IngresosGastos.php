<?php
session_start();
// Include config file
require_once "config/configuracion.php";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $tipo = trim($_POST["tipo"]);

    if($tipo == "G"){
        $importe = (trim($_POST["importe"])) *-1;
    }elseif ($tipo == "I"){
        $importe = trim($_POST["importe"]);
    }

    $idUsuario = trim($_POST["idUsuario"]);
    $idCategoria =trim($_POST["idCategoria"]);
    $idCuenta =trim($_POST["idCuenta"]);




    // Prepare an insert statement
    $sql = "INSERT INTO ingresosGastos (tipo, idUsuario, idCategoria, idCuenta, fecha, importe) VALUES (?, ?, ?, ?, ?, ?) ";

    if($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("siiisi", $param_tipo, $param_idUsuario, $param_idCategoria, $param_idCuenta, $param_fecha, $param_importe);

        // Set parameters
        $param_tipo = $tipo;
        $param_idUsuario = $_SESSION["id"];
        $param_idCategoria = $idCategoria;
        $param_idCuenta = $idCuenta;
        $param_fecha = date("Y/m/d");
        $param_importe = $importe;

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
            <li class="nav-link"><a href="IngresosGastos.php">IngresosGastos</a></li>
            <li class="nav-link"><a href="Cuentas.php">Cuentas</a></li>
            <li class="nav-link"><a href="Usuarios.php">Usuarios</a></li>
            <li class="nav-link"><a href="Categorias.php">Categorias</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="nav-item"><a><?php echo "Bienvenido ".$_SESSION["email"] ;?></a></li>
            <li class="nav-item"><a><?php echo "Numero de visitas: ".$_COOKIE["Visitas"] ;?></a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </ul>
    </div>
</nav>


<div class="container-fluid">

    <div class="panel-body">
        <div class="pull-right">

             <!--<a href="introducirIngresosGastos.php" class="btn btn-sm btn-primary" >Nuevo Movimiento</a>-->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#IngresosGastosModal">Introducir Movimiento</button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Transferencia">Realizar Transferencia</button>

        </div>
    </div>





    <div class="modal fade" id="IngresosGastosModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 style="align-content: center" class="modal-title">Introducir Ingresos o Gastos</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["SCRIPT_NAME"]); ?>" method="post">
                            <div class="form-group">
                                <label>Id Usuario</label>
                                <input type="number" name="idUsuario" class="form-control" value="<?php echo $_SESSION['id']; ?>" readonly="readonly">
                            </div>
                            <div class="form-group">
                                <label>Tipo</label>
                                    <select name="tipo" class="form-control">
                                        <option value="I">Ingreso</option>
                                        <option value="G">Gasto</option>
                                    </select>
                            </div>
                            <div class="form-group">
                                <label>Id Categoria</label>
                                <input type="number" name="idCategoria" class="form-control" value="<?php echo $idCategoria; ?>">
                            </div>
                            <div class="form-group">
                                <label>Id Cuenta</label>
                                <input type="number" name="idCuenta" class="form-control" value="<?php echo $idCuenta; ?>">
                            </div>
                            <div class="form-group">
                                <label>Importe</label>
                                <input type="number" name="importe" class="form-control" value="<?php echo $importe; ?>">
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


    <div class="modal fade" id="Transferencia" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 style="align-content: center" class="modal-title">Realizar Transferencia</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["SCRIPT_NAME"]); ?>" method="post">

                        <div class="form-group">
                            <label>Cuenta Origen</label>
                            <input type="number" name="cuentaOrigen" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Usuario Destino</label>
                            <input type="number" name="usuarioDestino" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Cuenta Destino</label>
                            <input type="number" name="cuentaDestino" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Importe</label>
                            <input type="number" name="importe" class="form-control">
                        </div>

                        <div class="form-group">
                            <input type="submit" formaction="Transferencia.php" class="btn btn-primary" value="Realizar Transferencia" >
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
        $query = mysqli_query($mysqli, "SELECT * FROM ingresosGastos WHERE id='$id_delete'");
        if ( mysqli_num_rows($query) == 0 )
        {
            echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No se encontro el Registro.</div>';
        }
        else
        {
            $delete = mysqli_query($mysqli, "DELETE FROM ingresosGastos WHERE id='$id_delete'");
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

        <table id="IdTablaIngresosGastos" class="table table-bordered dataTable-responsive table-hover " >
            <thead bgcolor="#ddeeee">
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>ID Categoria</th>
                <th>ID Cuenta</th>
                <th>Fecha</th>
                <th>Importe</th>
                <th class="text-center"> Acciones </th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th id="Balance" colspan="6" style="text-align:right"></th>
                <th></th>
            </tr>
            </tfoot>

        </table>
    </div>


    <script>
        $(document).ready(function()
        {
            var dataTable = $('#IdTablaIngresosGastos').DataTable( {

                "footerCallback": function ( row, data, start, end, display )
                {
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i )
                    {
                        return typeof i === 'string' ?i.replace(/[\$,]/g, '')*1:typeof i === 'number' ?i : 0;
                    };

                    // Total de todas las Páginas
                    total = api.column( 5 ).data().reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );

                    // Total de la página actual
                    pageTotal = api.column( 5, { page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );

                    // Actualiza el pie (footer)
                    $( api.column( 4 ).footer() ).html( "Balance: " + pageTotal+' €' +' ( '+ total + '€' +' total)' );
                },

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
                    url : "Ajax-IngresosGastos.php", 		// Obtine los datos en JSON
                    type: "post",  					// Metodo para petición ajax
                    error: function(){  			// Función a ejecutar si se produce un error
                        $(".IdTabla-error").html("");
                        $("#IdTablaIngresosGastos").append('<tbody class="employee-grid-error"><tr><th colspan="3">No se encontraron datos en el Servidor</th></tr></tbody>');
                        $("#IdTabla_processing").css("display","none");
                    }
                }
            } );
        } );
    </script>


</div>

</body>
</html>

