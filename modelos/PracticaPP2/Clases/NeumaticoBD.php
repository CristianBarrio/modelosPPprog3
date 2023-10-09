<?php
require_once ('Neumatico');
require_once ('IParte1');
require_once ('IParte2');

class NeumaticoBD extends Neumatico implements IParte1, IParte2, IParte3
{
    protected int $id;
    protected string $pathFoto;

    public function __construct($id = null, $pathFoto = null, $marca, $medidas, $precio)
    {   
        parent::__construct($marca,$medidas, $precio);
        $this->id = $id;
        $this->pathFoto = $pathFoto;
    }

    public function ToJson()
    {
        return ["id" => $this->id,
                "pathFoto" => $this->pathFoto];
    }

    public function agregar()
    {
        $retorno = false;

        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=gomeria_bd", "root", "");
            
            $sql = $pdo->prepare("INSERT INTO `neumaticos`(`marca`, `medidas`, `precio`, `foto`) VALUES (:marca, :medidas, :precio, :foto)");
            $sql->bindParam(":marca", $this->marca, PDO::PARAM_STR, 50);
            $sql->bindParam(":medidas", $this->medidas, PDO::PARAM_STR, 50);
            $sql->bindParam(":precio", $this->precio, PDO::PARAM_INT);
            $sql->bindParam(":foto", $this->pathFoto, PDO::PARAM_STR, 500);
            if($sql->execute())
            {
                $retorno = true;
            }
        }
        catch(PDOException)
        {
            $retorno = false;
        }

        return $retorno;
    }

    public static function traer()
    {
        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=gomeria_bd", "root", "");
            
            $sql = $pdo->prepare("SELECT * FROM `neumaticos` WHERE 1");
            $neumaticos = array();

            if($sql->execute())
            {
                while($res = $sql->fetchObject())
                {
                    $neumaticos[] = $res;
                }

                return $neumaticos;               
            }
        }
        catch(PDOException)
        {
            return $neumaticos;
        }

        return $neumaticos;
    }

    public static function eliminar($id)
    {
        $retorno = false;
        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=gomeria_bd", "root", "");
            
            $sql = $pdo->prepare("DELETE FROM `neumaticos` WHERE id = :id");
            $sql->bindParam(":id", $id, PDO::PARAM_INT);
            if($sql->execute())
            {
                $retorno = true;
                return $retorno;
            }
            else
            {
                return $retorno;
            }
        }
        catch(PDOException)
        {
            return $retorno;
        }
    }

    public function modificar()
    {
        $retorno = false;
        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=gomeria_bd", "root", "");
            
            $sql = $pdo->prepare("UPDATE `neumaticos` SET marca = :marca, medidas = :medidas, precio = :precio, foto = :foto WHERE id = :id");
            $sql->bindParam(":id", $this->id, PDO::PARAM_INT);
            $sql->bindParam(":marca", $this->marca, PDO::PARAM_STR, 50);
            $sql->bindParam(":medidas", $this->medidas, PDO::PARAM_STR, 50);
            $sql->bindParam(":precio", $this->precio, PDO::PARAM_INT);
            $sql->bindParam(":foto", $this->pathFoto, PDO::PARAM_STR, 500);

            if($sql->execute())
            {
                $retorno = true;
                return $retorno;
            }
            else
            {
                return $retorno;
            }
        }
        catch(PDOException)
        {
            return $retorno;
        }
    }

    public function existe($neumaticos)
    {
        $retorno = false;
        
        foreach($neumaticos as $neumatico)
        {
            if($neumatico->marca === $this->marca && $neumatico->medidas === $this->medidas)
            {
                $retorno = true;
            }
        }

        return $retorno;
    }

    public function guardarEnArchivo()
    {
        
    }

    public static function mostrarBorradosJSON()
    {

    }

    public static function mostrarModificados()
    {
        
    }
}