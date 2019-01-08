<?php
/**
 * Created by PhpStorm.
 * User: Cachu
 * Date: 8/01/19
 * Time: 05:34 PM
 */

/**
 * @param $variable
 * @param null $return
 * @return null
 */
function isset_get(&$variable, $return = null)
{
    if (isset($variable) and !empty($variable)) {
        return $variable;
    }
    return $return;
}

/**
 * @param int $errno
 * @param string $message
 * @param string $errfile
 * @param int $errline
 */
function error_handler($errno, $message, $errfile, $errline)
{
    http_response_code(500);
    die(json_encode(['response' => 'System Error', 'code' => http_response_code(), 'error' => compact('errno', 'message', 'errfile', 'errline')]));
}

function shutdown_function()
{
    $error = error_get_last();
    if ($error !== NULL) {
        ob_clean();
        http_response_code(500);
        die(json_encode(['response' => 'Fatal Error', 'code' => http_response_code(), 'error' => $error]));
    }
}

function auto_loader($clase)
{
    include 'controllers/' . $clase . '.php';
}