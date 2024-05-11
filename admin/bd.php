<?php 

$servidor="localhost";
$baseDatos="restaurante";
$usuario="root";
$password="Sawada280390$";

try{
    $conexion = new PDO("mysql:host=$servidor;dbname=$baseDatos", $usuario, $password);
}catch(Exception $error){
    echo "Error de conexion".$error->getMessage();
}

?>