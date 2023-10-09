<?php

require_once "alumno.php";

use Barrio\Alumno;

session_start();

if(isset($_SESSION["legajo"], $_SESSION["apellido"], $_SESSION["nombre"], $_SESSION["foto"]))
{
    $legajo = $_SESSION["legajo"];
    $apellido = $_SESSION["apellido"];
    $nombre = $_SESSION["nombre"];
    $foto = $_SESSION["foto"];

    $mostrarStr = "";
    $mostrarStr = "<h1>Legajo: $legajo</h1>";
    $mostrarStr .= "<h2>Nombre y Apellido: $nombre $apellido</h2>";
    $mostrarStr .= "<img src='$foto'>";
    $mostrarStr .= "<br>" . Alumno::ListarTabla("../misArchivos/alumnos_foto.txt");

    echo $mostrarStr;
}
else
{
    session_unset();
    session_destroy();
    header("Location: nexo_poo_foto.php");
    exit();
}