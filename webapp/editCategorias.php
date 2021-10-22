<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.3.3/css/select.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/keytable/2.6.4/css/keyTable.dataTables.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous"></head>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="span12">
            <div class="content">
                <?php
                require_once "config/configuracion.php";
                $id  = intval($_GET['id']);
                $sql = mysqli_query($mysqli , " SELECT * FROM Categorias WHERE id='$id' ") or die(mysqli_error());
                if ( mysqli_num_rows($sql) == 0 )
                {
                    header("Location: Categorias.php");
                }
                else
                {
                    $row = mysqli_fetch_assoc($sql);
                }
                ?>


                <form name="form1" id="form1" class="form-horizontal row-fluid" action= " <?php echo "UpdateCategorias.php" ?> " method="POST" >
                    <div class="control-group">
                        <label class="control-label" for="basicinput">ID</label>
                        <div class="controls">
                            <input type="number" name="id" id="id" value="<?php echo $row['id']; ?>" placeholder="" class="form-control span8 tip" readonly="readonly">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="basicinput">Descripcion</label>
                        <div class="controls">
                            <input type="text" name="nombre" id="nombre" value="<?php echo $row['nombre']; ?>" placeholder="" class="form-control span8 tip" required>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <input type="submit" name="update" id="update" value="Actualizar" class="btn btn-sm btn-primary"/>
                            <a href="Categorias.php" class="btn btn-sm btn-danger">Cancelar</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>

</body>
</html>


