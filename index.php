<?php

include("admin/bd.php");

//Consulta de banners por medio del ID y mostrarlos en la página principal
$sentencia = $conexion -> prepare("SELECT * FROM tbl_banners ORDER BY ID ASC limit 1 "); 
$sentencia -> execute();
$lista_banners = $sentencia -> fetchAll(PDO::FETCH_ASSOC);

//Consulta de colaboradores por medio del ID y mostrarlos en la página principal
$sentencia = $conexion -> prepare("SELECT * FROM tbl_colaboradores ORDER BY ID ASC limit 3 "); 
$sentencia -> execute();
$lista_colaboradores = $sentencia -> fetchAll(PDO::FETCH_ASSOC);

//Consulta de testimonios por medio del ID y mostrarlos en la página principal
$sentencia = $conexion -> prepare("SELECT * FROM tbl_testimonios ORDER BY ID DESC limit 2 "); 
$sentencia -> execute();
$lista_testimonios = $sentencia -> fetchAll(PDO::FETCH_ASSOC);

//Consulta de menús por medio del ID y mostrarlos en la página principal
$sentencia = $conexion -> prepare("SELECT * FROM tbl_menu ORDER BY ID DESC limit 4 "); 
$sentencia -> execute();
$lista_menu = $sentencia -> fetchAll(PDO::FETCH_ASSOC);

//Proceso de registro de los comentarios
if($_POST){
    
    $nombre = filter_var($_POST["nombre"], FILTER_SANITIZE_STRING);
    $correo = filter_var($_POST["correo"], FILTER_SANITIZE_EMAIL);
    $mensaje = filter_var($_POST["mensaje"], FILTER_SANITIZE_STRING);

    if($nombre && $correo && $mensaje){
        $sql = "INSERT INTO tbl_comentarios (nombre, correo, mensaje) 
        VALUES (:nombre, :correo, :mensaje)";
        $sentencia = $conexion -> prepare($sql);
        $sentencia -> bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $sentencia -> bindParam(":correo", $correo, PDO::PARAM_STR);
        $sentencia -> bindParam(":mensaje", $mensaje, PDO::PARAM_STR);
        $sentencia -> execute();
    }
    header("Location: index.php");
}

?>

<!doctype html>
<html lang="en">
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />

        <link 
        rel="stylesheet" 
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" 
        crossorigin="anonymus" 
        referrerpolicy="no-referrer" />

    </head>

    <body>
        
        <!-- Sección del menú de navegación -->
        <nav id="inicio" class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">

                <a class="navbar-brand" href="#"> <i class="fas fa-utensils"></i> Restaurante La Sombra </a>
                
                <button class="navbar-toggler" type:"button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#inicio">Incio</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#menu">Menú del día</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#chefs">Chefs</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#testimonios">Testimonio</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#contacto">Contacto</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#horarios">Horarios</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <!-- Sección del Banner -->
        <section id="banner" class="container-fluid p-0">
            <div class="banner.img" style="position:relative; 
            background:url('images/slider-image1.jpg') center/cover no-repeat; 
            height:400px;">
                <div class="banner-text" style="position:absolute; 
                top:50%; left:50%; transform: translate(-50%, -50%); 
                text-align:center; color:#fff;">
                    <?php foreach($lista_banners as $banner){ ?>
                        <h1><?php echo $banner['titulo'] ?></h1>
                        <p><?php echo $banner['descripcion'] ?></p>
                        <a href="<?php echo $banner['link'] ?>" class="btn btn-primary">Ver Menú</a>
                    <?php } ?>
                </div>

            </div>
        </section>

        <section id="id" class="container mt-4 text-center">
            <div class="jumbotron bg-dark text-white">
                <br/>
                <h2> ¡Bienvenid@ al Restaurant La Sombra! </h2>
                <p> Descrubre una experiencia culinaría única </p>
                <br/>   
        </section>

        <!-- Sección de Chefs -->
        <section id="chefs" class="container mt-4 text-center">
            <h2>Nuestros Chefs</h2>
            <div class="row">
                <?php foreach($lista_colaboradores as $chef){ ?>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="images/partners/<?php  echo $chef['foto']; ?>" 
                            alt="Chef 1" 
                            class="card-img-top"/>
                            <div class="card-body">
                                <h5 class="card-title"> <?php  echo $chef['titulo']; ?> </h5>
                                <p class="card-text"> <?php  echo $chef['descripcion']; ?> </p>
                                <div class="social-icons mt-3">
                                    <a href="<?php  echo $chef['linkfacebook']; ?>" class="text-dark me-2"><i class="fab fa-facebook"></i></a>
                                    <a href="<?php  echo $chef['linkinstagram']; ?>" class="text-dark me-2"><i class="fab fa-instagram"></i></a>
                                    <a href="<?php  echo $chef['linklinkedin']; ?>" class="text-dark me-2"><i class="fab fa-linkedin"></i></a>
                                </div>
                            </div>                      
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>

        <!-- Sección de Testimonios -->
        <section id="testimonios" class="bg-light py-5">
            <div class="container">
                <h2 class="text-center mb-4">Testimonios</h2>
                <div class="row">
                    <?php foreach($lista_testimonios as $testimonio) { ?>
                        <div class="col-md-6 d-flex">
                            <div class="card mb-4 w-100">
                                <div class="card-body">
                                    <p class="card-text"> <?php  echo $testimonio['opinion']; ?> </p>
                                </div>
                                <div class="card-footer text-muted">
                                    <?php  echo $testimonio['nombre']; ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

        </section>

        <!-- Sección de Menú de Comidas -->
        <section id="menu" class="container mt-4">
            <h2 class="text-center"> Menú (nuestra recomendación) </h2>
            <br/>
            <div class="row row-cols-1 row-cols-md-4 g-4">
                <?php foreach($lista_menu as $menu) { ?>
                    <div class="col d-flex">
                        <div class="card">
                            <img src="images/menu/<?php echo $menu['foto']; ?>" class="card-img-top" alt="">
                            <div class="card-body">
                                <h5 class="card-title"> <?php echo $menu['nombre']; ?> </h5>
                                <p class="card-text small"> <strong> Ingredientes: </strong> <?php echo $menu['ingredientes']; ?> </p>
                                <p class="card-text"> <strong> Precio: </strong> $<?php echo $menu['precio']; ?> </p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>
        <br/><br/>

        <!-- Sección de Contactos -->
        <section id="contacto" class="container mt-4">
            <h2> Contacto </h2>
            <p> Estamos aquí para servirle. </p>

            <form action="?" method="post">
                <div class="mb-3">
                    <label for="name"> Nombre: </label><br/>
                    <input type="text" class="form-control" name="nombre" id="name" placeholder="Escribe tu nombre..." Required><br/>
                </div>
                
                <div class="mb-3">
                    <label for="email"> Correo electrónico </label><br/>
                    <input type="email" class="form-control" name="correo" id="email" 
                    placeholder="Escribe tu correo electrónico..." Required><br/>
                </div>
                
                <div class="mb-3">
                    <label for="mensaje"> Mensaje: </label><br/>
                    <textarea class="form-control" name="mensaje" id="mensaje" rows="6" cols="50"></textarea><br/>
                </div>

                <input type="submit" class="btn btn-primary" value="Enviar mensaje">
            </form>
        </section>
        <br/><br/>
        
        
        <!-- Sección de Horarios -->
        <div id="horarios" class="text-center bg-light p-4">
            <h3 class="mb-4"> Horario de atención. </h3>
            <div>
                <p> <strong> Lunes a Viernes </strong> </p>
                <p> <strong> 11:00 a.m. - 10:00 p.m. </strong> </p>
                <p> <strong> Sábado </strong> </p>
                <p> <strong> 12:00 p.m. - 5:00 p.m. </strong> </p>
                <p> <strong> Domingo </strong> </p>
                <p> <strong> 7:00 a.m. - 2:00 p.m. </strong> </p>
            </div>
        </div>
       
        
        <footer class="bg-dark text-light text-center py-3">
            <!-- place footer here -->
            <p> &copy; 2024 Restaurante La Sombra, 
                todos los derechos reservados. </p>
        </footer>
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    
    
    
    
    </body>
</html>
