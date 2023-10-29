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
    $error = "Žádné informace nebyly nalezeny!";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Krejzik | Komu se líbí</title>
    <link rel="stylesheet" href="styles.css">
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
           
                <?php

                $User = new User();

                    if (is_array($likes)){
                        ?>
 
                        <!-- Stylování jednoho zobrazenýho uživatele v tomhle divu  -->
                        <div>
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