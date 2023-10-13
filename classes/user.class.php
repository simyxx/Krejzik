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

    public function getUser($id)
    {
        $query = "SELECT * FROM users WHERE userid = '$id' limit 1";
        $DB = new Database();
        $result = $DB->read($query);

        if ($result)
        {
            return $result[0];
        }
        else
        {
            return false;
        }
    }

    public function getFriends($id)
    {
        $query = "SELECT * FROM users WHERE userid != '$id'";
        $DB = new Database();
        $result = $DB->read($query);

        if ($result)
        {
            return $result;
        }
        else
        {
            return false;
        }
    }

}