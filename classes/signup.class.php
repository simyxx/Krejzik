<?php 

class Signup 
{

    private $error = "";

    public function evaluate($data)
    {

         foreach ($data as $key => $value)
         {
            if (empty($value))
            {
                $this->error .= $key . " pole je prázdné!<br>";
            }
         }

         if ($this->error == "")
         {
                // Bez erroru
                $this->create_user($data);
         }
         else
         {
            return $this->error;
         }
    }

    public function create_user($data)
    {

        $username = $data['Přezdívka'];
        $gender = $data['Pohlaví'];
        $email = $data['Email'];
        $password = $data['Heslo'];

        $url_adress = "u." . strtolower( $username); 
        $userid = $this->create_userid();

        $query = "INSERT INTO users(userid, username, gender, email, password, url_adress) 
        VALUES ('$userid', '$username', '$gender', '$email', '$password', '$url_adress')";
        $DB = new Database();
        $DB->save($query);

    }

    private function create_userid()
    {
        $length = rand(4,19);
        $number = "";
        for ($i = 0; $i < $length; $i++)
        {
            $newRand = rand(0,9);
            $number .= $number . $newRand;
        }
        return $number;
    }
}