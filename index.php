<?php

include('config.php');
include('lib/db.php');
include('lib/command.php');
include('lib/url_interpreter.php');
include('lib/command_dispatcher.php');
include('lib/controller.php');
include('lib/model.php');

session_start();
$urlInterpreter = new UrlInterpreter();
$command = $urlInterpreter->getCommand();
$commandDispatcher = new CommandDispatcher($command);
$commandDispatcher->Dispatch();

?>
