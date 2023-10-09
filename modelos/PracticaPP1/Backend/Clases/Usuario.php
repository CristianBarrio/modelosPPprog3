<?php
require_once "../Backend/Clases/IBM.php";
class Usuario implements IBM
{
    public $id;
    public string $nombre;
    public string $correo;
    public string $clave;
    public $id_perfil;
    //public $perfil;

    public function __construct($id, $nombre, $correo, $clave, $id_perfil)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->clave = $clave;
        $this->id_perfil = $id_perfil;
        //$this->perfil = $perfil;
    }

    public function ToJson()
    {
        $datosUsuario = array("id" => $this->id,
                                "correo" => $this->correo,
                                "clave" => $this->clave,
                                "nombre" => $this->nombre,
                                "id_perfil" => $this->id_perfil);

        return json_encode($datosUsuario);
    }

    //funciona
    public function GuardarEnArchivo()
    {
        $path = "../Backend/Archivos/usuarios.json";

        $usuariosObtenidos = [];
        $retorno = [];
        if (file_exists($path)) {
            $usuariosObtenidos = json_decode(file_get_contents($path), true);
        }

        $usuarioNuevo = $this->ToJson(); 
        $usuariosObtenidos[] = json_decode($usuarioNuevo, true); 
        $usuariosJson = json_encode($usuariosObtenidos);

        if (file_put_contents($path, $usuariosJson)) 
        {
            $retorno = array(
                "exito" => true,
                "mensaje" => "Usuario agregado con éxito."
            );
        } else 
        {
            $retorno = array(
                "exito" => false,
                "mensaje" => "Error al agregar el usuario."
            );        
        }

        return json_encode($retorno);
    }

    //funciona
    public static function TraerTodosJson()
    {
        $path = "../Backend/Archivos/usuarios.json";

        $usuarios_obtenidos = [];
        $retorno = array();
        if (file_exists($path))
        {
            $usuarios_obtenidos = json_decode((file_get_contents($path)), true);
            foreach ($usuarios_obtenidos as $usuarioData) 
            {
                $usuario = new Usuario($usuarioData["id"], $usuarioData["nombre"], $usuarioData["correo"], $usuarioData["clave"], $usuarioData["id_perfil"]);
                $retorno[] = $usuario;
            }
        }
        
        return $retorno;
    }

    //funciona
    public function Agregar():bool
    {
        $retorno = false;

        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root", "");
            
            $sql = $pdo->prepare("INSERT INTO `usuarios`(`correo`, `clave`, `nombre`, `id_perfil`) VALUES (:correo, :clave, :nombre, :id_perfil)");
            $sql->bindParam(":correo", $this->correo, PDO::PARAM_STR, 50);
            $sql->bindParam(":clave", $this->clave, PDO::PARAM_STR, 8);
            $sql->bindParam(":nombre", $this->nombre, PDO::PARAM_STR, 30);
            $sql->bindParam(":id_perfil", $this->id_perfil, PDO::PARAM_INT);
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

    //funciona
    public static function TraerTodos()
    {
        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root", "");
            
            $sql = $pdo->prepare("SELECT u.id, u.nombre, u.correo, p.descripcion AS perfil FROM usuarios u
            JOIN perfiles p ON u.id_perfil = p.id");
            $usuarios = array();

            if($sql->execute())
            {
                while($res = $sql->fetchObject())
                {
                    $usuarios[] = $res;
                }

                return $usuarios;               
            }
        }
        catch(PDOException $e)
        {
            return $usuarios;
        }

        return $usuarios;
    }

    //funciona  
    public static function TraerUno($params)
    {
        $datos = json_decode($params, true);

        if($datos && isset($datos["correo"], $datos["clave"]))
        {
            $correo = $datos["correo"];
            $clave = $datos["clave"];
            
            try
            {
                $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root", "");
                
                $sql = $pdo->prepare("SELECT * FROM `usuarios` WHERE correo = :correo AND clave = :clave");
                $sql->bindParam(":correo", $correo, PDO::PARAM_STR, 50);
                $sql->bindParam(":clave", $clave, PDO::PARAM_STR, 8);
    
                if($sql->execute())
                {
                    if($sql->rowCount() > 0)
                    {
                        return $sql->fetchObject();
                    }
                }
                else 
                {
                    return null;
                }
            }
            catch(PDOException)
            {
                return null;
            }
        }
        else
        {
            return null;
        }
    }

    //funciona
    public function Modificar()
    {
        $retorno = false;
        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root", "");
            
            $sql = $pdo->prepare("UPDATE `usuarios` SET correo = :correo, clave = :clave, nombre = :nombre, id_perfil = :id_perfil WHERE id = :id");
            $sql->bindParam(":id", $this->id, PDO::PARAM_INT);
            $sql->bindParam(":correo", $this->correo, PDO::PARAM_STR, 50);
            $sql->bindParam(":clave", $this->clave, PDO::PARAM_STR, 8);
            $sql->bindParam(":nombre", $this->nombre, PDO::PARAM_STR, 30);
            $sql->bindParam(":id_perfil", $this->id_perfil, PDO::PARAM_INT);

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
            
            $sql = $pdo->prepare("DELETE FROM `usuarios` WHERE id = :id");
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