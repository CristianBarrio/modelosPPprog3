<?php
require_once "../Backend/Clases/Empleado.php";

//funciona
if(isset($_POST["empleado_json"]))
{
    $datos = json_decode($_POST["empleado_json"], true);
    $id = $datos["id"];
    $correo = $datos["correo"];
    $clave = $datos["clave"];
    $nombre = $datos["nombre"];
    $id_perfil = $datos["id_perfil"];
    $pathFoto = $datos["path_foto"];
    $sueldo = $datos["sueldo"];

    $empleado = new Empleado($id, $nombre, $correo, $clave, $id_perfil, $pathFoto, $sueldo);

    if(isset($_FILES["foto"]) && move_uploaded_file($_FILES["foto"]["tmp_name"], "../Backend/Empleados/Fotos/" . "." . $nombre . "." . date("His") . ".jpg"))
    {
        $exito = $empleado->Modificar();
        $retorno = array("exito" => $exito,
                        "mensaje" => $exito ? "Empleado modificado con éxito." : "Error al modificar el usuario.");

        echo json_encode($retorno);
    }
    else
    {
        $exito = $empleado->Modificar();
        $retorno = array("exito" => $exito,
                        "mensaje" => $exito ? "Empleado modificado con éxito." : "Error al modificar el usuario.");
    
        echo json_encode($retorno);
    }

}
else
{
    $retorno = array("exito" => false,
                    "mensaje" => "Error al modificar el usuario.");

    echo json_encode($retorno);
}

?>