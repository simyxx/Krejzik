<?php 
session_start();

include("classes/connect.php");
include("classes/login.class.php");
include("classes/user.class.php");
include("classes/post.class.php");

// Kontrola, zda je uživatel přihlášen
if (isset($_SESSION['krejzik_userid']) && is_numeric($_SESSION['krejzik_userid']))
{
    $id = $_SESSION['krejzik_userid'];
    $login = new Login();
    $result = $login->checkLogin($id);

    if ($result)
    {
        // Získání uživatelských dat
        $user = new User();
        $userData = $user->getData($id);
        
        if (!$userData)
        {
            header("Location: login.php");
            die();
        }

    }
    else
    {
        header("Location: login.php");
        die();
    }
}
else
{
    header("Location: login.php");
    die();
}

// Přihlásil se, postování začne tady

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $post = new Post();
    $id = $_SESSION['krejzik_userid'];
    $result = $post->create_post($id, $_POST);

    if ($result == "")
    {
        header("Location: profile.php");
        die();
    }
    else
    {
                    echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
                    echo "Nastala chyba: <br>";
                    echo $result;
                    echo "</div>";
    }
}

// Získání postů
$post = new Post();
$id = $_SESSION['krejzik_userid'];
$posts = $post->get_posts($id);

// Získání přátel
$user = new User();
$id = $_SESSION['krejzik_userid'];
$friends = $user->getFriends($id);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Krejzik | Profil</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" type="image/png" href="img/silenyvlk.png">
</head>

<style>
    #search-box{
        background-image: url(img/search.png);
        background-repeat: no-repeat;
        background-position: right;
        width: 400px; 
    }

</style>
<body>
    <header>
        <nav class="navbar">
            <a href="index.html" class="nav-logo">
              <img src="img/silenyvlk.png" alt="Logo" class="logo">
              <img src="img/krejzik.png" alt="Logo" class="logotext">
            </a>
            <ul class="nav-menu">
              <li class="nav-item">
                  <form action="" class="search-bar">
                      <input type="text" placeholder="Vyhledejte své známé!">
                  </form>
              </li>
              <li class="nav-item">
                <a href="logout.php">Logout</a>
              </li>
              <li class="nav-item">
                <a href="#" class="pfp-container">
                    <img src="img/pfp.jpg" class="pfp-image" alt="PFP" width="50">
                </a>
              </li>
            </ul>
          </nav>
          <div class="navbar-bottom"></div>
    </header>

    <main>
    <div class="content">
        <div class="cover">
            <img src="img/mountain.jpg" alt="cover img" class="cover-img">
            <img src="img/pfp.jpg" alt="pfp" class="cover-pfp">
            <br>
                <div class="username"><?php echo $userData['username'] ?></div>
            <br>
            <a class="text-grad menu_buttons" href="">Timeline</a>
            <a class="text-grad menu_buttons" href="">About</a>
            <a class="text-grad menu_buttons" href="">Friends</a>
            <a class="text-grad menu_buttons" href="">Photos</a>
            <a class="text-grad menu_buttons" href="">Settings</a>
        </div>

        <div class="below-cover">
            <div class="friends-area">
                <div class="friends-bar">
                    
                    Friends <br>
                    <?php 
                        
                        if ($friends)
                        {
                            foreach($friends as $ROW)
                            {

                                include("user.php");
                            }
                        }        

                    ?>
                    
                </div>
            </div>

            <div class="posts-area">

                <div class="new-feed">
                    <form action="" method="POST">
                    <textarea name="post"placeholder="Co máte na mysli?"></textarea>
                    <button type="submit">PŘIDAT</button>
                </form>
                </div>

                <div class="post-bar">
                  
                    <?php 
                        
                        if ($posts)
                        {
                            foreach($posts as $ROW)
                            {
                                $user = new User();
                                $rowUser = $user->getUser($ROW['userid']);

                                include("post.php");
                            }
                        }        

                    ?>
                    
                </div>

            </div>
        </div>

    </div>
    </main>
    <script>
        document.querySelectorAll('textarea').forEach(el => {
    el.style.height = el.setAttribute('style', 'height: ' + el.scrollHeight + 'px');
    el.classList.add('auto');
    el.addEventListener('input', e => {
        el.style.height = 'auto';
        el.style.height = (el.scrollHeight) + 'px';
    });
});
    </script>
</body>
</html>