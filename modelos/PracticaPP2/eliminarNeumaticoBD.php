<?php
require_once "../PracticaPP2/Clases/NeumaticoBD.php";

if(isset($_POST["neumatico_json"]))
{
    $id = $_POST["neumatico_json"]["id"];
    $marca = $_POST["neumatico_json"]["marca"];
    $medidas = $_POST["neumatico_json"]["medidas"];
    $precio = $_POST["neumatico_json"]["precio"];

    $neumatico = new NeumaticoBD($id, null, $marca, $medidas, $precio);

    $exito = NeumaticoBD::eliminar($id);

    if($exito)
    {
        $neumatico->guardarJSON("../PracticaPP2/Archivos/neumaticos_eliminados.json");
    }
    
    $retorno = array(
        "exito" => $exito,
        "mensaje" => $exito ? "Neumatico eliminado con éxito." : "Error al eliminar el neumático."
    );

    echo json_encode($retorno);
}
else
{
    $retorno = array(
        "exito" => false,
        "mensaje" => "Error al eliminar el neumático."
    );

    echo json_encode($retorno);
}