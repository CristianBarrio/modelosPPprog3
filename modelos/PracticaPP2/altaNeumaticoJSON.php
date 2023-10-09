<?php

require_once "../PracticaPP2/Clases/Neumatico.php";

$neumatico = new Neumatico("asdas","asdasd",10);
$neumatico->guardarJSON("../PracticaPP2/Archivos/neumaticos.json");