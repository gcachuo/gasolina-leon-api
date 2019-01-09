<?php
/**
 * Created by PhpStorm.
 * User: Cachu
 * Date: 8/01/19
 * Time: 05:34 PM
 */


$mysqli = db_connect();

/**
 * @return mysqli
 */
function db_connect()
{
    $config = [
        "host" => 'gcachuo.ml',
        "user" => 'cachu',
        "password" => getenv('DB_PASSWORD'),
        "database" => 'gasolina_leon'
    ];
    $mysqli = new mysqli($config['host'], $config['user'], $config['password'], $config['database']);
    return $mysqli;
}

/**
 * @param $sql
 * @return bool|mysqli_result
 */
function db_query($sql)
{
    global $mysqli;
    return $mysqli->query($sql);
}

/**
 * @param $sql
 * @return array|null
 * @throws Exception
 */
function db_result($sql)
{
    global $mysqli;
    $mysqli_result = db_query($sql);
    $result = null;
    if ($mysqli_result) {
        $result = $mysqli_result->fetch_assoc();
    } else {
        set_error($mysqli->error);
    }
    return $result;
}

/**
 * @return int
 */
function db_last_id()
{
    global $mysqli;
    return $mysqli->insert_id;
}

/**
 * @param string $sql
 * @param int $type
 * @return array|null
 * @throws Exception
 */
function db_all_results($sql, $type = MYSQLI_ASSOC)
{
    global $mysqli;
    $mysqli_result = db_query($sql);
    $result = null;
    if ($mysqli_result) {
        $result = $mysqli_result->fetch_all($type);
    } else {
        set_error($mysqli->error);
    }
    return $result;
}

/**
 * @throws Exception
 */
function db_error()
{
    global $mysqli;
    set_error("(" . $mysqli->errno . ") " . $mysqli->error, 500);
}