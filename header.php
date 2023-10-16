<?php 

$profilePic = "/img/search.png";
if (isset($userData))
{
  $profilePic = $userData['profile_image'];
}

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<header>
        <nav class="navbar">
            <a href="index.html" class="nav-logo">
              <img src="img/silenyvlk.png" alt="Logo" class="logo">
              <img src="img/krejzik.png" alt="Logo" class="logotext">
            </a>
            <ul class="nav-menu">
              <li class="nav-item">
                <div class="box">
                    <form action="" name="search">
                        <input type="text" class="input" name="txt" onmouseout="this.value = ''; this.blur();">
                    </form>
                    <i class="search-icon fa fa-search" style="color: #F16529;"></i>
                </div>
              </li>
              <li class="nav-item">
                <a href="logout.php" class="text-grad">Logout</a>
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