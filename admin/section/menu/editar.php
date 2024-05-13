<?php 

include("../../bd.php");

//Traemos los datos de la tabla de menú y los cargamos en los inputs para modificar. 
if(isset($_GET['txtID'])){
    $txtID = (isset($_GET["txtID"])) ? $_GET["txtID"] : "";
    
    $sentencia = $conexion -> prepare("SELECT * FROM tbl_menu WHERE ID = :id");
    $sentencia -> bindParam(":id", $txtID);
    $sentencia -> execute();

    //Recuperación de datos y asignarlo al formulario.
    $registro = $sentencia -> fetch(PDO::FETCH_LAZY);
    $nombre = $registro["nombre"];
    $ingredientes = $registro["ingredientes"];
    $precio = $registro["precio"];
    $foto = $registro["foto"];
} 

//Envío de los datos para realizar la acutalización de los datos.
if($_POST){
    $txtID = (isset($_POST["txtID"])) ? $_POST["txtID"] : "";
    $nombre = (isset($_POST["nombre"])) ? $_POST["nombre"] : "";
    $ingredientes = (isset($_POST["ingredientes"])) ? $_POST["ingredientes"] : "";
    $precio = (isset($_POST["precio"])) ? $_POST["precio"] : "";
   
   //Proceso de actualización de foto
    $foto = (isset($_FILES["foto"]["name"])) ? $_FILES['foto']["name"] : "";
    $tmp_foto = $_FILES["foto"]["tmp_name"];

    if($foto != ""){
        $fecha_foto = new DateTime();
        $nombre_foto = $fecha_foto -> getTimestamp()."_".$foto;
        $ruta_foto = "../../../images/menu/".$nombre_foto;
        move_uploaded_file($tmp_foto,$ruta_foto);

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

        //Se realiza la actualización de la foto
        $sentencia = $conexion ->  prepare("UPDATE `tbl_menu` 
        SET foto = :foto
        WHERE ID = :id;");

        $sentencia -> bindParam(":foto",$nombre_foto);
        $sentencia -> bindParam(":id",$txtID);
        $sentencia -> execute();
    }

    //Sentencia con la cual se actualizan los otros campos del colaborador
    $sentencia = $conexion ->  prepare("UPDATE `tbl_menu` 
        SET 
        nombre = :nombre, 
        ingredientes = :ingredientes, 
        precio = :precio 
        WHERE ID = :id");

    $sentencia -> bindParam(":nombre",$nombre);
    $sentencia -> bindParam(":ingredientes",$ingredientes);
    $sentencia -> bindParam(":precio",$precio);
    $sentencia -> bindParam(":id",$txtID);

    $sentencia -> execute();
    header("Location: index.php");
}


include("../../templates/header.php"); ?>

<br/>
<div class="card">
    <div class="card-header">Menú de Platos</div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="txtID" class="form-label">ID:</label>
                <input type="text" class="form-control" value="<?php echo $txtID ?>"
                    name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID" />
            </div>
            
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" value="<?php echo $nombre ?>"
                    name="nombre" id="nombre" aria-describedby="helpId" placeholder="Nombre del plato"/>
            </div>

            <div class="mb-3">
                <label for="ingredientes" class="form-label">Ingredientes:</label>
                <input type="text" class="form-control" value="<?php echo $ingredientes ?>"
                    name="ingredientes" id="ingredientes" aria-describedby="helpId" placeholder="Ingredientes"/>
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto:</label><br/>
                <img src="../../../images/menu/<?php echo $foto ?>" width="70px" class="img-thumbnail"/>
                <input type="file" class="form-control" name="foto" id="foto" placeholder="" aria-describedby="fileHelpId"/>
            </div>

            <div class="mb-3">
                <label for="precio" class="form-label">Precio:</label>
                <input type="text" class="form-control" value="<?php echo $precio ?>"
                    name="precio" id="precio" aria-describedby="helpId" placeholder="Precio del plato"/>
            </div>
            
            <button type="submit" class="btn btn-success">Modificar Plato</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
    <div class="card-footer text-muted"></div>
</div>



<?php include("../../templates/footer.php"); ?>