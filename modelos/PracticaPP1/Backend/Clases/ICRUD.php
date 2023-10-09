<?php
interface ICRUD
{
    public static function TraerTodos();
    public function Agregar():bool;
    public function Modificar();
    public static function Eliminar($id);
}
?>