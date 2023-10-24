<?php

include("classes/autoloader.php");

// Je přihlášen?
if (!isset($_SESSION['krejzik_userid'])) {
    // Pokud uživatel není přihlášen, provedete přesměrování na jinou stránku
    header("Location: login.php");
    exit;
}

$profile = new Profile();
$profileData = $profile->getProfile($_GET['id']);

// Získaní username
$user = new User();
$userData = $user->getData($_SESSION['krejzik_userid']);

if (is_array($profileData)) {
    $userData = $profileData[0];
}
// Přihlásil se, postování začne tady

if ($_SERVER['REQUEST_METHOD'] == "POST") {
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

// Získání postů
$post = new Post();
$id = $userData['userid'];
$posts = $post->get_posts($id);

// Získání přátel
$user = new User();
$id = $userData['userid'];
$friends = $user->getFriends($id);

$imageClass = new Image();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Krejzik | Profil</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                </span>
                <br>
                <div class="username">
                    <?php echo $userData['username']; ?>
                </div>
                <br>
                <a class="text-grad menu_buttons" href="index.php">Timeline</a>
                <a class="text-grad menu_buttons" href="">About</a>
                <a class="text-grad menu_buttons" href="">Friends</a>
                <a class="text-grad menu_buttons" href="">Photos</a>
                <a class="text-grad menu_buttons" href="">Settings</a>
            </div>

            <div class="below-cover">
                <div class="friends-area">
                    <div class="friends-bar">

                        <p style="text-align:center;font-size: 18px;margin-bottom:20px;">Friends</p>
                        <?php

                        if ($friends) {
                            foreach ($friends as $ROW) {
                                $friend = new User();
                                $friendRow = $friend->getUser($ROW['userid']);
                                include("user.php");
                            }
                        }

                        ?>

                    </div>
                </div>

                <div class="posts-area">

                    <div class="new-feed">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            <textarea name="post" placeholder="Co máte na mysli?"
                                style="word-wrap: break-word;"></textarea>
                            <input type="file" name="file">
                            <button style="margin-top:20px;" type="submit">PŘIDAT</button>
                        </form>
                    </div>



                    <?php

                    if ($posts) {
                        echo '<div class="post-bar">';
                        foreach ($posts as $ROW) {
                            $user = new User();
                            $rowUser = $user->getUser($ROW['userid']);

                            include("post.php");
                        }
                        echo '</div>';
                    }

                    ?>



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