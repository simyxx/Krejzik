
    <!-- Stylovani pres class tohohle divu (idealne treba class photo-area ;3 [a pro kazdej profile-content soubor vlastni classu s takhle odlisnym nazvem ;3]) -->
<div class="posts-area">
<?php 



  $Settings = new Settings();
  $settings = $Settings->get_settings($_GET['id']);

    if (is_array($settings))
    {
        echo "<div class='aboutme'>";
        echo "<h3>O mně</h3>";
        echo htmlspecialchars($settings['about']);
        echo "</div>";

    }
 ?> 

</div>