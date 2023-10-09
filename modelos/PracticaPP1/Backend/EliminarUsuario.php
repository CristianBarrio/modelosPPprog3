<?php
require_once "../Backend/Clases/Usuario.php";

//funciona
if(isset($_POST["id"], $_POST["accion"]) && $_POST["accion"] === "borrar")
{
    $id = $_POST["id"];

    $retorno = Usuario::Eliminar($id);

    if($retorno)
    {
        $retorno = array(
            "exito" => true,
            "mensaje" => "Usuario eliminado con éxito."
        );
    }
    else
    {
        $retorno = array(
            "exito" => false,
            "mensaje" => "Error al eliminar el usuario."
        );
    }

    echo json_encode($retorno);
}
else
{
    $retorno = array(
        "exito" => false,
        "mensaje" => "Error al eliminar el usuario."
    );

    echo json_encode($retorno);
}

?>