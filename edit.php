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

$post = new Post();
$error = "";

if (isset($_GET['id'])) {
    $ROW = $post->get_single_post($_GET['id']);
    if (!$ROW) {
        $error = "Nebyl nalezen příspěvek!";
    }
    else 
    {
        if ($ROW['userid'] != $_SESSION['krejzik_userid']){
            $error = "Přístup zamítnut.";
        }
    }

} else {
    $error = "Nebyl nalezen příspěvek!";
}

// Navrácení na stránku, kde uživatel byl předtím
$_SESSION['returnTo'] = "profile.php";
if (isset($_SERVER['HTTP_REFERER']) && !strstr($_SERVER['HTTP_REFERER'], "edit.php")){
$_SESSION['returnTo'] = $_SERVER['HTTP_REFERER'];
}

// Něco bylo postnuto

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $result = $post->edit_post($_POST, $_FILES);
    if (!$post->postWordsNotTooLong($_POST['post'])) {
        echo "<div  style='text-align:center;font-size:18px;color:white;background-color:#F16529;'>";
            echo "Přidejte něco správného!<br>";
            echo "</div>";
    } else {
        // Přesměrování na návratovou adresu
        header("Location: " . $_SESSION['returnTo']);
        exit();
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

<body>
    <?php
    include("header.php");
    ?>

    <main>
        <div class="contentsecond">
            <form action="" method="post" enctype="multipart/form-data">
                <?php

                if ($error != "") {
                    // Místo pro vypsání errorů, styly na cssko do divu
                    echo "<div>"; 
                    echo $error;
                    echo "</div>";
                }

                else if ($ROW) {
                    // Design toho jednoho postu co se ukáže v post-delete.php
                    echo "<h2>Upravte svůj příspěvek!</h2>";

                    echo "<br>";

                    echo '<textarea name="post" placeholder="Co máte na mysli?"
                    style="word-wrap: break-word;">' . $ROW['post'] .  '</textarea>
                    <input type="file" name="file">';

                    echo "<br>";
                    if (file_exists($ROW['image'])) {
                        $postImg = $ROW['image'];
                        echo "<div style='text-align:center;'><img src='$postImg' alt='obrázek z příspěvku' style='width:50%;'></div>";
                    }
                    echo "<br>";
                    echo "<input type='hidden' name='postid' value='$ROW[postid]'>";
                    echo"<button type='submit'>Uložit</button>";

                    

                }
                ?>
            </form>
        </div>
    </main>
</body>

</html>