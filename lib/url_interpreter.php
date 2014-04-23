<?php

class UrlInterpreter
{
    function UrlInterpreter()
    {
        $requestURI = explode('/', $_SERVER{'REQUEST_URI'});
        $scriptName = explode('/', $_SERVER{'SCRIPT_NAME'});
        $commandArray = array_diff_assoc($requestURI, $scriptName);
        $commandArray = array_values($commandArray);
        $controllerName = $commandArray[0];

        if (!isset($commandArray[2]))
        {
            if (!isset($commandArray[1]))
            {
                $commandArray[1] = '';
            }
            $commandArray[2] = '';
        }    
        $controllerFunction = $commandArray[1];
        $parameters = array_slice($commandArray, 2);

        if ($controllerName == '')
        {
            $controllerName = 'root';
        }
        
        $this->command = new Command($controllerName, $controllerFunction, $parameters);
    }

    function getCommand()
    {
        return $this->command;
    }
}

?>
