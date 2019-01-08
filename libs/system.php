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