<div class="post">
    <div>
        <?php
        if (!isset($rowUser)){
            header("Location: index.php");
        }
        $image = "img/profilepic.png";
        if (file_exists($rowUser['profile_image'])) {
            $image = $rowUser['profile_image'];
        }
        $timestamp = $COMMENT['date'];

        ?>
        <a href="profile.php?id=<?php echo $COMMENT['userid']?>"><img class="post-img" src="<?php echo $image ?>" alt="pfp"></a>
    </div>
    <div>
        <a class="text-grad post-owner" href="profile.php?id=<?php echo $COMMENT['userid']?>">
            <?php
            if ($COMMENT['is_profile_image'] || $COMMENT['is_cover_image']){
                echo "Uživatel ";
            }
                 echo htmlspecialchars($rowUser['username']);
            if ($COMMENT['is_profile_image']) {
                echo "<span style='font-weight:normal;color:rgb(238, 137, 94);'> si změnil profilovou fotku!</span>";
            } else if ($COMMENT['is_cover_image']) {
                echo "<span style='font-weight:normal;color:rgb(238, 137, 94);'> si změnil náhledovou fotku!</span>";
            }
            ?>
        </a>
        <div class="post-text">
        <?php
        echo htmlspecialchars($COMMENT['post']);
        ?>
        </div>
        <br><br>
        <?php
        if (file_exists($COMMENT['image'])) {
            $postImg = $COMMENT['image'];
            echo "<img src='$postImg' alt='obrázek z příspěvku' style='width:25%;'>";
        }
        ?>
        <br><br>

        <?php 
            $likes = "";

            $likes = $COMMENT['likes'] > 0 ? "(" .  $COMMENT['likes'] . ")" : "";
        ?>
        <a href="like.php?type=post&id=<?php echo $COMMENT['postid'] ?>">Like<?php echo $likes ?></a> .
        <span style="color:#999;">
            <?php echo date('d/m/Y', strtotime($timestamp)); ?>
        </span>
        <span style="color:#999;margin-left:15px">
        <?php
        $post = new Post();
        if ($post->i_own_post($COMMENT['postid'], $_SESSION['krejzik_userid'])){
        echo "
           <a href='edit.php?id=$COMMENT[postid]'>Upravit</a>
            . 
            <a href='delete.php?id=$COMMENT[postid]'>Smazat</a>";
        }
        ?>
        </span>

        <?php
            
        $iLiked = false;
        if (isset($_SESSION['krejzik_userid']))
        {

            // Zobrazování kdo dal like na příspěvek
            $sql = "SELECT likes FROM likes WHERE type ='post' && contentid = '$COMMENT[postid]' LIMIT 1";
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
        if ($COMMENT['likes'] > 0){
            echo "<a href='likes.php?type=post&id=$COMMENT[postid]'>";
            if ($COMMENT['likes'] == 1){
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
                    if($COMMENT['likes'] == 2)
                    {
                        echo "<br>";
                        echo "<span class=''>" . "Vám a 1 uživateli se líbí!" .  "</span>";
                    }
                    else {
                        echo "<br>";
                        echo "<span class=''>" . "Vám a " . ($COMMENT['likes'] - 1) . " se líbí!" .  "</span>";
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
       


    </div>
</div>