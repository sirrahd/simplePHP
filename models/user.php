<?php

class User extends Model
{
	var $accountName = null;
    var $email = null;
    var $password = null;
	private $userData = array(
		'id'			=> null,
		'accountName' 	=> null,
		'email'			=> null
	);
	

    function User()
    {
		return;
    }
	
	// Creates new users in the database
	// Returns true if success, false otherwise
	// Error details added to errors array.
	function create()
	{
		$this->formatData();
		
		// Check if account name is valid and available
		if (!User::isAccountNameValid($this->accountName)) {
			$this->addError('AccountNameInvalid');
		}
		else if (!User::isAccountNameAvailable($this->accountName)) {
			$this->addError('AccountNameNotAvailable');
		}
		
		// Check if email is valid and available
		if (!User::isEmailValid($this->email)) {
			$this->addError('EmailInvalid');
		}
		else if (!User::isEmailAvailable($this->email)) {
			$this->addError('EmailNotAvailable');
		}
		
		// Check if password is valid
		if (!User::isPasswordValid($this->password)) {
			$this->addError('PasswordInvalid');
		}
		
		// Hash user password
		$this->passwordHash = User::hashPassword($this->password);
		
		if ($this->errorCount() == 0) {
			$query = DB::connect()->prepare("INSERT INTO users(account_name, email, password_hash) VALUES(:account_name, :email, :password_hash)");
			$query->bindValue(':account_name', $this->accountName, PDO::PARAM_STR);
			$query->bindValue(':email', $this->email, PDO::PARAM_STR);
			$query->bindValue(':password_hash', $this->passwordHash, PDO::PARAM_STR);
			
			if ($query->execute()) {
				if ($this->logIn()) {
					return true;
				}
				else {
					$this->addError('UserCreateLoginFail');
				}
            }
            else {
            	$this->addError('UserCreateDBFail');
            }
		}
		
		return false;
	}
	
	function formatData()
	{
		$this->accountName = strtolower($this->accountName);
		$this->email = strtolower($this->email);
	}
	
	// Account names must exist and be alphanumeric
	private static function isAccountNameValid($accountName)
	{
		if ($accountName == null) {
			return false;
		}
		
		return ctype_alnum($accountName);
	}
	
	// Email addresses can either be blank or valid emails
	private static function isEmailValid($email)
	{
		if ($email == null) {
			return true;
		}
		
        return filter_var($email, FILTER_VALIDATE_EMAIL);
	}
	
	private static function isPasswordValid($password)
	{
		if ($password != null) {
			return true;
		}
		
		return false;
	}
	
	private static function isAccountNameAvailable($accountName)
	{
        $query = DB::connect()->prepare("SELECT COUNT(*) FROM users WHERE account_name=:account_name");
        $query->bindValue(':account_name', $accountName, PDO::PARAM_STR);
        $query->execute();
        
        if ($query->fetchColumn() == 0) {
            return true;
        }
        else {
            return false;
        }
	}
	
	private static function isEmailAvailable($email)
	{
		$query = DB::connect()->prepare("SELECT COUNT(*) FROM users WHERE email=:email");
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->execute();
        
        if ($query->fetchColumn() == 0) {
            return true;
        }
        else {
            return false;
        }
	}
	
	private function isLoggedIn()
	{
		return $this->id != null;
	}

    function logIn()
    {
        if ($this->userData['id']) {
            return true;
        }
        
    	$this->formatData();
    	
        if (($this->accountName || $this->email) && $this->password)
		{
            $query = DB::connect()->prepare("SELECT * FROM users WHERE account_name=:account_name OR email=:email");
			$query->bindValue(':account_name', $this->accountName, PDO::PARAM_STR);
			$query->bindValue(':email', $this->email, PDO::PARAM_STR);
			
			$query->execute();
			$response = $query->fetchAll(PDO::FETCH_ASSOC);
            if (isset($response[0]) && password_verify($this->password, $response[0]['password_hash'])) {
				$this->userData['id'] = $response[0]['id'];
            	$this->userData['accountName'] = $response[0]['account_name'];
            	$this->userData['email'] = $response[0]['email'];
            	return true;
			}
			else {
				$this->addError('LoginFail');
			}
		}
		else {
			$this->addError('LoginFailMissingInfo');
		}

		return false;
	}


    static private function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

#    function save()
#	{
#		$accountName = $this->saveAccountName();
#        $email = $this->saveEmail();
#        $passwordHash = $this->savePasswordHash();

#        if (!$accountName && !$password)
#        {
#            return false;
#        }
#        
#        if ($this->id || $this->logIn())
#        {
#            $query = DB::connect()->prepare("UPDATE user SET account_name=:account_name AND email=:email AND password_hash=:password_hash WHERE id=:id");
#			$query->bindValue(':account_name', $accountName, PDO::PARAM_STR);
#			$query->bindValue(':email', $email, PDO::PARAM_STR);
#            $query->bindValue(':password_hash', $passwordHash, PDO::PARAM_STR);
#            $query->bindValue(':id', $this->id, PDO::PARAM_INT);
#            return $query->execute();
#        }
#        else if (!emailExists($email))
#        {
#            $query = DB::connect()->prepare("INSERT INTO users(account_name, email, password_hash) VALUES(':account_name', ':email', ':password_hash')");
#			$query->bindValue(':account_name', $accountName, PDO::PARAM_STR);
#            $query->bindValue(':email', $email, PDO::PARAM_STR);
#            $query->bindValue(':password_hash', $passwordHash, PDO::PARAM_STR);
#            if($query->execute());
#            {
#				$self->id = $query->lastInsertId();
#				return true;
#            }
#        }

#        return false;
#    }

}

?>
