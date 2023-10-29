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

    
    header("Location: " . $_SESSION['returnTo']);
    die();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Krejzik | Smazat</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" type="image/png" href="img/silenyvlk.png">
</head>

<body>
    <?php
    include("header.php");
    ?>

    <main>
        <div class="content">
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