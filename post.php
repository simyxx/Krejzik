<div class="post">
    <div>
        <?php
        $image = "img/profilepic.png";
        if (file_exists($rowUser['profile_image'])) {
            $image = $rowUser['profile_image'];
        }
        $timestamp = $ROW['date'];

        ?>
        <a href="profile.php?id=<?php echo $ROW['userid']?>"><img class="post-img" src="<?php echo $image ?>" alt="pfp"></a>
    </div>
    <div>
        <a class="text-grad post-owner" href="profile.php?id=<?php echo $ROW['userid']?>">
            <?php
            if ($ROW['is_profile_image'] || $ROW['is_cover_image']){
                echo "Uživatel ";
            }
                 echo htmlspecialchars($rowUser['username']);
            if ($ROW['is_profile_image']) {
                echo "<span style='font-weight:normal;color:rgb(238, 137, 94);'> si změnil profilovou fotku!</span>";
            } else if ($ROW['is_cover_image']) {
                echo "<span style='font-weight:normal;color:rgb(238, 137, 94);'> si změnil náhledovou fotku!</span>";
            }
            ?>
        </a>
        <div class="post-text">
        <?php
        echo htmlspecialchars($ROW['post']);
        ?>
        </div>
        <br><br>
        <?php
        if (file_exists($ROW['image'])) {
            $postImg = $ROW['image'];
            echo "<a class='zoomable-image' href='$postImg' target='_blank'>";
            echo "<img src='$postImg' alt='obrázek z příspěvku' style='width:95%;border-radius:10px;'>";
            echo "</a>";
        }
        ?>
        <br><br>

        <?php 
            $likes = "";
            $comments = "(". 0 .")";
            if ($ROW['comments'] > 0){
                $comments = "(".$ROW['comments']. ")";
            }
            $likes = $ROW['likes'] > 0 ? "(" .  $ROW['likes'] . ")" : "";
        ?>
        <a href="like.php?type=post&id=<?php echo $ROW['postid'] ?>">Like<?php echo $likes ?></a> . <a href="single-post.php?id=<?php echo $ROW['postid'] ?>">Komentáře<?php echo $comments ?></a> .
        <span style="color:#999;">
            <?php echo date('d/m/Y', strtotime($timestamp)); ?>
        </span>
        <span style="color:#999;margin-left:15px">
        <?php
        $post = new Post();
        if ($post->i_own_post($ROW['postid'], $_SESSION['krejzik_userid'])){
        echo "
           <a href='edit.php?id=$ROW[postid]'>Upravit</a>
            . 
            <a href='delete.php?id=$ROW[postid]'>Smazat</a>";
        }
        ?>
        </span>

        <?php
            
        $iLiked = false;
        if (isset($_SESSION['krejzik_userid']))
        {

            // Zobrazování kdo dal like na příspěvek
            $sql = "SELECT likes FROM likes WHERE type ='post' && contentid = '$ROW[postid]' LIMIT 1";
            $result = $DB->read($sql);
            if (is_array($result))
            {
                $likes = json_decode($result[0]['likes'], true);
                $userIds = array_column($likes, "userid");
                if (in_array($_SESSION['krejzik_userid'], $userIds))
                {
                    $iLiked = true;
                }
            }
        }
        
        
        // Stylování přidat přes styly do spanu
        if ($ROW['likes'] > 0){
            echo "<a href='likes.php?type=post&id=$ROW[postid]'>";
            if ($ROW['likes'] == 1){
                if ($iLiked){
                    echo "<br>";
                    echo "<span class=''>" . "Vám se líbí! " . "</span>";
                }
                else{
                    echo "<br>";
                    echo "<span class=''>" . "1 uživateli se líbí!" . "</span>";
                }
                
            }
            else {
                if ($iLiked){
                    if($ROW['likes'] == 2)
                    {
                        echo "<br>";
                        echo "<span class=''>" . "Vám a 1 uživateli se líbí!" .  "</span>";
                    }
                    else {
                        echo "<br>";
                        echo "<span class=''>" . "Vám a " . ($ROW['likes'] - 1) . " se líbí!" .  "</span>";
                    } 
                }
                else{
                    echo "<br>";
                    echo "<span class=''>" . "1 uživateli se líbí!" . "</span>";
                }
            }
           
        }
        echo "</a>";
        ?>
<script>
    const zoomableImages = document.querySelectorAll('.zoomable-image');

    zoomableImages.forEach(image => {
        image.addEventListener('click', (e) => {
            e.preventDefault();
            const imageUrl = image.getAttribute('href');
            const enlargedImage = new Image();
            enlargedImage.src = imageUrl;
            enlargedImage.style.maxWidth = '80%';
            enlargedImage.style.maxHeight = '80%';
            enlargedImage.style.position = 'fixed';
            enlargedImage.style.top = '50%';
            enlargedImage.style.left = '50%';
            enlargedImage.style.transform = 'translate(-50%, -50%)';
            enlargedImage.style.zIndex = '999';

            enlargedImage.addEventListener('click', () => {
                document.body.removeChild(enlargedImage);
            });

            document.body.appendChild(enlargedImage);
        });
    });
</script>

    </div>
</div>