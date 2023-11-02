
    <!-- Stylovani pres class tohohle divu (idealne treba class photo-area ;3 [a pro kazdej profile-content soubor vlastni classu s takhle odlisnym nazvem ;3]) -->
<div class="posts-area">
<?php 

    $Image = new Image();
    $Post = new Post();
    $User = new User();
    $following = $User->get_following($userData['userid'], "user");

    if (is_array($following)) 
    {
        foreach ($following as $follower){
            if (isset($follower['userid'])) {
                $ROW = $User->getUser($follower['userid']);
                if (is_array($ROW) && isset($ROW['userid'])) {
                    include("user.php");
                }
            }
        }
        
    }
    else 
    {
        echo "Uživatel nikoho nesleduje.";
    }

?>
</div>