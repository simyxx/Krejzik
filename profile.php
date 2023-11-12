<?php

include("classes/autoloader.php");

// Je přihlášen?
if (!isset($_SESSION['krejzik_userid'])) {
    // Pokud uživatel není přihlášen, provedete přesměrování na jinou stránku
    header("Location: login.php");
    exit;
}

// Získaní username
$user = new User();
$userData = $user->getData($_SESSION['krejzik_userid']);

$USER = $userData; // Přihlášený uživatel a jeho data

if (isset($_GET['id']) && is_numeric($_GET['id'])){
    $profile = new Profile();
    $profileData = $profile->getProfile($_GET['id']);
    if (is_array($profileData)) {
        $userData = $profileData[0];
    }
}

// Přihlásil se, postování začne tady

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    if(isset($_POST['username'])){

        $settingsError = "";
        $password = $_POST['password'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $Signup = new Signup();
        if (!$Signup->isPasswordStrongEnough($password))
        {
            $settingsError .= "Heslo není dostatečně silné!<br>";
        }
        if ($password != $_POST['password-again'])
        {
            $settingsError .= "Hesla nejsou stejná!<br>";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $settingsError .= "Zadejte opravdový e-mail!<br>";
        }
        if (!ctype_alpha($username))
        {
            $settingsError .= "Zadejte přezdívku obsahující pouze písmena!<br>";
        }


        if ($settingsError == "") {
            $Settings = new Settings();
            $Settings->save_settings($_POST, $_SESSION['krejzik_userid']);
        }
        else 
        {
            echo "<div  style='text-align:center;font-size:18px;color:white;background-color:#F16529;'>";
            echo "Nastala chyba: <br>";
            echo $settingsError;
            echo "</div>";
        }
       

    }
    else {
        $post = new Post();
    $id = $_SESSION['krejzik_userid'];

    // Zkontrolovat, zda byl nahrán soubor
    if (isset($_FILES['file']) && $_FILES['file']['name'] != "") {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $maxFileSize = 5 * 1024 * 1024; // 5 MB

        // Získání informací o nahrávaném souboru
        $uploadedFile = $_FILES['file'];
        $fileName = $uploadedFile['name'];
        $fileSize = $uploadedFile['size'];
        $fileTmpName = $uploadedFile['tmp_name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Zkontrolovat povolené typy souborů a maximální velikost
        if (in_array($fileExtension, $allowedExtensions) && $fileSize <= $maxFileSize) {
            $result = $post->create_post($id, $_POST, $_FILES);

            if ($result == "") {
                // Přesměrování na profil, pokud vše proběhlo v pořádku
                header("Location: profile.php");
                die();
            } else {
                echo "<div  style='text-align:center;font-size:18px;color:white;background-color:#F16529;'>";
                echo "Nastala chyba: <br>";
                echo $result;
                echo "</div>";
            }
        } else {
            echo "<div  style='text-align:center;font-size:18px;color:white;background-color:#F16529;'>";
            echo "Špatný typ souboru (povolené: jpg, jpeg, png, gif) nebo překročená maximální povolená velikost (5 MB).";
            echo "</div>";
        }
    } else {
        // Pokud uživatel neposkytl soubor, můžete zde provést jinou akci nebo zpracování textového příspěvku
        $result = $post->create_post($id, $_POST, $_FILES);

        if ($result == "") {
            header("Location: profile.php");
            die();
        } else {
            echo "<div  style='text-align:center;font-size:18px;color:white;background-color:#F16529;'>";
            echo "Nastala chyba: <br>";
            echo $result;
            echo "</div>";
        }
    }
    }
    
}

// Získání postů
$post = new Post();
$id = $userData['userid'];
$posts = $post->get_posts($id);

// Získání přátel
$user = new User();
$id = $userData['userid'];
$friends = $user->get_following($userData['userid'], "user");

$imageClass = new Image();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Crazy Wolf, Krejzik, Krejzac, socialni sit, social media, sociální síť">
    <link rel="canonical" href="https://krejzik.cz/"/>
    <!-- Primary Meta Tags -->
    <title>Krejzik | Poznejte nové lidi!</title>
    <meta name="title" content="Krejzik | Poznejte nové lidi!" />
    <meta name="description" content="Přidejte se k uživatelům sociální sítě Krejzik a poznejte hromady nových lidí se stejnými zájmy!" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="krejzik.cz" />
    <meta property="og:title" content="Krejzik | Poznejte nové lidi!" />
    <meta property="og:description" content="Přidejte se k uživatelům sociální sítě Krejzik a poznejte hromady nových lidí se stejnými zájmy!" />
    <meta property="og:image" content="img/silenyvlk.png" />

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="krejzik.cz" />
    <meta property="twitter:title" content="Krejzik | Poznejte nové lidi!" />
    <meta property="twitter:description" content="Přidejte se k uživatelům sociální sítě Krejzik a poznejte hromady nových lidí se stejnými zájmy!" />
    <meta property="twitter:image" content="img/silenyvlk.png" />
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="icon" type="image/png" href="img/silenyvlk.png">

</head>

<body>
    <?php
    include("header.php");
    ?>

    <main>
        <div class="content">
            <div class="cover">
                <?php

                $image = "img/placeholder.png";
                if (file_exists($userData['cover_image'])) {
                    $image = $userData['cover_image'];
                }

                ?>
                <a href="change-pfp.php?change=cover">
                    <img src="<?php echo $image ?>" alt="cover img" class="cover-img">
                </a>
                <span>
                    <?php

                    $image = "img/profilepic.png";
                    if (file_exists($userData['profile_image'])) {
                        $image = $userData['profile_image'];
                    }

                    ?>
                    <a href="change-pfp.php?change=profile">
                        <img src="<?php echo $image ?>" alt="pfp" class="cover-pfp"><br>
                    </a>

                    <?php
                        $myLikes = $userData['likes'];
                    ?>

                    <?php if ($userData['userid'] != $_SESSION['krejzik_userid'])
                    {
                    ?>
                    
                    <?php 
                    }
                    ?>
                </span>
                <br>
                <a href="profile.php?id=<?php echo $userData['userid'] ?>">
                    <div class="username">
                        <?php echo $userData['username']; ?>
                    </div>
                </a>
                
                <br>
                <a class="text-grad menu_buttons" style="margin-bottom:20px;" href="profile.php?section=default&id=<?php echo $userData['userid'] ?>">Příspěvky</a>
                <a class="text-grad menu_buttons" href="profile.php?section=about&id=<?php echo $userData['userid'] ?>">O uživateli</a>
                <a class="text-grad menu_buttons" href="profile.php?section=followers&id=<?php echo $userData['userid'] ?>">Sledující (<?php echo $myLikes ?>)</a>
                <a class="text-grad menu_buttons" href="profile.php?section=following&id=<?php echo $userData['userid'] ?>">Sleduje</a>
                <a class="text-grad menu_buttons" href="profile.php?section=photos&id=<?php echo $userData['userid'] ?>">Fotky</a>
                <?php 
                if ($userData['userid'] == $_SESSION['krejzik_userid'])
                {
                    echo '<a class="text-grad menu_buttons" href="profile.php?section=settings&id='.$userData['userid'] .'">Nastavení</a>';
                }
                else 
                {
                    $followingUser = $user->amIFollowingUser($_SESSION['krejzik_userid'], $userData['userid']); 
                    if (!$followingUser){
                        echo '<a class="follow"href="like.php?type=user&id='. $userData['userid'].'"><i class="fa-regular fa-user"></i>Sledovat</a>';
                    }
                    else {
                        echo '<a class="follow"href="like.php?type=user&id='. $userData['userid'].'"> <i class="fa-solid fa-user"></i>Odebrat</a>';
                    }
                }
                ?>
            </div>

            <?php 

                $section = "default";
                if (isset($_GET['section']))
                {
                    $section = $_GET['section'];

                }

                if ($section == "default"){
                    include("profile-content-default.php");
                }
                else if ($section == "photos"){
                    include("profile-content-photos.php");
                }
                else if ($section == "followers"){
                    include("profile-content-followers.php");
                }
                else if ($section == "following"){
                    include("profile-content-following.php");
                }
                else if ($section == "settings"){
                    include("profile-content-settings.php");
                }
                else if ($section == "about"){
                    include("profile-content-about.php");
                }
                
            ?>

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