<?php

require_once "../Backend/Clases/Usuario.php";
//corregir el alta de archivo json 
//$usuarios[] =  Usuario::TraerTodosJson();
$usuario =  Usuario::TraerTodosJson();
//foreach($usuarios as $usuario)
//{
    echo json_encode($usuario) . "\n";
//}

?>