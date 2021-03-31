<?php
/**
 * Core bootloader
 *
 * @author Serhii Shkrabak
 */

/* RESULT STORAGE */
$RESULT = [
	'state' => 0,
	'data' => [],
	'debug' => []
];

/* ENVIRONMENT SETUP */
define('ROOT', $_SERVER['DOCUMENT_ROOT'] . '/'); // Unity entrypoint;

register_shutdown_function('shutdown', 'OK'); // Unity shutdown function

spl_autoload_register('load'); // Class autoloader

set_exception_handler('handler'); // Handle all errors in one function

/* HANDLERS */

/*
 * Class autoloader
 */
function load (String $class):void {
	$class = strtolower(str_replace('\\', '/', $class));
	$file = "$class.php";
	if (file_exists($file))
		include $file;
}

/*
 * Error logger
 */
function handler (Throwable $e):void {
	global $RESULT;
	$code = $e->getCode();
	$codes = [1 => 'REQUEST_INCOMPLETE', 2 => 'REQUEST_INCORRECT', 4 => 'RESOURCE_LOST', 6 => 'INTERNAL_ERROR'];

	$message = $e -> getMessage();
	$RESULT['state'] = $code;
	$RESULT[ 'errors' ] = $codes[$code];
	// $RESULT[ 'debug' ][] = [
	// 	'type' => get_class($e),
	// 	'details' => $message,
	// 	'file' => $e -> getFile(),
	// 	'line' => $e -> getLine(),
	// 	'trace' => $e -> getTrace()
	// ]; as
}

/*
 * Shutdown handler
 */
function shutdown():void {
	global $RESULT;
	$error = error_get_last();
	if ( ! $error ) {
		// if ($RESULT['debug'][0]['details'] == 'StupidParams' ){
		// 	header("Content-Type: html");
		// 	echo '<html><br><br><br><br><br><br><br><h1 align=center>ТЫ ЛОХ!21</h1></html>';
		// 	return;
		// }
		header("Content-Type: application/json");
		echo json_encode($GLOBALS['RESULT'], JSON_UNESCAPED_UNICODE);
	}
}

$CORE = new Controller\Main;
$data = $CORE->exec();

if ($data !== null)
	$RESULT['data'] = $data;
else { // Error happens
	$RESULT['state'] = 6;
	$RESULT['errors'] = ['INTERNAL_ERROR'];
	unset($RESULT['data']);
	//echo('<html><h1><i>Нульові дані</i></h1>');
}