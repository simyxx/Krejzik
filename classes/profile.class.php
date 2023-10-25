<?php 

class Profile
{
    public function getProfile($id)
    {
        $id = addslashes($id);
        $DB = new Database();
        $query = "SELECT * FROM users WHERE userid = '$id' LIMIT 1";
        return $DB->read($query);
    }
}