<?php
// Turn off all error reporting
error_reporting(0);
// Same as error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
include "funciones.php";
echo formulario_sistema_medico(); // LLamada a la función
?>