<?php 

class Post
{
    private $error = "";

    public function create_post($userid, $data)
    {

        if (!empty($data['post']))
        {
            $post = addslashes($data['post']);
            $postid = $this->create_postid();
            $query = "INSERT INTO posts (postid, userid, post) VALUES ('$postid', '$userid', '$post')";

            $DB = new Database();
            $DB->save($query);
        }
        else
        {
            $this->error = "Přidejte text k příspěvku!<br>";
        }
        return $this->error;
    }

    public function get_posts($id)
    {
        $query = "SELECT * FROM posts WHERE userid = '$id' ORDER BY id DESC limit 10";
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

    private function create_postid()
    {
        $DB = new Database();

        do {
            $length = rand(4, 19);
            $number = "";

            for ($i = 0; $i < $length; $i++) {
                $newRand = rand(0, 9);
                $number .= $newRand;
            }

            $query = "SELECT postid FROM posts WHERE postid = '$number'";
            $result = $DB->read($query);

        } while (!empty($result));

        return $number;
    }
}