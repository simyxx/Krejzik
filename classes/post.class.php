<?php

class Post
{
    private $error = "";

    public function create_post($userid, $data, $files)
    {

        if (!empty($data['post']) || !empty($files['file']['name'])) {
            
            $postImg = "sad";
            $hasImg = 0;
            
            if (!empty($files['file']['name']))
            {
                $folder = "uploads/" . $userid . "/";
                if (!file_exists($folder))
                {
                    mkdir($folder, 0777, true);
                }

                // Tvoření názvu pro post
                $uploadedFile = $_FILES['file']['name'];
                $timestamp = time();
                $fileExtension = pathinfo($uploadedFile, PATHINFO_EXTENSION);
                $newFilename = $userid . '-' . $timestamp . '.' . $fileExtension;
                $postImg = $folder . $newFilename;
                move_uploaded_file($_FILES['file']['tmp_name'], $postImg);
                $image = new Image();
                $image->resizeImage($postImg, $postImg, 1500, 1500);

                $hasImg = 1;
            }

            $post = addslashes($data['post']);
            $postid = $this->create_postid();
            $query = "INSERT INTO posts (postid, userid, post, image, has_image) VALUES ('$postid', '$userid', '$post', '$postImg', '$hasImg')";

            $DB = new Database();
            $DB->save($query);
        } else {
            $this->error = "Přidejte text nebo obrázek do příspěvku!<br>";
        }
        return $this->error;
    }

    public function get_posts($id)
    {
        $query = "SELECT * FROM posts WHERE userid = '$id' ORDER BY id DESC limit 10";
        $DB = new Database();
        $result = $DB->read($query);

        if ($result) {
            return $result;
        } else {
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