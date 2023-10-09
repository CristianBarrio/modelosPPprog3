<?php
require_once "../Backend/Clases/Usuario.php";

if(isset($_POST["usuario_json"]))
{
    $datos = json_decode($_POST["usuario_json"], true);
    $id = $datos["id"];
    $correo = $datos["correo"];
    $clave = $datos["clave"];
    $nombre = $datos["nombre"];
    $id_perfil = $datos["id_perfil"];

    $usuario = new Usuario($id, $nombre, $correo, $clave, $id_perfil);

    $retorno = $usuario->Modificar();

    if($retorno)
    {
        $retorno = array(
            "exito" => true,
            "mensaje" => "Usuario modificado con éxito."
        );
    }
    else
    {
        $retorno = array(
            "exito" => false,
            "mensaje" => "Error al modificar el usuario."
        );
    }

    echo json_encode($retorno);
}
else
{
    $retorno = array(
        "exito" => false,
        "mensaje" => "Error al modificar el usuario."
    );

    echo json_encode($retorno);
}

?>