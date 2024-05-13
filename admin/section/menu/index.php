<?php 

include("../../bd.php");


if(isset($_GET['txtID'])){
    $txtID = (isset($_GET["txtID"])) ? $_GET["txtID"] : "";

    //Proceso de borrado que busque la imagen y la pueda borrar.
    $sentencia = $conexion ->  prepare("SELECT * FROM tbl_menu WHERE ID = :id");
    $sentencia -> bindParam(":id", $txtID);
    $sentencia -> execute();

    $registro_foto = $sentencia -> fetch(PDO::FETCH_LAZY);

    //Borra el archivo de forma física.
    if(isset($registro_foto['foto'])){
        if(file_exists("../../../images/menu/".$registro_foto['foto'])){
            unlink("../../../images/menu/".$registro_foto['foto']);
        }
    }

    //Borra el registro en la base de datos.
    $sentencia = $conexion ->  prepare("DELETE FROM tbl_menu WHERE ID = :id");
    $sentencia -> bindParam(":id", $txtID);
    $sentencia -> execute();
    header("Location: index.php");
}

//Traemos los datos de la base de datos y los mostramos en la tabla
$sentencia = $conexion -> prepare("SELECT * FROM tbl_menu");
$sentencia -> execute();
$lista_menu = $sentencia -> fetchAll(PDO::FETCH_ASSOC);

include("../../templates/header.php"); ?>

<br/>
<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button"> Agregar registros </a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Ingredientes</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($lista_menu as $menu => $value) { ?>
                        <tr class="">
                            <td scope="row"> <?php echo $value['ID']; ?> </td>
                            <td> <?php echo $value['nombre']; ?> </td>
                            <td> <?php echo $value['ingredientes']; ?> </td>
                            <td> 
                                <img src="../../../images/menu/<?php echo $value['foto']; ?>" alt="" width="50px" height="50px">
                                <!-- <?php echo $value['foto']; ?>  -->
                            </td>
                            <td> <?php echo $value['precio']; ?> </td>
                            <td>
                                <a name="" id="" class="btn btn-info" href="editar.php?txtID=<?php echo $value['ID'] ?>" role="button"> Editar </a>
                                <a name="" id="" class="btn btn-danger" href="index.php?txtID=<?php echo $value['ID'] ?>" role="button"> Borrar </a>  
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php include("../../templates/footer.php"); ?>