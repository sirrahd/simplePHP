<?php

class Controller
{
    private $command;

    function Controller(&$command)
    {
        $this->command = $command;
    }

    function _default()
    {

    }

    function _error()
    {

    }

    function execute()
    {
        $functionToCall = $this->command->getFunction();
        
        if ($functionToCall == '')
        {
            $functionToCall = 'default';
        }

        if (!is_callable(array(&$this, '_' . $functionToCall)))
        {
            $functionToCall = 'error';
        }

        call_user_func(array(&$this, '_' . $functionToCall));
    }
}

?>
