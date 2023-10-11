<?php 

class User
{

    public function getData($id)
    {

        $query = "SELECT * FROM users WHERE userid = '$id' limit 1";
        $DB = new Database();
        $result = $DB->read($query);

        if ($result)
        {
            $row = $result[0];
            return $row;
        }
        else
        {
            return false;
        }

    }

}