<div class="post">
    <div>
        <?php
        $image = "img/profilepic.png";
        if (file_exists($rowUser['profile_image'])) {
            $image = $rowUser['profile_image'];
        }
        $timestamp = $ROW['date'];

        ?>
        <img class="post-img" src="<?php echo $image ?>" alt="pfp">
    </div>
    <div>
        <a class="text-grad post-owner" href="">
            <?php
            if ($ROW['is_profile_image'] || $ROW['is_cover_image']){
                echo "Uživatel ";
            }
                 echo $rowUser['username'];
            if ($ROW['is_profile_image']) {
                echo "<span style='font-weight:normal;color:rgb(238, 137, 94);'> si změnil profilovou fotku!</span>";
            } else if ($ROW['is_cover_image']) {
                echo "<span style='font-weight:normal;color:rgb(238, 137, 94);'> si změnil náhledovou fotku!</span>";
            }
            ?>
        </a>
        <div class="post-text">
        <?php
        echo $ROW['post'];
        ?>
        </div>
        <br><br>
        <?php
        if (file_exists($ROW['image'])) {
            $postImg = $ROW['image'];
            echo "<img src='$postImg' alt='obrázek z příspěvku' style='width:100%;'>";
        }
        ?>
        <br><br>
        <a href="">Like</a> . <a href="">Comment</a> .
        <span style="color:#999;">
            <?php echo date('d/m/Y', strtotime($timestamp)); ?>
        </span>
        <span style="color:#999;margin-left:15px">
            Upravit . Smazat
        </span>
    </div>
</div>