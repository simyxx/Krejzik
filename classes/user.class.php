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

    public function follow_user($id, $type, $krejzik_userid)
    {
        $DB = new Database();

            // Uložit follow detaily
            $sql = "SELECT following FROM likes WHERE type ='$type' && contentid = '$krejzik_userid' LIMIT 1";
            $result = $DB->read($sql);
            if (is_array($result)){

                $following = json_decode($result[0]['following'], true);
                
                $userIds = array_column($following, "userid");
                if (!in_array($id, $userIds)){
                    $arr["userid"] = $id;
                    $arr["date"] = date("Y-m-d H:i:s");
                
                    $following[] = $arr;
                    $followingString = json_encode($following);
                    $sql = "UPDATE likes SET following = '$followingString' WHERE type ='$type' && contentid = '$krejzik_userid' LIMIT 1";
                    $DB->save($sql);

                }
                else {
                    $key = array_search($id, $userIds);
                    unset($following[$key]);
                    $followingString = json_encode($following);
                    $sql = "UPDATE likes SET following = '$followingString' WHERE type ='$type' && contentid = '$krejzik_userid' LIMIT 1";
                    $DB->save($sql);

                }
                
            }
            else 
            {
                $arr["userid"] = $id;
                $arr["date"] = date("Y-m-d H:i:s");
                $array[] = $arr;

                // Dání pole do stringu přes json
                $following = json_encode($array);
                $sql = "INSERT INTO likes (type, contentid, following) values ('$type', '$krejzik_userid', '$following')";
                $DB->save($sql);
            
            }
    }

    public function get_following($id, $type)
    {
        $type = addslashes($type);
        $DB = new Database();
        if (is_numeric($id))
        {
        
            // Získat detaily o followech
            $sql = "SELECT following FROM likes WHERE type ='$type' && contentid = '$id'";
            $result = $DB->read($sql);
            if (is_array($result)){

                $following = json_decode($result[0]['following'], true);
                $realFollowing = $following;
                return $realFollowing;
            }   
        }

        return false;
    }

}