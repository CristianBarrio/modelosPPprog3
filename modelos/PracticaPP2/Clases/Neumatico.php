<?php
class Neumatico
{
    protected string $marca;
    protected string $medidas;
    protected float $precio;

    public function __construct($marca, $medidas, $precio)
    {
        $this->marca = $marca;
        $this->medidas = $medidas;
        $this->precio = $precio;
    }

    public function toJson()
    {
        $datos = array("marca" => $this->marca,
                        "medidas" => $this->medidas,
                        "precio" => $this->precio);
        return json_encode($datos);
    }

    public function guardarJSON($path)
    {
        $neumaticosObtenidos = [];
        $retorno = [];
        if (file_exists($path)) {
            $neumaticosObtenidos = json_decode(file_get_contents($path), true);
        }

        $neumaticoNuevo = $this->toJson(); 
        $neumaticosObtenidos[] = json_decode($neumaticoNuevo, true); 
        $neumaticosJson = json_encode($neumaticosObtenidos);

        if (file_put_contents($path, $neumaticosJson)) 
        {
            $retorno = array(
                "exito" => true,
                "mensaje" => "Neumático agregado con éxito."
            );
        } 
        else 
        {
            $retorno = array(
                "exito" => false,
                "mensaje" => "Error al agregar el neumático."
            );        
        }

        return json_encode($retorno);
    }

    //retornar array de objetos
    public static function traerJSON($path)
    {
        if(file_exists($path))
        {
            $usuariosStr = file_get_contents($path);
            //$usuariosArray[] = explode(",",$usuariosStr);
            //$arrayJson = array();
            /*oreach($usuariosArray as $usuario)
            {
                $arrayJson[] = json_encode($usuario);
            }*/
            return $usuariosStr;

        }else
        {
            return "El archivo no existe.";
        }

        return "Error.";
    }

    public static function verificarNeumaticoJSON($neumatico)
    {

    }
}