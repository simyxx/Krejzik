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
                // Přesměrování pokud vše proběhlo v pořádku
                header("Location: index.php");
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
            header("Location: index.php");
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
$id = $_SESSION['krejzik_userid'];
$posts = $post->get_posts($id);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Krejzik | Timeline</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" type="image/png" href="img/silenyvlk.png">
</head>

<body>
    <?php 
    include("header.php");
    ?>

    <main>
    <div class="content">
        
        <div id="below-cover">
            <div class="posts-area">

            <div class="new-feed">
            <form action="#" method="POST" enctype="multipart/form-data">
                            <textarea name="post" placeholder="Co máte na mysli?"
                                style="word-wrap: break-word;"></textarea>
                            <input type="file" name="file">
                            <button style="margin-top:20px;" type="submit">PŘIDAT</button>
                        </form>
                </div>

                <div class="post-bar">
                  
                        <?php

                        if ($posts) {
                            foreach ($posts as $ROW) {
                                $user = new User();
                                $rowUser = $user->getUser($ROW['userid']);

                                echo '<div style="justify-content: center;">';
                                include("post.php");
                                echo '</div>';
                            }
                        }

                        ?>
                </div>

            </div>
        </div>

    </div>
    </main>
</body>
</html>
