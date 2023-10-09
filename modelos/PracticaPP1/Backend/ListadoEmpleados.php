<?php
require_once "../Backend/Clases/Empleado.php";

//funciona, no muestra foto
if(isset($_GET["tabla"]) && $_GET["tabla"] === "mostrar")
{   
    $retorno = '<h1>Lista de empleados</h1>';
    $retorno .= '<table border="1">
                    <tr>
                        <th>ID</th>
                        <th>Correo</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Sueldo</th>
                        <th>Foto</th>
                    </tr>';
    
    $empleados = Empleado::TraerTodos();
    
    foreach($empleados as $empleado)
    {
        $retorno .= '<tr>';
        $retorno .= '<td>' . $empleado->id . '</td>';
        $retorno .= '<td>' . $empleado->correo . '</td>';
        $retorno .= '<td>' . $empleado->nombre . '</td>';
        $retorno .= '<td>' . $empleado->perfil . '</td>';
        $retorno .= '<td>' . $empleado->sueldo . '</td>;';
        $retorno .= '<td>' . $empleado->foto . '</td>;';
        $retorno .= '<td><img src="' . $empleado->foto . '" alt="Foto de ' . $empleado->nombre . ' ." width="50px" height="50px"></td>';
        $retorno .= '</tr>';
    }
    
    $retorno .= '</table>';
    
    echo $retorno;
}
else
{
    echo "Error al mostrar el listado de empleados.";
}

?>