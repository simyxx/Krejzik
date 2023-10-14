<?php 
include("signup.class.php");

class Login 
{

    private $error = "";

    public function evaluate($data)
    {
        $email = addslashes($data['email']);
        $password = addslashes($data['password']);
        $signup = new Signup();
        $hashedPassword = $signup->getHashedPassword($email);

        $query = "SELECT * FROM users WHERE email = '$email' limit 1 ";
        
        $DB = new Database();
        $result = $DB->read($query);

        if ($result)
        {
            $row = $result[0];
            if (password_verify($password, $hashedPassword)) //password_hash($data['password'], PASSWORD_DEFAULT);
            {
                // Začátek session 
                $_SESSION['krejzik_userid'] = $row['userid'];
            }
            else 
            {
                $this->error .= "Špatné heslo nebo email!<br>";
            }
        }
        else
        {
                $this->error .= "Špatné heslo nebo email!<br>";
        }
        return $this->error;
    }

    public function checkLogin($id)
    {
        $query = "SELECT userid FROM users WHERE userid = '$id' limit 1 ";
        
        $DB = new Database();
        $result = $DB->read($query);

        if ($result)
        {
            $userData = $result[0];
            return $userData;
        }
        return false;
    }

    

}
