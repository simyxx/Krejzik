<?php 

class Settings
{
    public function get_settings($id)
    {
        $DB = new Database();
        $sql = "SELECT * FROM users WHERE userid = '$id' LIMIT 1";
        $row = $DB->read($sql);

        if (is_array($row))
        {
            return $row[0];
        }
        return false;
    }

    public function save_settings($data, $id)
    {
        $DB = new Database();
        $password = $data['password'];
        if (strlen($password) < 30){
            if ($data['password'] == $data['password-again'])
            {
                 $data['password']  = password_hash($password, PASSWORD_DEFAULT);
            }
           else {
            unset($data['password']);
           }
        }
        unset($data['password-again']);
        $sql = "UPDATE users SET ";
        foreach ($data as $key => $value){
            $sql .= $key . "='" . $value . "',";
        }

        $sql = trim($sql, ",");

        $sql .= " WHERE userid = '$id' LIMIT 1";
        $DB->save($sql);
    }
}