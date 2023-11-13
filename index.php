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
    <meta name="keywords" content="Crazy Wolf, Krejzik, Krejzac, socialni sit, social media, sociální síť">
    <link rel="canonical" href="https://krejzik.cz/" />
    <!-- Primary Meta Tags -->
    <title>Krejzik | Poznejte nové lidi!</title>
    <meta name="title" content="Krejzik | Poznejte nové lidi!" />
    <meta name="description"
        content="Přidejte se k uživatelům sociální sítě Krejzik a poznejte hromady nových lidí se stejnými zájmy!" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="krejzik.cz" />
    <meta property="og:title" content="Krejzik | Poznejte nové lidi!" />
    <meta property="og:description"
        content="Přidejte se k uživatelům sociální sítě Krejzik a poznejte hromady nových lidí se stejnými zájmy!" />
    <meta property="og:image" content="img/silenyvlk.png" />

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="krejzik.cz" />
    <meta property="twitter:title" content="Krejzik | Poznejte nové lidi!" />
    <meta property="twitter:description"
        content="Přidejte se k uživatelům sociální sítě Krejzik a poznejte hromady nových lidí se stejnými zájmy!" />
    <meta property="twitter:image" content="img/silenyvlk.png" />
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

            <div id="below-cover">
                <div class="posts-area">

                    <div class="new-feed" style="margin-top:100px">
                        <form id="postForm" action="#" method="POST" enctype="multipart/form-data">
                            <textarea id="postText" name="post" placeholder="Co máte na mysli?" style="word-wrap: break-word;"
                                oninput="updateCharacterCount()"></textarea>
                            <div id="charCount" style="float:right;">0/300</div>
                            <input type="file" name="file">
                            <button style="margin-top:20px;" type="submit">PŘIDAT</button>
                    	</form>
                    </div>

                    <div class="post-bar">
                        <?php
                        
                        // Pagination logika
                        $pageNumber = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
                        $pageNumber = ($pageNumber < 1) ? 1 : $pageNumber;

                        $pg = PaginationLink();

                        $limit = 10;
                        $offset = ($pageNumber - 1) * $limit;

                        
                        $DB = new Database();
                        $User = new User();
                        $followers = $User->get_following($_SESSION['krejzik_userid'], "user");
                        $followerIds = false;
                        if (is_array($followers)) {
                            $followerIds = array_column($followers, "userid");
                            $followerIds = implode("','", $followerIds);
                        }
                        if ($followerIds) {
                            $myUserId = $_SESSION['krejzik_userid'];
                            $sql = "SELECT * FROM posts WHERE parent = 0 AND (userid = '$myUserId' || userid IN('" . $followerIds . "')) ORDER BY ID DESC LIMIT $limit OFFSET $offset";
                            $posts = $DB->read($sql);
                        }

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
                        
                        <a href="<?= $pg['nextPage'] ?>"><button style="float:right;"
                                type="button">Dále</button></a>
                        <a href="<?= $pg['prevPage'] ?>"><button style="float:left"
                                type="button">Zpět</button></a>
 
                    </div>

                </div>
            </div>
		<script>
                    function updateCharacterCount() {
                        var text = document.getElementById('postText').value;
                        var charCount = text.length;

                        // Omezení délky textu na 300 znaků
                        if (charCount > 300) {
                            document.getElementById('postText').value = text.substring(0, 300);
                            charCount = 300;
                        }

                        document.getElementById('charCount').innerText = charCount + '/300';
                        }
            	</script>
        </div>
    </main>
</body>

</html>