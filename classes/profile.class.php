<?php 

class Profile
{
    public function getProfile($id)
    {
        $DB = new Database();
        $query = "SELECT * FROM users WHERE userid = '$id' LIMIT 1";
        return $DB->read($query);
    }
}