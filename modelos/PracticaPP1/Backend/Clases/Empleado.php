<?php
require_once ('Usuario.php');
require_once ('ICRUD.php');

class Empleado extends Usuario implements ICRUD
{
    public string $foto;
    public int $sueldo;

    public function __construct($id, $nombre, $correo, $clave, $id_perfil, $foto, $sueldo)
    {
        parent::__construct($id, $nombre, $correo, $clave, $id_perfil);
        $this->foto = $foto;
        $this->sueldo = $sueldo;
    }

    //funciona, no se muestra foto
    public static function TraerTodos()
    {
        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root", "");
            
            $sql = $pdo->prepare("SELECT e.id, e.nombre, e.correo, e.foto, e.sueldo, p.descripcion AS perfil FROM empleados e
            JOIN perfiles p ON e.id_perfil = p.id");
            $empleados = array();

            if($sql->execute())
            {
                while($res = $sql->fetchObject())
                {
                    $empleados[] = $res;
                }
                
            }
        }
        catch(PDOException)
        {
            return $empleados;
        }

        return $empleados;
    }

    //funciona, sale feo el path
    public function Agregar():bool
    {
        $retorno = false;

        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root", "");
            
            $sql = $pdo->prepare("INSERT INTO `empleados`(`correo`, `clave`, `nombre`, `id_perfil`, `foto`, `sueldo`) VALUES (:correo, :clave, :nombre, :id_perfil, :foto, :sueldo)");
            $sql->bindParam(":correo", $this->correo, PDO::PARAM_STR, 50);
            $sql->bindParam(":clave", $this->clave, PDO::PARAM_STR, 8);
            $sql->bindParam(":nombre", $this->nombre, PDO::PARAM_STR, 30);
            $sql->bindParam(":id_perfil", $this->id_perfil, PDO::PARAM_INT);
            $sql->bindParam(":foto", $this->foto, PDO::PARAM_STR, 500);
            $sql->bindParam(":sueldo", $this->sueldo, PDO::PARAM_INT);
            $pathFoto = "../Backend/Empleados/Fotos/" . $this->nombre . "." . date("His") . ".jpg";

            if($sql->execute())
            {
                if(move_uploaded_file($this->foto, $pathFoto))
                {
                    $retorno = true;
                }
            }
        }
        catch(PDOException)
        {
            $retorno = false;
        }

        return $retorno;
    }

    //funciona
    public function Modificar()
    {
        $retorno = false;
        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root", "");
            
            $sql = $pdo->prepare("UPDATE `empleados` SET correo = :correo, clave = :clave, nombre = :nombre, id_perfil = :id_perfil, foto = :foto, sueldo = :sueldo WHERE id = :id");
            $sql->bindParam(":id", $this->id, PDO::PARAM_INT);
            $sql->bindParam(":correo", $this->correo, PDO::PARAM_STR, 50);
            $sql->bindParam(":clave", $this->clave, PDO::PARAM_STR, 8);
            $sql->bindParam(":nombre", $this->nombre, PDO::PARAM_STR, 30);
            $sql->bindParam(":id_perfil", $this->id_perfil, PDO::PARAM_INT);
            $sql->bindParam(":foto", $this->foto, PDO::PARAM_STR, 500);
            $sql->bindParam(":sueldo", $this->sueldo, PDO::PARAM_INT);

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

    //funciona
    public static function Eliminar($id)
    {
        $retorno = false;
        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root", "");
            
            $sql = $pdo->prepare("DELETE FROM `empleados` WHERE id = :id");
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
}
?>