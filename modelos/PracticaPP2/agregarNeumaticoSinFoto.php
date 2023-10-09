<?php

require_once "../Clases/NeumaticoBD.php";

if(isset($_POST["neumatico_json"]))
{
    $marca = $_POST["neumatico_json"]["marca"];
    $medidas = $_POST["neumatico_json"]["medidas"];
    $precio = $_POST["neumatico_json"]["precio"];

    $neumatico = new NeumaticoBD(null, null, $marca,$medidas,$precio);

    $exito = $neumatico->agregar();

    $retorno = array("exito" => $exito,
    "mensaje" => $exito ? "neumatico agregado con éxito." : "Error al agregar el neumatico.");

    echo json_encode($retorno);
}
else
{
    $retorno = array("exito" => false,
    "mensaje" => "Error al agregar el neumatico.");
    echo json_encode($retorno);
}