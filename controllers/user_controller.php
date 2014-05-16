<?php

include_once('models/user.php');

class UserController extends Controller
{
    function _create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            $user = new User();
            include('views/users/create.php');
        }
        else if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $email = IO::getInput('email');
            $password = IO::getInput('password');
            $remember = IO::getInput('remember');
            
            // TODO: Verify this data, create user
            // If error, re-show page with error details info
    }
}

?>
