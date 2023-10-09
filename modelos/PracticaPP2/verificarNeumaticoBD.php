<?php
require_once "../PracticaPP2/Clases/NeumaticoBD.php";

if(isset($_POST["obj_neumatico"]))
{
    $marca = $_POST["obj_neumatico"]["marca"];
    $medidas = $_POST["obj_neumatico"]["medidas"];

    $neumatico = new NeumaticoBD(null, null, $marca, $medidas, 1000);

    if($neumatico->existe(NeumaticoBD::traer()))
    {
        echo $neumatico->toJson();
    }
    else
    {
        echo "{}";
    }

}
else
{
    echo "Error al verificar el neumático.";
}