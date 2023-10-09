<?php
require_once "../Backend/Clases/Empleado.php";

if(isset($_POST["id"]))
{
    $id = $_POST["id"];

    $retorno = Empleado::Eliminar($id);

    if($retorno)
    {
        $retorno = array(
            "exito" => true,
            "mensaje" => "Empleado eliminado con éxito."
        );
    }
    else
    {
        $retorno = array(
            "exito" => false,
            "mensaje" => "Error al eliminar el empleado."
        );
    }

    echo json_encode($retorno);
}
else
{
    $retorno = array(
        "exito" => false,
        "mensaje" => "Error al eliminar el empleado."
    );

    echo json_encode($retorno);
}

?>