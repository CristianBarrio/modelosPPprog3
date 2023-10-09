<?php
require_once "../Clases/NeumaticoBD.php";

if(isset($_POST["marca"], $_POST["medidas"], $_POST["precio"], $_FILES["foto"]))
{
    $marca = $_POST["marca"];
    $medidas = $_POST["medidas"];
    $precio = $_POST["precio"];
    $foto = $_FILES["foto"];

    $pathFoto = "./Imagenes/" . $marca . "." . date("His") . ".jpg";
    $neumatico = new NeumaticoBD(null, $pathFoto, $marca,$medidas,$precio);

    if(!$neumatico->existe(NeumaticoBD::traer()))
    {
        $exito = $neumatico->agregar();
        move_uploaded_file($foto, $pathFoto);
        $retorno = array("exito" => $exito,
        "mensaje" => $exito ? "Neumatico agregado con éxito." : "Error al agregar el neumatico.");    
    }
    else
    {
        $retorno = array("exito" => false,
                        "mensaje" => "El neumático ya existe.");
    }


    echo json_encode($retorno);
}
else
{
    $retorno = array("exito" => false,
    "mensaje" => "Error al agregar el neumatico.");
    echo json_encode($retorno);
}