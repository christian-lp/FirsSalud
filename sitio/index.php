<?php
// EL INDEX: Salida de las vistas al usuario y se envian las distintas acciones del usuario al controlador, se denomina Index Front Controller

// Estas 3 lineas me muestra errores en pantalla
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', false);

// CONTROLADORES
require_once "controladores/plantilla.controlador.php";
require_once "controladores/inicio.controlador.php";
require_once "controladores/formulario.controlador.php";

// MODELOS
require_once "modelos/formularios.modelo.php";

/*
//Probar la conexion con la DB
require_once "modelos/conexion.php";
$conexion = Conexion::conectar();
echo '<pre>'; print_r($conexion); echo '</pre>';
*/

// LLAMO A LA PLANTILLA PRINCIPAL
// $plantilla = new ControladorPlantilla;
// $plantilla -> ctrTraerPlantilla();


$plantilla = new ControladorInicio;
$plantilla -> ctrTraerInicio();

