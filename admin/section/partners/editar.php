<?php 

include("../../bd.php");

//Traemos los datos de la tabla de colaboradores y los cargamos en los inputs para modificar. 
if(isset($_GET['txtID'])){
    $txtID = (isset($_GET["txtID"])) ? $_GET["txtID"] : "";
    
    $sentencia = $conexion -> prepare("SELECT * FROM tbl_colaboradores WHERE ID = :id");
    $sentencia -> bindParam(":id", $txtID);
    $sentencia -> execute();

    //Recuperación de datos y asignarlo al formulario.
    $registro = $sentencia -> fetch(PDO::FETCH_LAZY);
    $titulo = $registro["titulo"];
    $descripcion = $registro["descripcion"];
    $linkfacebook = $registro["linkfacebook"];
    $linkinstagram = $registro["linkinstagram"];
    $linklinkedin = $registro["linklinkedin"];
    $foto = $registro["foto"];
} 

//Envío de los datos para realizar la acutalización de los datos.
if($_POST){
    $txtID = (isset($_POST["txtID"])) ? $_POST["txtID"] : "";
    $titulo = (isset($_POST["titulo"])) ? $_POST["titulo"] : "";
    $descripcion = (isset($_POST["descripcion"])) ? $_POST["descripcion"] : "";
    $linkfacebook = (isset($_POST["linkfacebook"])) ? $_POST["linkfacebook"] : "";
    $linkinstagram = (isset($_POST["linkinstagram"])) ? $_POST["linkinstagram"] : "";
    $linklinkedin = (isset($_POST["linklinkedin"])) ? $_POST["linklinkedin"] : "";
   
   //Proceso de actualización de foto
    $foto = (isset($_FILES["foto"]["name"])) ? $_FILES['foto']["name"] : "";
    $tmp_foto = $_FILES["foto"]["tmp_name"];

    if($foto != ""){
        $fecha_foto = new DateTime();
        $nombre_foto = $fecha_foto -> getTimestamp()."_".$foto;
        $ruta_foto = "../../../images/partners/".$nombre_foto;
        move_uploaded_file($tmp_foto,$ruta_foto);

        //Proceso de borrado que busque la imagen y la pueda borrar.
        $sentencia = $conexion ->  prepare("SELECT * FROM tbl_colaboradores WHERE ID = :id");
        $sentencia -> bindParam(":id", $txtID);
        $sentencia -> execute();

        $registro_foto = $sentencia -> fetch(PDO::FETCH_LAZY);

        //Borra el archivo de forma física.
        if(isset($registro_foto['foto'])){
            if(file_exists("../../../images/partners/".$registro_foto['foto'])){
                unlink("../../../images/partners/".$registro_foto['foto']);
            }
        }

        //Se realiza la actualización de la foto
        $sentencia = $conexion ->  prepare("UPDATE `tbl_colaboradores` 
        SET foto = :foto
        WHERE ID = :id;");

        $sentencia -> bindParam(":foto",$nombre_foto);
        $sentencia -> bindParam(":id",$txtID);
        $sentencia -> execute();
    }

    //Sentencia con la cual se actualizan los otros campos del colaborador
    $sentencia = $conexion ->  prepare("UPDATE `tbl_colaboradores` 
        SET 
        titulo = :titulo, 
        descripcion = :descripcion, 
        linkfacebook = :linkfacebook, 
        linkinstagram = :linkinstagram, 
        linklinkedin = :linklinkedin
        WHERE ID = :id");

    $sentencia -> bindParam(":titulo",$titulo);
    $sentencia -> bindParam(":descripcion",$descripcion);
    $sentencia -> bindParam(":linkfacebook",$linkfacebook);
    $sentencia -> bindParam(":linkinstagram",$linkinstagram);
    $sentencia -> bindParam(":linklinkedin",$linklinkedin);
    $sentencia -> bindParam(":id",$txtID);

    $sentencia -> execute();
    header("Location: index.php");
}


include("../../templates/header.php"); ?>

<br/>
<div class="card">
    <div class="card-header">Colaboradores</div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="txtID" class="form-label">ID:</label>
                <input type="text" class="form-control" value="<?php echo $txtID ?>"
                    name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID" />
            </div>
        
            <div class="mb-3">
                <label for="foto" class="form-label">Foto:</label><br/>
                <img src="../../../images/partners/<?php echo $foto ?>" width="70px" class="img-thumbnail"/>
                <input type="file" class="form-control" name="foto" id="foto" placeholder="" aria-describedby="fileHelpId"/>
            </div>
            
            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input type="text" class="form-control" value="<?php echo $titulo ?>"
                    name="titulo" id="titulo" aria-describedby="helpId" placeholder="Título"/>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <input type="text" class="form-control" value="<?php echo $descripcion ?>"
                    name="descripcion" id="descripcion" aria-describedby="helpId" placeholder="Descripción"/>
            </div>

            <div class="mb-3">
                <label for="linkfacebook" class="form-label">Facebook:</label>
                <input type="text" class="form-control" value="<?php echo $linkfacebook ?>"
                    name="linkfacebook" id="linkfacebook" aria-describedby="helpId" placeholder="Facebook"/>
            </div>

            <div class="mb-3">
                <label for="linkinstagram" class="form-label">Instagram:</label>
                <input type="text" class="form-control" value="<?php echo $linkinstagram ?>"
                    name="linkinstagram" id="linkinstagram" aria-describedby="helpId" placeholder="Instagram"/>
            </div>

            <div class="mb-3">
                <label for="linklinkedin" class="form-label">Linkedin:</label>
                <input type="text" class="form-control" value="<?php echo $linklinkedin ?>"
                    name="linklinkedin" id="linklinkedin" aria-describedby="helpId" placeholder="Linkedin"/>
            </div>
            
            <button type="submit" class="btn btn-success">Modificar Colaborador</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
    <div class="card-footer text-muted"></div>
</div>



<?php include("../../templates/footer.php"); ?>