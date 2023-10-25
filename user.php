<?php
$image = "img/profilepic.png";
if (file_exists($ROW['profile_image'])) {
    $image = $ROW['profile_image'];
}
?>

<div class="friends">
    <a href="profile.php?id=<?php echo $ROW['userid']; ?>">
        <img class="friends-img" src="<?php echo $image ?>">
        <br>
        <a class="text-grad friends-buttons" href="profile.php?id=<?php echo $ROW['userid']; ?>">
            <?php echo $ROW['username'] ?>
        </a>
    </a>
</div>