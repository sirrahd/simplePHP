<?php

class Command
{
    var $name = '';
    var $function = '';
    var $parameters = array();

    function Command($controllerName, $functionName, $parameters)
    {
        $this->name = $controllerName;
        $this->parameters = $parameters;
        $this->function = $functionName;
    }

    function getControllerName()
    {
        return $this->name;
    }

    function getFunction()
    {
        return $this->function;
    }

    function getParameters()
    {
        return $this->parameters;
    }
}

?>
