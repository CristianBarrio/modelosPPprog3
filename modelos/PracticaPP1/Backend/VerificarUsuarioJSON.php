<?php

require_once "../Backend/Clases/Usuario.php";

//funciona
if(isset($_POST["usuario_json"]))
{
    $retorno = Usuario::TraerUno($_POST["usuario_json"]);

    if($retorno !== null)
    {
        $retorno = array(
            "exito" => true,
            "mensaje" => "El usuario se encuentra en la base de datos."
        );
    }
    else
    {
        $retorno = array(
            "exito" => false,
            "mensaje" => "El usuario no se encuentra en la base de datos."
        );
    }

    echo json_encode($retorno);
}
else
{
    $retorno = array(
        "exito" => false,
        "mensaje" => "Error al verificar el usuario."
    );

    echo json_encode($retorno);
}

?>