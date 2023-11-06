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
    $sql = "SELECT following, likes FROM likes WHERE type ='$type' && contentid = '$krejzik_userid' LIMIT 1";
    $result = $DB->read($sql);

    if (is_array($result)) {
        $following = json_decode($result[0]['following'], true);
        $likes = json_decode($result[0]['likes'], true);
    } else {
        $following = [];
        $likes = [];
    }

    if (!in_array($id, array_column($following, "userid"))) {
        $arr["userid"] = $id;
        $arr["date"] = date("Y-m-d H:i:s");
        $following[] = $arr;
    } else {
        $key = array_search($id, array_column($following, "userid"));
        unset($following[$key]);
    }

    // Připravíme prázdné pole pro sloupec "likes" v JSON formátu, pokud je prázdné
    if (empty($likes)) {
        $likes = [];
    }

    // Připravíme JSON řetězec pro sloupce "likes" a "following"
    $likesString = json_encode($likes);
    $followingString = json_encode($following);

    // Aktualizace nebo vytvoření záznamu v tabulce
    if (is_array($result)) {
        $sql = "UPDATE likes SET following = '$followingString', likes = '$likesString' WHERE type ='$type' && contentid = '$krejzik_userid' LIMIT 1";
    } else {
        $sql = "INSERT INTO likes (type, contentid, likes, following) values ('$type', '$krejzik_userid', '$likesString', '$followingString')";
    }

    $DB->save($sql);
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