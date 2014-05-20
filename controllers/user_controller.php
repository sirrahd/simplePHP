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
			$accountName = IO::getInput('accountName');
            $email = IO::getInput('email');
            $password = IO::getInput('password');
            $remember = IO::getInput('remember');
            
            // TODO: If error, re-show signup page with error details info
			$user = new User();
			$user->accountName = $accountName;
			$user->email = $email;
			$user->password = $password;

			if ($user->create()) {
				echo 'User created';
			}
			else {
				echo json_encode($user->getErrors());
			}
		}
    }
}

?>
