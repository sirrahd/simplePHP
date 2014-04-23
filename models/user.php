<?php

class User
{
    var $email = null;
    var $password = null;
    var $passwordHash = null;
    private $id = null;

    function User($email = '', $password_hash = '', $password = '')
    {
        $this->email = $email;
        $this->password = $password;
        $this->password_hash = $password_hash;
    }

    function logIn()
    {
        if ($this->id)
        {
            return true;
        }

        $email = saveEmail();
        $passwordHash = savePasswordHash();
        if ($email && $passwordHash)
        {
            $query = DB::connect()->prepare("SELET * FROM users WHERE email=':email' AND password_hash=':password_hash'");
            $response = $query->fetchAll(PDO::FETCH_ASSOC);
            $this->email = $response[0]['email'];
            $this->passwordHash = $response[0]['password_hash'];
            $this->id = $response[0]['id'];
        }
        else
        {
            return false;
        }


        $query = DB::connect()->prepare("SELECT * from users WHERE email=:email AND password_hash=:password_hash");
        $query->bindParam(':email', $

    function save()
    {
        $email = saveEmail();
        $passwordHash = savePasswordHash();

        if (!$email && !$password)
        {
            return false;
        }
        
        if ($this->id || $this->logIn())
        {
            $query = DB::connect()->prepare("UPDATE user SET email=:emailAND password_hash=:password_hash WHERE id=:id");
            $query->bindValue(':email', $email, PDO::PARAM_STR);
            $query->bindValue(':password_hash', $passwordHash, PDO::PARAM_STR);
            $query->bindValue(':id', $this->id, PDO::PARAM_INT);
            $query->execute();
        }
        else if (!emailExists($email))
        {
            $query = DB::connect()->prepare("INSERT INTO users(email, password_hash) VALUES(':email', ':password_hash')");
            $query->bindValue(':email', $email, PDO::PARAM_STR);
            $query->bindValue(':password_hash', $passwordHash, PDO::PARAM_STR);
            if($query->execute());
            {
                $self->id = $query->lastInsertId();
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }

        return true;
    }

    private function create()
    {
        // This function assumes checks on the variables have already
        // been made.
        $
    }

    function saveEmail()
    {
        if (isValidEmail($this->email))
        {
            return strtolower($this->email);
        }
        else
        {
            return null;
        }
    }

    static function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    static function emailExists($email)
    {
        $query = DB::connect()->prepare("SELECT COUNT(*) FROM users WHERE email=:email");
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->execute();
        
        if ($query->fetchColumn() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    static function isValidPassword($password)
    {
        return $password != '';
    }

    function savePasswordHash()
    {
        if (isValidPassword($this->password))
        {
            $this->passwordHash = hashPassword($this->password);
            return $this->passwordHash;
        }
        else if ($passwordHash)
        {
            return $passwordHash;

        else
        {
            return null;
        }
    }

    static function hashPassword($password)
    {
        return password_hash($password);
    }
}

?>
