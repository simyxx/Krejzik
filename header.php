<?php 

// Je přihlášen?
if (!isset($_SESSION['krejzik_userid'])) {
  // Pokud uživatel není přihlášen, provedete přesměrování na jinou stránku
  header("Location: login.php");
  exit;
}

$profilePic = "img/profilepic.png";
if (isset($USER) && file_exists($USER['profile_image']))
{
  $profilePic = $USER['profile_image'];
}

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<header>
        <nav class="navbar">
            <a href="index.php" class="nav-logo">
              <img src="img/silenyvlk.png" alt="Logo" class="logo">
              <img src="img/krejzik.png" alt="Logo" class="logotext">
            </a>
            <ul class="nav-menu">
              <li class="nav-item">
                <div class="box">
                    <form action="search.php" method="get" name="search">
                        <input type="text" class="input" name="find" onmouseout="this.value = ''; this.blur();">
                    </form>
                    <i class="search-icon fa fa-search" style="color: #F16529;"></i>
                </div>
              </li>
              <li class="nav-item">
                <a href="logout.php" class="text-grad">Odhlásit</a>
              </li>
              <li class="nav-item">
                <a href="profile.php" class="pfp-container">
                    <img src="<?php echo $profilePic ?>" class="pfp-image" alt="PFP" width="50">
                </a>
              </li>
            </ul>
        </nav>
        <div class="navbar-bottom"></div>
</header>