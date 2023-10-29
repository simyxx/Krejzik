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

// Něco bylo postnuto

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $result = $post->delete_post($_POST['postid']);
    header("Location:profile.php");
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
        <div class="contentsecond">
            <form action="" method="post">
                <?php

                if ($error != "") {
                    // Místo pro vypsání errorů, styly na cssko do divu
                    echo "<div>"; 
                    echo $error;
                    echo "</div>";
                }

                else if ($ROW) {
                    // Design toho jednoho postu co se ukáže v post-delete.php
                    echo "<h2>Opravdu chcete smazat tento příspěvek?</h2>";

                    echo "<br>";

                    $user = new User();
                    $rowUser = $user->getUser($ROW['userid']);
                    include("post-delete.php");

                    echo "<br>";

                    echo "<input type='hidden' name='postid' value='$ROW[postid]'>";
                    echo"<button type='submit'>Smazat</button>";

                }
                ?>
            </form>
        </div>
    </main>
</body>

</html>