<?php

$opcion = $_POST["opcion"];

switch($opcion)
{
    case "conexion":

        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=mi_base", "root", "");
            echo "Conexión exitosa.";
        }
        catch(PDOException $e)
        {
            echo "Error:" . $e->getMessage() . "<br/>";
        }

        break;
    case "listar_fetchAll":
        
        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=mi_base", "root", "");
            
            $sql = $pdo->query("SELECT * FROM `mi_tabla`");

            if($sql != false)
            {
                $res = $sql->fetchAll();
                foreach($res as $value)
                {
                    echo $value[0] . " - " . $value[1] . " - " . $value[2] . "\n";
                }
            }
            else 
            {
                echo "Error.";
            }
        }
        catch(PDOException $e)
        {
            echo "Error:" . $e->getMessage() . "<br/>";
        }

        break;
    case "listar_fetchObject":  
        try
        {
            require_once "./mi_tabla.php";
            $pdo = new PDO("mysql:host=localhost;dbname=mi_base", "root", "");
            
            $sql = $pdo->query("SELECT * FROM `mi_tabla` WHERE 1");

            if($sql != false)
            {
                while($res = $sql->fetchObject("mi_tabla"))
                {
                    echo $res->toString();
                }
                
            }
            else 
            {
                echo "Error.";
            }
        }
        catch(PDOException $e)
        {
            echo "Error:" . $e->getMessage() . "<br/>";
        }

        break;
    case "listar_fetchObject_std":
        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=mi_base", "root", "");
            
            $sql = $pdo->query("SELECT * FROM `mi_tabla` WHERE 1");

            if($sql != false)
            {
                while($res = $sql->fetchObject())
                {
                    var_dump($res);
                }
                
            }
            else 
            {
                echo "Error.";
            }
        }
        catch(PDOException $e)
        {
            echo "Error:" . $e->getMessage() . "<br/>";
        }
        break;
    case "listar_prepare":
        $id = $_POST["id"];
        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=mi_base", "root", "");
            
            $sql = $pdo->prepare("SELECT * FROM `mi_tabla` WHERE id = :id");
            $sql->bindParam(":id", $id, PDO::PARAM_INT);
            $sql->execute();
            $fila = $sql->fetch();

            if($fila !== false)
            {
                var_dump($fila);
            }
            else 
            {
                echo "Error.";
            }
        }
        catch(PDOException $e)
        {
            echo "Error:" . $e->getMessage() . "<br/>";
        }
        break;
    case "agregar":
        $texto = $_POST["texto"];
        $fecha = $_POST["fecha"];
        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=mi_base", "root", "");
            
            $sql = $pdo->prepare("INSERT INTO `mi_tabla`(`texto`, `fecha`) VALUES (:texto, :fecha)");
            $sql->bindParam(":texto", $texto, PDO::PARAM_STR, 20);
            $sql->bindParam(":fecha", $fecha, PDO::PARAM_STR);
            $sql->execute();
        }
        catch(PDOException $e)
        {
            echo "Error:" . $e->getMessage() . "<br/>";
        }
        break;
    case "modificar":
        $id = $_POST["id"];
        $texto = $_POST["texto"];
        $fecha = $_POST["fecha"];
        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=mi_base", "root", "");
            
            $sql = $pdo->prepare("UPDATE `mi_tabla` SET texto = :texto, fecha = :fecha WHERE id = :id");
            $sql->bindParam(":id", $id, PDO::PARAM_INT);
            $sql->bindParam(":texto", $texto, PDO::PARAM_STR, 20);
            $sql->bindParam(":fecha", $fecha, PDO::PARAM_STR);
            $sql->execute();
        }
        catch(PDOException $e)
        {
            echo "Error:" . $e->getMessage() . "<br/>";
        }
        break;
    case "eliminar":
        $id = $_POST["id"];
        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=mi_base", "root", "");
            
            $sql = $pdo->prepare("DELETE FROM `mi_tabla` WHERE id = :id");
            $sql->bindParam(":id", $id, PDO::PARAM_INT);
            $sql->execute();
        }
        catch(PDOException $e)
        {
            echo "Error:" . $e->getMessage() . "<br/>";
        }
        break;
    default:
        echo "Elija una opción válida.";
        break;
}