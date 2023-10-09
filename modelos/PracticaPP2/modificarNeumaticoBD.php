<?php
require_once "../PracticaPP2/Clases/NeumaticoBD.php";

if(isset($_POST["neumatico_json"]))
{
    $id = $_POST["neumatico_json"]["id"];
    $marca = $_POST["neumatico_json"]["marca"];
    $medidas = $_POST["neumatico_json"]["medidas"];
    $precio = $_POST["neumatico_json"]["precio"];

    $neumatico = new NeumaticoBD($id, null, $marca, $medidas, $precio);

    $exito = $neumatico->modificar();
    
    $retorno = array(
        "exito" => $exito,
        "mensaje" => $exito ? "Neumatico modificado con éxito." : "Error al modificar el neumático."
    );

    echo json_encode($retorno);
}
else
{
    $retorno = array(
        "exito" => false,
        "mensaje" => "Error al modificar el neumático."
    );

    echo json_encode($retorno);
}