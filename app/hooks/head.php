<?php

//se declara ruta del app, hook
(!defined('APPLICATION')) ? define('APPLICATION', '\app') : NULL;
(!defined('APP_HOOK')) ? define('APP_HOOK', '\app\hooks') : NULL;
(!defined('APP_CONFIG')) ? define('APP_CONFIG', '\app\config') : NULL;
(!defined('APP_LIBS')) ? define('APP_LIBS', '\app\libs') : NULL;

//se declara ruta del sitio
if(isset($_SERVER['HTTPS'])){
	$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https://" : "http://";
}else{
	$protocol = 'http://';
}

//url a website
(!defined('SITE_URI')) ? define('SITE_URI', $protocol . $_SERVER['HTTP_HOST'] . '/joomla/') : NULL;

//se declara ruta del vendor
(!defined('APP_RESOURCES')) ? define('APP_RESOURCES', SITE_URI . 'app/resources/') : NULL;

// Establecemos que se trata de un archivo principal.
(!defined('_JEXEC')) ? define('_JEXEC', 1) : NULL;

// Definimos una constante para el caracter / que es usado como separador
(!defined('DS')) ? define('DS', DIRECTORY_SEPARATOR) : NULL;

// Definimos la ruta base de nustro sitio
//define ('INNER_PATH', str_replace('/app', '', dirname(__FILE__))); para linux
define ('INNER_PATH', str_replace(APP_HOOK, '', dirname(__FILE__)));

// Definimos el path a carpeta config de app
define ('APP_CONFIG_PATH', str_replace(APP_HOOK, APP_CONFIG, dirname(__FILE__)));

// Definimos el path a carpeta libs de app
define ('APP_LIBS_PATH', str_replace(APP_HOOK, APP_LIBS, dirname(__FILE__)));

// Incorporamos definiciones de variables y constantes globales
if (file_exists(INNER_PATH . 'defines.php')) {
include_once INNER_PATH . 'defines.php';
}

// Incorporamos las clases y objetos el framework
if (!defined('_JDEFINES')) {
define('JPATH_BASE', INNER_PATH);
require_once JPATH_BASE . DS . 'includes' . DS . 'defines.php';
}
require_once JPATH_BASE . DS . 'includes' . DS . 'framework.php';

// Inicializamos la aplicacion.
$app = JFactory::getApplication('site');
$app->initialise();

// Definimos la ruta relativa para las referencias web
define ('WEB_PATH', SITE_URI);

//se llama a archivo que gestiona la conexión a la DB
require_once ( APP_LIBS_PATH . DS . "BaseDatos.php" );

//inicializamos la clase para conectar el app a la DB configurada
$db = new BaseDatos();

//Obtenemos el usuario conectado
$user = JFactory::getUser();

//Obtenemos la sesion
$sess = JSession::getInstance('none', array());
$idSessUser = $sess->getId();

?>
<!-- El siguiente es el código del formulario -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- se llama arhivos js y css globles de la app -->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" type="text/javascript"></script>
	<script src="<?php echo APP_RESOURCES; ?>scripts/script.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
	<script src="<?php echo APP_RESOURCES; ?>scripts/bootstrap.js" type="text/javascript"></script>
	<link rel="stylesheet" href="<?php echo APP_RESOURCES; ?>css/style.css" type="text/css">
	<link rel="stylesheet" href="<?php echo APP_RESOURCES; ?>css/bootstrap.css" type="text/css">
	<link rel="stylesheet" href="<?php echo APP_RESOURCES; ?>css/open-iconic-bootstrap.css" type="text/css">
	<link rel="stylesheet" href="<?php echo APP_RESOURCES; ?>css/animate.css" type="text/css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
</head>
<body>