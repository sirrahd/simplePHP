<?php

include('config.php');
include('lib/db.php');
include('lib/command.php');
include('lib/url_interpreter.php');
include('lib/command_dispatcher.php');

$urlInterpreter = new UrlInterpreter();
$command = $urlInterpreter->getCommand();
$commandDispatcher = new CommandDispatcher($command);
$commandDispatcher->Dispatch();

?>
