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

if (isset($_GET['p'])) {
    $ROW = $post->get_single_post($_GET['p']);
    if (!$ROW) {
        $error = "Nebyl nalezen příspěvek!";
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
        <div class="content">
            <form action="" method="post">
                <?php

                if ($error != "") {
                    // MÍSTO PRO VYPISOVÁNÍ ERRORŮ, CSS PRO ERROR TADY 
                    echo $error;
                }

                if ($ROW) {
                    // DESIGN DĚLAT V POST-DELETE.PHP
                    echo "<h2>Chcete smazat tento příspěvek?</h2>";

                    echo "<br>";

                    $user = new User();
                    $rowUser = $user->getUser($ROW['userid']);
                    include("post-delete.php");

                    echo "<br>";

                }
                ?>
                <input type='hidden' name='postid' value='<?php echo $ROW['postid'] ?>'>
                <button type='submit'>Smazat</button>;
            </form>
        </div>
    </main>
</body>

</html>