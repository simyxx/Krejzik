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
                    $indexFile = $folder . "index.php";
                    if (!file_exists($indexFile)) {
                        file_put_contents($indexFile, "Přístup zamítnut!");
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

    public function edit_post($data, $files)
    {

        if (!empty($data['post']) || !empty($files['file']['name'])) {

            $postImg = "";
            $hasImg = 0;
            
                if (!empty($files['file']['name'])) {

                    $hasImg = 1;
                    // Tvoření složky
                    $userid = $data['userid'];
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
            

            $post = "";
            if (isset($data['post'])) {
                $post = addslashes($data['post']);
            }

            $postid = addslashes($data['postid']);
            $comments = 0;
            $likes = 0;
            $currentDate = date("Y-m-d H:i:s"); // Aktuální datum a čas
            if ($hasImg){
                $query = "UPDATE posts SET post = '$post', image = '$postImg' WHERE postid = '$postid' LIMIT 1";
            }
            else {
                $query = "UPDATE posts SET post = '$post' WHERE postid = '$postid' LIMIT 1";
            }

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
       // Získání informací o příspěvku, včetně cesty k obrázku (pokud existuje)
        $query = "SELECT image, has_image, is_profile_image, is_cover_image FROM posts WHERE postid = '$postid' LIMIT 1";
        $result = $DB->read($query);

        if (is_array($result) && !empty($result[0]['image']) && 
        $result[0]['has_image'] != 1 && 
        $result[0]['is_profile_image'] != 1 &&
        $result[0]['is_cover_image'] != 1) {
        
            // Smazání obrázku, pokud existuje
            $imagePath = $result[0]['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath); // Smazání souboru
        }
    }
        $query = "DELETE FROM posts WHERE postid = '$postid' LIMIT 1";
        $DB->save($query);
        
    }

    public function i_own_post($postid, $krejzik_userid)
    {
        if (!is_numeric( $postid)) {
            return false;
        }
        $DB = new Database();
        $query = "SELECT * FROM posts WHERE postid = '$postid' LIMIT 1";
        $result = $DB->read($query);

        if (is_array($result)){
            if ($result[0]['userid'] == $krejzik_userid){
                return true;
            }
        }
        
        return false;
    }

    public function like_post($id, $type, $krejzik_userid)
    {
        $DB = new Database();

            // Uložit like detaily
            $sql = "SELECT likes FROM likes WHERE type ='$type' && contentid = '$id' LIMIT 1";
            $result = $DB->read($sql);
            if (is_array($result)){

                $likes = json_decode($result[0]['likes'], true);
                
                $userIds = array_column($likes, "userid");
                if (!in_array($krejzik_userid, $userIds)){
                    $arr["userid"] = $krejzik_userid;
                    $arr["date"] = date("Y-m-d H:i:s");
                
                    $likes[] = $arr;
                    $likesString = json_encode($likes);
                    $sql = "UPDATE likes SET likes = '$likesString' WHERE type ='$type' && contentid = '$id' LIMIT 1";
                    $DB->save($sql);

                    // Inkrementace ve spravne tabulce
                    $sql = "UPDATE {$type}s SET likes = likes + 1 WHERE {$type}id = '$id' LIMIT 1";
                    $DB->save($sql);
                }
                else {
                    $key = array_search($krejzik_userid, $userIds);
                    unset($likes[$key]);
                    $likesString = json_encode($likes);
                    $sql = "UPDATE likes SET likes = '$likesString' WHERE type ='$type' && contentid = '$id' LIMIT 1";
                    $DB->save($sql);

                    // Dekrementace ve spravne tabulce
                    $sql = "UPDATE {$type}s SET likes = likes - 1 WHERE {$type}id = '$id' LIMIT 1";
                    $DB->save($sql);
                }
                
            }
            else {
                $arr["userid"] = $krejzik_userid;
                $arr["date"] = date("Y-m-d H:i:s");
                $array[] = $arr;

                // Dání pole do stringu přes json
                $likes = json_encode($array);
                $sql = "INSERT INTO likes (type, contentid, likes) values ('$type', '$id', '$likes')";
                $DB->save($sql);

                // Inkrementace ve spravne tabulce
                $sql = "UPDATE {$type}s SET likes = likes + 1 WHERE {$type}id = '$id' LIMIT 1";
                $DB->save($sql);
            
            }
    }

    public function get_likes($id, $type)
    {
        $DB = new Database();
        if (is_numeric($id))
        {
        
            // Získat detaily o liku na postu
            $sql = "SELECT likes FROM likes WHERE type ='$type' && contentid = '$id' LIMIT 1";
            $result = $DB->read($sql);
            if (is_array($result)){

                $likes = json_decode($result[0]['likes'], true);
                return $likes;
            }   
        }

        return false;
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