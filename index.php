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
            <div id="friends-area">
                <div id="friends-bar">
                    <?php

                    $image = "img/profilepic.png";
                    if (file_exists($userData['profile_image'])) {
                        $image = $userData['profile_image'];
                    }

                    ?>
                    <img src="<?php echo $image ?>" id="cover-pfp" alt="pfp">
                    <?php echo $userData['username']; ?>

                </div>
            </div>

            <div class="posts-area">

            <div class="new-feed">
                    <form action="" method="POST">
                    <textarea name="post"placeholder="Co máte na mysli?"></textarea>
                    <button type="submit">PŘIDAT</button>
                </form>
                </div>

                <div class="post-bar">
                  
                        <?php

                        if ($posts) {
                            foreach ($posts as $ROW) {
                                $user = new User();
                                $rowUser = $user->getUser($ROW['userid']);

                                include("post.php");
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
