<?php

require_once "../Backend/Clases/Usuario.php";

//funciona, requiere cambios
if(isset($_POST["correo"], $_POST["clave"], $_POST["nombre"]))
{
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];
    $nombre = $_POST["nombre"];
    
    $usuario = new Usuario(null, $nombre, $correo, $clave, null, null);

    echo $usuario->GuardarEnArchivo();
}
else
{
    echo "Error al guardar el usuario.";
}

?>