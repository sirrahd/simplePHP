<?php

include('lib/controller.php');

class CommandDispatcher
{
    private $command;

    function CommandDispatcher(&$command)
    {
        $this->command = $command;
    }

    function isController($controllerName)
    {
        if (file_exists('controllers/' . $controllerName . '_controller.php'))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function Dispatch()
    {
        $controllerName = $this->command->getControllerName();

        if ($this->isController($controllerName) == false)
        {
            $controllerName = 'error';
        }

        include('controllers/' . $controllerName . '_controller.php');
        $controllerClass = ucwords($controllerName) . "Controller";
        $controller = new $controllerClass($this->command);
        $controller->execute();
    }
}

?>
