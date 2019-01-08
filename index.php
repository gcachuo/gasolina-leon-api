<?php
/**
 * Created by PhpStorm.
 * User: Cachu
 * Date: 8/01/19
 * Time: 05:31 PM
 */
$version = '190108';
define('SEED', 'crypt0w4113t');

require "libs/system.php";
require "libs/database.php";
require "vendor/autoload.php";

setcookie('XDEBUG_SESSION', 'PHPSTORM');
error_reporting(E_ALL);
ini_set('display_errors', 1);
spl_autoload_register('auto_loader');
set_error_handler('error_handler');
register_shutdown_function('shutdown_function');

header('Content-type: application/json');

try {

    $controller = isset_get($_REQUEST['controller']);
    $action = isset_get($_REQUEST['action']);

    /** @var array|string|null $response */
    if (empty($controller) || empty($action)) {
        $response = null;
    } else {
        $controller = new $controller();
        $response = $controller->$action();
    }
} catch (Exception $exception) {
    $errno = $exception->getCode() ?: 400;
    $message = $exception->getMessage();
    $errfile = $exception->getFile();
    $errline = $exception->getLine();
    http_response_code($errno);

    die(json_encode(['response' => 'App Error', 'code' => http_response_code(), 'error' => compact('errno', 'message', 'errfile', 'errline')]));
}

echo json_encode(['response' => $response, 'code' => http_response_code(), 'version' => $version]);
