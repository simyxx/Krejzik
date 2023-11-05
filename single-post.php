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

$ROW = false;
$post = new Post();

$error = "";
if (isset($_GET['id'])) {
    $ROW = $post->get_single_post($_GET['id']);
} else {
    $error = "Žádné informace nebyly nalezeny!";
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $post = new Post();
    $id = $_SESSION['krejzik_userid'];

    // Pokud uživatel neposkytl soubor, můžete zde provést jinou akci nebo zpracování textového příspěvku
    $result = $post->create_post($id, $_POST, $_FILES);

    if ($result == "") {
        header("Location: ".$_SERVER['HTTP_REFERER']);
        die();
    } else {
        echo "<div  style='text-align:center;font-size:18px;color:white;background-color:#F16529;'>";
        echo "Nastala chyba: <br>";
        echo $result;
        echo "</div>";
    }
}

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
    <link rel="icon" type="image/png" href="img/silenyvlk.png">

</head>

<style>
    .person-liked {
        text-align: center;
    }
</style>

<body>
    <?php
    include("header.php");
    ?>

    <main>
        <div class="contentsecond">

        
            <?php

            if (is_array($ROW)) {
                $rowUser = $user->getUser($ROW['userid']);
                include("post.php");

            }
            ?>
        
        <div class="new-feed">
            <form action="#" method="POST" enctype="multipart/form-data">
                <textarea name="post" placeholder="Co si o příspěvku myslíte?"
                    style="word-wrap: break-word;"></textarea>
                <input type="file" name="file">
                <input type="hidden" name="parent" value="<?php echo $ROW['postid'] ?>">
                <button style="margin-top:20px;" type="submit">PŘIDAT</button>
            </form>
        </div>
        
        
        <?php 
            $comments = $post->get_comments($ROW['postid']);
            if (is_array($comments)){
                foreach ($comments as $COMMENT) {
                    $rowUser = $user->getUser($COMMENT['userid']);
                    include("comment.php");
                }
            }

        ?></div>
    </main>
</body>

</html>