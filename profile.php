<?php 
session_start();

include("classes/connect.php");
include("classes/login.class.php");
include("classes/user.class.php");

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

                    <div class="friends">
                        <img class="friends-img" src="img/user1.jpg">
                        <br>
                        <a class="text-grad friends-buttons" href="">First user</a>
                    </div>
                    
                    <div class="friends">
                        <img class="friends-img" src="img/user2.jpg">
                        <br>
                        <a class="text-grad friends-buttons" href="">Second user</a>
                    </div>

                    <div class="friends">
                        <img class="friends-img" src="img/user3.jpg">
                        <br>
                        <a class="text-grad friends-buttons" href="">Third user</a>
                    </div>

                    <div class="friends">
                        <img class="friends-img" src="img/user4.jpg">
                        <br>
                        <a class="text-grad friends-buttons" href="">Fourth user</a>
                    </div>
                </div>
            </div>

            <div class="posts-area">

                <div class="new-feed">
                    <textarea placeholder="Co máte na mysli?"></textarea>
                    <button type="submit">přidat</button>
                </div>

                <div class="post-bar">
                    <div class="post">
                        <div>
                            <img class="post-img" src="img/user1.jpg" alt="pfp">
                        </div>
                        <div>
                            <a class="text-grad post-owner" href="">First guy</a>
                            Lorem Ipsum is simply dummy text of the printing and typesettings industry.  Lorem Ipsum is simply dummy text of the printing and typesettings industry.  
                            Lorem Ipsum is simply dummy text of the printing and typesettings industry.  Lorem Ipsum is simply dummy text of the printing and typesettings industry.
                            <br><br>
                            <a href="">Like</a> . <a href="">Comment</a> . <span style="color:#999;">5. října 2023</span>
                        </div>
                    </div>
                </div>
                <div class="post-bar">
                    <div class="post">
                        <div>
                            <img class="post-img" src="img/user2.jpg" alt="pfp">
                        </div>
                        <div>
                            <a class="text-grad post-owner" href="">Second guy</a>
                            Lorem Ipsum is simply dummy text of the printing and typesettings industry.  Lorem Ipsum is simply dummy text of the printing and typesettings industry.  
                            Lorem Ipsum is simply dummy text of the printing and typesettings industry.  Lorem Ipsum is simply dummy text of the printing and typesettings industry.
                            <br><br>
                            <a href="">Like</a> . <a href="">Comment</a> . <span style="color:#999;">5. října 2023</span>
                        </div>
                    </div>
                </div>    
                <div class="post-bar">
                    <div class="post">
                        <div>
                            <img class="post-img" src="img/user3.jpg" alt="pfp">
                        </div>
                        <div>
                            <a class="text-grad post-owner" href="">Third guy</a>
                            Lorem Ipsum is simply dummy text of the printing and typesettings industry.  Lorem Ipsum is simply dummy text of the printing and typesettings industry.  
                            Lorem Ipsum is simply dummy text of the printing and typesettings industry.  Lorem Ipsum is simply dummy text of the printing and typesettings industry.
                            <br><br>
                            <a href="">Like</a> . <a href="">Comment</a> . <span style="color:#999;">5. října 2023</span>
                        </div>
                    </div>
                </div>
                <div class="post-bar">
                    <div class="post">
                        <div>
                            <img class="post-img" src="img/user4.jpg" alt="pfp">
                        </div>
                        <div>
                            <a class="text-grad post-owner" href="">Fourth guy</a>
                            Lorem Ipsum is simply dummy text of the printing and typesettings industry.  Lorem Ipsum is simply dummy text of the printing and typesettings industry.  
                            Lorem Ipsum is simply dummy text of the printing and typesettings industry.  Lorem Ipsum is simply dummy text of the printing and typesettings industry.
                            <br><br>
                            <a href="">Like</a> . <a href="">Comment</a> . <span style="color:#999;">5. října 2023</span>
                        </div>
                    </div>
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