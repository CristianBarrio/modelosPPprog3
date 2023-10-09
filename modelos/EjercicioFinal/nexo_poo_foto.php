<?php

require_once "alumno.php";

use Barrio\Alumno;

$path = "../misArchivos/alumnos_foto.txt";

if(isset($_POST["accion"], $_POST["legajo"], $_POST["apellido"], $_POST["nombre"], $_FILES["foto"]) 
&& ($_POST["accion"] === "agregar" || $_POST["accion"] === "modificar"))
{
    $legajo = $_POST["legajo"];
    $apellido = $_POST["apellido"];
    $nombre = $_POST["nombre"];
    $nombreTemporal = $_FILES["foto"]["tmp_name"];
    
    $pathFoto = "../Fotos/" . $legajo . ".webp";

    $alumno = new Alumno($legajo, $apellido, $nombre, $pathFoto);

    if($_POST["accion"] === "agregar")
    {
        if(move_uploaded_file($nombreTemporal, $pathFoto))
        {
            //$alumno->AgregarAlumno($path);
            echo $alumno->AgregarAlumno($path);
        }
    }
    else if($_POST["accion"] === "modificar")
    {
        if(move_uploaded_file($nombreTemporal, $pathFoto))
        {
            echo $alumno->ModificarAlumno($path, $legajo);
        }
    }
    else
    {
        echo "Error al realizar la petición.<br>";
    }
}
else if(isset($_POST["accion"], $_POST["legajo"]) && ($_POST["accion"] === "verificar" || $_POST["accion"] === "borrar" || $_POST["accion"] === "obtener"))
{
    $legajo = $_POST["legajo"];

    if($_POST["accion"] === "verificar")
    {
        if(Alumno::BuscarPorLegajo($path, $legajo))
        {
            $alumno = Alumno::Redirigir($path, $legajo);

            if(!Alumno::Redirigir($path, $legajo))
            {
                echo "Error al redirigir al alumno.<br>";
            }
        }
        else
        {
            echo "El alumno con legajo " . $legajo . " no se encuentra en el listado.<br>";
        }
    }
    else if($_POST["accion"] === "borrar")
    {
        echo Alumno::EliminarAlumno($path, $legajo);
    }
    else if($_POST["accion"] === "obtener")
    {
        $resultadoObtenido = Alumno::ObtenerAlumno($path, $legajo);

        //if(gettype($resultadoObtenido) === "string")
        //{
            echo $resultadoObtenido;
        /*}else
        {
            $arrayAlumno = explode(" - ", trim($resultadoObtenido, '\n'));
            var_dump($arrayAlumno);
        }*/
    }
    else
    {
        echo "Error al realizar la petición.<br>";
    }

}
else if(isset($_POST["accion"]) && ($_POST["accion"] === "listar_objetos" || $_POST["accion"] === "listar_tabla"))
{
    if($_POST["accion"] === "listar_objetos")
    {
        echo Alumno::ListarObjetos($path);
    }
    else if($_POST["accion"] === "listar_tabla")
    {
        echo Alumno::ListarTabla($path);
    }
    else
    {
        echo "Error al realizar la petición.<br>";
    }
}
else if(isset($_GET["accion"]) && ($_GET["accion"] === "listar" || $_GET["accion"] === "listar_pdf"))
{
    if($_GET["accion"] === "listar")
    {
        echo Alumno::ListarAlumnos($path);
    }
    else if($_GET["accion"] === "listar_pdf")
    {
        
    }
}
else
{
    echo "Error.<br>";
}
