<?php

require_once "../Backend/Clases/Usuario.php";

//funciona
if(isset($_POST["correo"], $_POST["clave"], $_POST["nombre"]))
{
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];
    $nombre = $_POST["nombre"];
    $id_perfil = $_POST["id_perfil"];

    $usuario = new Usuario(null, $nombre, $correo, $clave, $id_perfil, null);

    $exito = $usuario->Agregar();

    $retorno = array("exito" => $exito,
    "mensaje" => $exito ? "Usuario agregado con éxito." : "Error al agregar el usuario.");
    //header('Content-Type: application/json');
    echo json_encode($retorno);
}
else
{
    $retorno = array("exito" => false,
    "mensaje" => "Error al agregar el usuario.");
    echo json_encode($retorno);
}

?>