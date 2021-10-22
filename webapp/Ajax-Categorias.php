<?php

require_once "config/configuracion.php";
$requestData = $_REQUEST; 			// Obtenemos array de variables globales (GET, POST, ...)

$columns = array( 	// Indice => Nombre columna
    0 => 'id',
    1 => 'nombre'

);

$sql = "SELECT id, nombre ";
$sql.=" FROM categorias";
$query = mysqli_query($mysqli, $sql) or die("Ajax-Categorias.php: obtiene los datos para el grid.");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  				// Cuando no hay busqueda Nº de total de registros = Nº de registros con filtro

////////////////////////////////////////////////////////////////////////////////////////////////
// Comprobamos si hay que realizar busqueda
////////////////////////////////////////////////////////////////////////////////////////////////
if ( !empty($requestData['search']['value']) )
{
    ////////////////////////////////////////////////////////////////////////////////////////////////
    // Si hay parámetros de busqueda los aplicamos en la consulta
    ////////////////////////////////////////////////////////////////////////////////////////////////
    $sql = "SELECT id, nombre ";
    $sql.=" FROM categorias";
    $sql.=" WHERE id LIKE '".$requestData['search']['value']."%' ";    // $requestData['search']['value'] contiene parametros de busqueda
    $sql.=" OR nombre LIKE '".$requestData['search']['value']."%' ";
    $query=mysqli_query($mysqli, $sql) or die("Ajax-Categorias.php: get PO");

    $totalFiltered = mysqli_num_rows($query); 	// cuando hay un parámetro de búsqueda, tenemos que modificar el número total de registros con el filtro aplicado
    ////////////////////////////////////////////////////////////////////////////////////////////////



    ////////////////////////////////////////////////////////////////////////////////////////////////
    // Parametros de ordenación y límite de registros si se envian
    ////////////////////////////////////////////////////////////////////////////////////////////////
    // $requestData['order'][0]['column'] contine el indice de la columna por la que ordenar,
    // $requestData['order'][0]['dir'] contine como ordenar asc/desc
    // $requestData['start'] contine el Nº de registro inicial
    // $requestData['length'] contiene el número de registros
    ////////////////////////////////////////////////////////////////////////////////////////////////
    $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
    $query=mysqli_query($mysqli, $sql) or die("Ajax-Categorias.php: get PO"); // Ejecutamos la consulta otra vez con los límites indicados
    ////////////////////////////////////////////////////////////////////////////////////////////////
}
else // Sin parámetros de busqueda
{
    $sql = "SELECT id, nombre ";
    $sql.=" FROM categorias";
    $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
    $query=mysqli_query($mysqli, $sql) or die("Ajax-Categorias.php: get PO");
}
////////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////////////
// Preparamos array para enviar a datatables
////////////////////////////////////////////////////////////////////////////////////////////////
$data = array();
while ( $row=mysqli_fetch_array($query) ) 	// preparamos array
{
    $nestedData   =array();
    $nestedData[] = $row["id"];
    $nestedData[] = $row["nombre"];


    $nestedData[] = '<td><center>
							<a href="editCategorias.php?id='.$row['id'].'"  data-toggle="tooltip" title="Editar datos" class="btn btn-sm btn-info"> <i class="fas fa-edit"></i> Editar </a>
							<a href="Categorias.php?action=delete&id='.$row['id'].'"  data-toggle="tooltip" title="Eliminar" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </a>
							</center></td>';
    $data[] 	  = $nestedData;
}

$json_data = array(
    "draw"            => intval( $requestData['draw'] ),    // parametro que envia datatables cuando hace la petición ajax
    "recordsTotal"    => intval( $totalData ),  			// Nº Total de Registros en la Tabla
    "recordsFiltered" => intval( $totalFiltered ),	 		// Nº de registros con el filtro aplicado
    "data"            => $data   							// Array con los datos a visualizar en datatables
);

echo json_encode($json_data);  	// Enviamos datos en formato JSON
////////////////////////////////////////////////////////////////////////////////////////////////
?>
