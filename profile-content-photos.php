
    <!-- Stylovani pres class tohohle divu (idealne treba class photo-area ;3 [a pro kazdej profile-content soubor vlastni classu s takhle odlisnym nazvem ;3]) -->
<div class="posts-area">
<?php 

    $DB = new Database();
    $sql = "SELECT image, postid FROM posts WHERE has_image = 1 && userid =  $userData[userid] ORDER BY id DESC LIMIT 30";
    $images = $DB->read($sql);

    $Image = new Image();

    if (is_array($images)) 
    {
        foreach ($images as $imageRow){
            echo "<img src='" . $Image->getThumbnailCover($imageRow['image']) . "' alt='' style='width:150px;'>"; 
        }
        
    }
    else 
    {
        echo "Uživatel nenahrál žádné obrázky!";
    }

?>
</div>