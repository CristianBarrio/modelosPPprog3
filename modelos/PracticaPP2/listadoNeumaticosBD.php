<?php

require_once "./PracticaPP2/Clases/NeumaticoBD.php";

if(isset($_GET["tabla"]) && $_GET["tabla"] === "mostrar")
{   
    $retorno = '<h1>Lista de neumaticos</h1>';
    $retorno .= '<table border="1">
                    <tr>
                        <th>ID</th>
                        <th>Marca</th>
                        <th>Medidsa</th>
                        <th>Precio</th>
                        <th>Foto</th>
                    </tr>';
    
    $neumaticos = NeumaticoBD::traer();
    
    foreach($neumaticos as $neumatico)
    {
        $retorno .= '<tr>';
        $retorno .= '<td>' . $neumatico->id . '</td>';
        $retorno .= '<td>' . $neumatico->marca . '</td>';
        $retorno .= '<td>' . $neumatico->medidas . '</td>';
        $retorno .= '<td>' . $neumatico->precio . '</td>';
        $retorno .= '<td><img src='."$neumatico->foto" . 'width="50px" height="50px"></td>';
        $retorno .= '</tr>';
    }
    
    $retorno .= '</table>';
    
    echo $retorno;
}
else
{
    $neumaticos = NeumaticoBD::traer();

    foreach($neumaticos as $neumatico)
    {
        echo json_encode($neumatico);
    }
}