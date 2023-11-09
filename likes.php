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

$likes = false;
$post = new Post();
$error = "";
if (isset($_GET['id']) && isset($_GET['type'])) {
    $likes = $post->get_likes($_GET['id'], $_GET['type']);
} 
else 
{
    header("Location: index.php");
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
    .person-liked
    {
        text-align: center;
    }
</style>

<body>
    <?php
    include("header.php");
    ?>

    <main>
        <div class="contentsecond">
        <h3>Příspěvek se libí:</h3>
                <?php

                $User = new User();

                    if (is_array($likes)){
                        ?>
 
                        <!-- Stylování jednoho zobrazenýho uživatele v tomhle divu  -->
                        <div class="kokoti">
                        <?php
                        foreach ($likes as $row) {   
                            $ROW = $User->getUser($row['userid']); 
                            include("user.php");
                        }
                    }                
                ?>
                        </div>

        </div>
    </main>
</body>

</html>