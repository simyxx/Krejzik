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
    <meta name="description" content="Zjistěte, komu se líbí již dnes a poznejte nové lidi na sociální síťi Krejzik!">
    <meta name="keywords" content="Crazy Wolf, Krejzik, Krejzac, socialni sit, social media, sociální síť">
    <link rel="canonical" href="https://krejzik.cz/profile.php" />
    <title>Krejzik | Příspěvek</title>
    <link rel="stylesheet" href="styles.css">
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
                    include("comment.php");
                }
            }

        ?></div>
    </main>
</body>

</html>