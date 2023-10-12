<?php 

class Signup 
{
    private $error = "";
    private $pwdCheck = "";

    public function evaluate($data)
    {
        // ERROR HANDLING
         foreach ($data as $key => $value)
         {
            if ($key == "username")
            {
                if (empty($value))
                {
                    $this->error = $this->error . "Zadejte uživatelské jméno!<br>";
                }
                else
                {
                    // Kontrola, zda již není username v databázi
                    if ($this->usernameExists($value))
                    {
                        $this->error = $this->error . "Toto uživatelské jméno je zabrané!<br>";
                    }
                    if (is_numeric($value)) 
                    {
                        $this->error = $this->error . "Uživatelské jméno nemůže být jenom číslo!<br>";
                    }
                    if (strstr($value, " "))
                    {
                        $this->error = $this->error . "Uživatelské jméno nemůže obsahovat mezeru!<br>";
                    }
                }
            }

            if ($key == "email")
            {
                if (empty($value))
                {
                    $this->error = $this->error . "Zadejte e-mailovou adresu!<br>";
                }
                else if (!filter_var($value, FILTER_VALIDATE_EMAIL))
                {
                    $this->error = $this->error . "Zadejte opravdovou e-mailovou adresu!<br>";
                }
                else {
                    // Kontrola, zda email není již v databázi
                    if ($this->emailExists($value))
                    {
                        $this->error = $this->error . "Tento e-mail je již zaregistrován!<br>";
                    }
                }
            }

            if ($key == "password")
            {
                if (empty($value))
                {
                    $this->error = $this->error . "Zadejte heslo!<br>";
                }
                else
                {
                    if (strstr($value, " "))
                    {
                        $this->error = $this->error . "Heslo nemůže obsahovat mezeru!<br>";
                    }
                    else if (!$this->isPasswordStrongEnough($value)) {
                        $this->error = $this->error . "Heslo není dostatečně silné!<br>";
                    }
                    $this->pwdCheck = $value;
                }
            }

            if ($key == "password-again")
            {
                if (empty($value))
                {
                    $this->error = $this->error . "Zadejte vaše heslo znovu!<br>";
                }
                // Kontrola, zda se hesla shodují
                else if ($this->pwdCheck !== $value)
                {
                    $this->error = $this->error . "Hesla se neshodují!<br>";
                }
            }
        
         }

         if ($this->error == "")
         {
                // Bez erroru, vytvoří se uživatel do databáze
                $this->create_user($data);
         }
         else
         {
            // Navrátí všechny chyby při registraci
            return $this->error;
         }
    }

    public function create_user($data)
    {

        $username = addslashes(ucfirst($data['username']));
        $gender = addslashes($data['gender']);
        $email = addslashes($data['email']);
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        $cleanedUsername = iconv('UTF-8', 'ASCII//TRANSLIT', $username);
        $cleanedUsername = strtolower($cleanedUsername);
        
        // Vytvoření URL adresy
        $url_adress = "u." . $cleanedUsername;
        $userid = $this->create_userid();

        $query = "INSERT INTO users(userid, username, gender, email, password, url_adress) 
        VALUES ('$userid', '$username', '$gender', '$email', '$hashedPassword', '$url_adress')";
        
        $DB = new Database();
        $DB->save($query);

    }

    private function create_userid()
{
    $DB = new Database();

    do {
        $length = rand(4, 19);
        $number = "";
        
        for ($i = 0; $i < $length; $i++) {
            $newRand = rand(0, 9);
            $number .= $newRand;
        }

        $query = "SELECT userid FROM users WHERE userid = '$number'";
        $result = $DB->read($query);

    } while (!empty($result));

    return $number;
}

    private function emailExists($email)
    {
        $DB = new Database();
        $query = "SELECT email FROM users WHERE email = '$email'";
        $result = $DB->read($query);

        return !empty($result);
    }

    private function usernameExists($username)
    {
        $DB = new Database();
        $query = "SELECT username FROM users WHERE username = '$username'";
        $result = $DB->read($query);

        return !empty($result);
    }

    private function isPasswordStrongEnough($password)
    {
    // Minimální délka hesla
    $minLength = 8;

    // Alespoň jedno velké písmeno
    $hasUppercase = preg_match('/[A-Z]/', $password);

    // Alespoň jedno malé písmeno
    $hasLowercase = preg_match('/[a-z]/', $password);

    // Alespoň jedno číslo
    $hasNumber = preg_match('/[0-9]/', $password);

    return strlen($password) >= $minLength && $hasUppercase && $hasLowercase && $hasNumber;
    }

    public function getHashedPassword($email)
    {
    $DB = new Database();
    $query = "SELECT password FROM users WHERE email = '$email'";
    $result = $DB->read($query);

    if ($result) {
        return $result[0]['password'];
    } else {
        return null; // Uživatel s tímto emailem nebyl nalezen
    }
    }
}