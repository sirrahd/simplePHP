<?php

class IO
{
    static function getInput($name, $filterId = FILTER_SANITIZE_STRING)
    {
        if isset($_REQUEST[$name])      $var = $_REQUEST[$name];
        else return null;

        $var = trim($var);
        return filter_var($var, $filterId);
    }


?>
