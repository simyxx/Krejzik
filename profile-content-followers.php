
    <!-- Stylovani pres class tohohle divu (idealne treba class photo-area ;3 [a pro kazdej profile-content soubor vlastni classu s takhle odlisnym nazvem ;3]) -->
<div class="posts-area">
<?php 

    $Image = new Image();
    $Post = new Post();
    $User = new User();
    $followers = $Post->get_likes($userData['userid'], "user");

    if (is_array($followers)) 
    {
        foreach ($followers as $follower){
            $ROW = $User->getUser($follower['userid']);
            include("user.php");
        }
        
    }
    else 
    {
        echo "Uživatele nikdo nesleduje.";
    }

?>
</div>