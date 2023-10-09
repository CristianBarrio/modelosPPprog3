<?php

namespace Barrio
{
    use mPDF;

    require_once __DIR__ . '../vendor/autoload.php';

    class Alumno implements \JsonSerializable
    {
        private int $legajo;
        private string $apellido;
        private string $nombre;
        private string $pathFoto;

        public function __construct($legajo, $apellido, $nombre, $pathFoto)
        {
            $this->legajo = $legajo;
            $this->apellido = $apellido;
            $this->nombre = $nombre;
            $this->pathFoto = $pathFoto;
        }

        public function AgregarAlumno($path):string
        {
            $registro = $this->legajo . " - " . $this->apellido . " - " . $this->nombre . " - " . $this->pathFoto . " \n";

            if(file_put_contents($path, $registro, FILE_APPEND) != false)
            {
                $mensaje = "Alumno guardado correctamente.<br>"; 
            }else
            {
                $mensaje = "Error al guardar el alumno.<br>";
            }

            return $mensaje;
        }

        public static function ListarAlumnos($path):string
        {
            $mensaje = "";

            if(file_exists($path))
            {
                $listado = file_get_contents($path);
                if($listado != false)
                {
                    $mensaje = "Alumnos:<br>" . $listado . "<br>";
                }else
                {
                    $mensaje = "Error al abrir el archivo.<br>"; 
                }
            }else
            {
                $mensaje = "El archivo no existe.<br>";
            }

            return $mensaje;
        }

        public static function BuscarPorLegajo($path, $legajo):bool
        {
            $retorno = false;

            if(file_exists($path))
            {
                $contenido = file_get_contents($path);

                if(stripos($contenido, $legajo) !== false)
                {
                    $retorno = true;
                }
            }

            return $retorno;
        }

        public static function EliminarAlumno($path, $legajo):string
        {
            if(!Alumno::BuscarPorLegajo($path, $legajo))
            {
                $mensaje = "El alumno con legajo " . $legajo . " no se encuentra en el listado.<br>";
            }
            else
            {
                if(file_exists($path))
                {
                    $lineas = file($path, FILE_IGNORE_NEW_LINES);
                    $lineasNuevas = array_filter($lineas, function($linea) use ($legajo){
                        return stripos($linea, $legajo) === false;
                    });
    
                    $nuevoArchivo = implode(PHP_EOL, $lineasNuevas);
                    $ar = fopen($path, "w");

                    if($ar != false && fwrite($ar, $nuevoArchivo) != false)
                    {
                        fclose($ar);
                        $mensaje = "El alumno con legajo " . $legajo . " se ha borrado.<br>";
                    }else
                    {
                        $mensaje = "Error al eliminar el alumno.<br>";
                    }
                }else
                {
                    $mensaje = "El archivo no existe.<br>";
                }
            }

            return $mensaje;
        }

        public function ModificarAlumno($path, $legajo):string
        {
            if(!Alumno::BuscarPorLegajo($path, $legajo))
            {
                $mensaje = "El alumno con legajo " . $legajo . " no se encuentra en el listado.<br>";
            }
            else
            {
                Alumno::EliminarAlumno($path, $legajo);
                $this->AgregarAlumno($path);
                $mensaje = "El alumno con legajo $legajo se ha modificado.\n";
            }

            return $mensaje;
        }

        public static function ObtenerAlumno($path, $legajo):string
        {
            $retorno = "";
            $linea = "";

            if(!Alumno::BuscarPorLegajo($path, $legajo))
            {
                $retorno = "El alumno con legajo " . $legajo . " no se encuentra en el listado.<br>";
            }
            else
            {
                if(file_exists($path))
                {
                    $archivo = fopen($path, "r");

                    while(!feof($archivo))
                    {
                        $linea = fgets($archivo);

                        if(strpos($linea, $legajo))
                        {
                            $retorno = $linea;
                            break;
                        }
                    }

                    fclose($archivo);
                }else
                {
                    $retorno = "El archivo no existe.<br>";
                }
            }

            return $retorno;
        }

        public static function ListarObjetos($path):string
        {
            $retorno = "";

            if(file_exists($path))
            {
                $archivoStr = file_get_contents($path);
                $archivoArray = explode("\n", $archivoStr);
       
                $alumnosObj = [];
                $legajo = 0;
                $apellido = "";
                $nombre = "";

                foreach($archivoArray as $linea) 
                { 
                    $alumnoStr = explode(" - ", $linea);

                    if(count($alumnoStr) >= 4)
                    {
                        $legajo = $alumnoStr[0];
                        $apellido = $alumnoStr[1];
                        $nombre = $alumnoStr[2];
                        $pathFoto = $alumnoStr[3];
                        $alumnoObj = new Alumno($legajo, $apellido, $nombre, $pathFoto);
                        $alumnosObj[] = $alumnoObj;
                    }
                }

                $arrayJson = [];

                foreach($alumnosObj as $alumno)
                { 
                    $arrayJson[] = json_encode($alumno);
                }

                $retorno = implode("", $arrayJson);

            }else
            {
                $retorno = "El archivo no existe.<br>";
            }

            return $retorno;
        }

        public function jsonSerialize()
        {
            return [
                'legajo' => $this->legajo,
                'apellido' => $this->apellido,
                'nombre' => $this->nombre,
                'foto' => $this->pathFoto
            ];
        }

        public static function ListarTabla($path):string
        {
            $tablaStr = "";

            if(file_exists($path))
            {
                $tablaStr = '<table border="1">
                    <tr>
                        <th>Legajo</th>
                        <th>Apellido</th>
                        <th>Nombre</th>
                        <th>Foto</th>
                    </tr>';

                $archivoStr = file_get_contents($path);
                $archivoArray = explode("\n", $archivoStr);
       
                $legajo = 0;
                $apellido = "";
                $nombre = "";
                $pathFoto = "";

                foreach($archivoArray as $linea) 
                { 
                    $alumnoStr = explode(" - ", $linea);

                    if(count($alumnoStr) >= 4)
                    {
                        $legajo = $alumnoStr[0];
                        $apellido = $alumnoStr[1];
                        $nombre = $alumnoStr[2];
                        $pathFoto = $alumnoStr[3];
                        
                        $tablaStr .= '<tr>';
                        $tablaStr .= '<td>' . $legajo . '</td>';
                        $tablaStr .= '<td>' . $apellido . '</td>';
                        $tablaStr .= '<td>' . $nombre . '</td>';
                        $tablaStr .= '<td><img src="' . $pathFoto . '" alt="Foto de ' . $nombre . ' ' . $apellido . '" width="100"></td>';
                        $tablaStr .= '</tr>';
                    }
                }

                $tablaStr .= '</table>';
            }
            else
            {
                $tablaStr = "El archivo no existe.<br>";
            }

            return $tablaStr;
        }

        public static function Redirigir($path, $legajo)
        {
            $alumnoStr = "";
            $alumnoStr = Alumno::ObtenerAlumno($path, $legajo);
            $retorno = false;

            if($alumnoStr != "")
            {
                $arrayAlumno = explode(" - ", $alumnoStr);

                $apellido = $arrayAlumno[1];
                $nombre = $arrayAlumno[2];
                $foto = $arrayAlumno[3];

                session_start();

                $_SESSION["legajo"] = $legajo;
                $_SESSION["apellido"] = $apellido;
                $_SESSION["nombre"] = $nombre;
                $_SESSION["foto"] = $foto;

                header("Location: principal.php");
                exit();
            }

            return $retorno;
        }

        public static function mostrarPdf()
        {
            /*header("content-type:application/pdf");
            $mpdf = new mPDF(['orientation' => 'L',
                            'pagenumPrefix' => 'Página nro. ',
                            'pagenumSuffix' => ' - ',
                            'nbpgPrefix' => ' de ',
                            'nbpgSuffix' => ' páginas']);

            $mpdf->SetHeader('{$apellido $nombre}||{PAGENO}{nbpg}');
            $mpdf->SetFooter('{DATE j-m-Y}');*/
        }
    }
}