<?php

include("../../bd.php");

if(isset($_GET['txtID'])){
    $txtID = (isset($_GET["txtID"])) ? $_GET["txtID"] : "";

    //Borra el registro en la base de datos.
    $sentencia = $conexion ->  prepare("DELETE FROM tbl_comentarios WHERE ID = :id");
    $sentencia -> bindParam(":id", $txtID);
    $sentencia -> execute();
    header("Location: index.php");
}

//Traemos los datos de la base de datos y los mostramos en la tabla
$sentencia = $conexion -> prepare("SELECT * FROM tbl_comentarios");
$sentencia -> execute();
$lista_comentarios = $sentencia -> fetchAll(PDO::FETCH_ASSOC);

include("../../templates/header.php"); ?>

<br/>
<div class="card">
    <div class="card-header">Comentarios</div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Mensaje</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($lista_comentarios as $comentarios => $value) { ?>
                        <tr class="">
                            <td scope="row"> <?php echo $value['ID']; ?> </td>
                            <td> <?php echo $value['nombre']; ?> </td>
                            <td> <?php echo $value['correo']; ?> </td>
                            <td> <?php echo $value['mensaje']; ?> </td>
                            <td>
                                <!-- <a name="" id="" class="btn btn-info" href="editar.php?txtID=<?php echo $value['ID'] ?>" role="button"> Editar </a> -->
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