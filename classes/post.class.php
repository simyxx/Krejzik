<?php

class Post
{
    private $error = "";

    public function create_post($userid, $data, $files)
    {

        if (!empty($data['post']) || !empty($files['file']['name']) || isset($data['is_profile_image']) || isset($data['is_cover_image'])) {

            $postImg = "";
            $hasImg = 0;
            $isCoverImg = 0;
            $isProfileImg = 0;
            if (isset($data['is_profile_image']) || isset($data['is_cover_image'])) {
                $postImg = $files;
                $hasImg = 1;
                if (isset($data['is_cover_image']))
                    $isCoverImg = 1;
                else if (isset($data['is_profile_image']))
                    $isProfileImg = 1;
            } else {
                if (!empty($files['file']['name'])) {

                    $hasImg = 1;
                    // Tvoření složky
                    $folder = "uploads/" . $userid . "/";

                    // Tvoření bezpečného názvu souboru
                    $userId = $userid;
                    $uploadedFile = $_FILES['file']['name'];
                    $timestamp = time();
                    $fileExtension = pathinfo($uploadedFile, PATHINFO_EXTENSION);
                    $newFilename = $userId . '-' . $timestamp . '.' . $fileExtension;
                    // Tvorba složky
                    if (!file_exists($folder)) {
                        mkdir($folder, 0777, true);
                        file_put_contents($folder . "index.php", "");
                    }

                    // Zajištění, že název souboru bude jedinečný
                    $i = 1;
                    while (file_exists($folder . $newFilename)) {
                        $newFilename = $userId . '-' . $timestamp . '_' . $i . '.' . $fileExtension;
                        $i++;
                    }
                    $postImg = $folder . $newFilename;
                    move_uploaded_file($_FILES['file']['tmp_name'], $postImg);
                    $imageClass = new Image();
                    $imageClass->resizeImage($postImg, $postImg, 800, 800);

                }
            }

            $post = "";
            if (isset($data['post'])) {
                $post = addslashes($data['post']);
            }

            $postid = $this->create_postid();
            $comments = 0;
            $likes = 0;
            $currentDate = date("Y-m-d H:i:s"); // Aktuální datum a čas
            $query = "INSERT INTO posts (postid, userid, post, image, comments, likes, date, has_image, is_profile_image, is_cover_image) VALUES ('$postid', '$userid', '$post', '$postImg','$comments', '$likes', '$currentDate', '$hasImg', '$isProfileImg', '$isCoverImg')";

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



    public function get_single_post($postid)
    {
        if (!is_numeric($postid)) {
            return false;
        }
        $query = "SELECT * FROM posts WHERE postid = '$postid' limit 1";
        $DB = new Database();
        $result = $DB->read($query);

        if ($result) {
            return $result[0];
        } else {
            return false;
        }
    }

    public function delete_post($postid)
    {
        if (!is_numeric( $postid)) {
            return false;
        }
        $DB = new Database();
        $query = "DELETE FROM posts WHERE postid = '$postid' LIMIT 1";
        $DB->save($query);

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