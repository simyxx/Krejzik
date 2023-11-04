<?php 
include("classes/autoloader.php");

// Je přihlášen?
if (!isset($_SESSION['krejzik_userid'])) {
    // Pokud uživatel není přihlášen, provedete přesměrování na jinou stránku
    header("Location: login.php");
    exit;
}

$_SESSION['returnTo'] = "profile.php";
if (isset($_SERVER['HTTP_REFERER']) && !strstr($_SERVER['HTTP_REFERER'], "delete.php")){
    $_SESSION['returnTo'] = $_SERVER['HTTP_REFERER'];
    }

if (isset($_GET['type']) && isset($_GET['id'])){

    if (is_numeric($_GET['id'])){
        $allowed[] = 'post';
        $allowed[] = 'user';
        $allowed[] = 'comment';
        if (in_array($_GET['type'], $allowed)){
            $post = new Post();
            $post->like_post($_GET['id'], $_GET['type'], $_SESSION['krejzik_userid']);
            if ($_GET['type'] == "user"){
                $User = new User();
                $User->follow_user($_GET['id'], $_GET['type'], $_SESSION['krejzik_userid']);
            }
        }
    }
}

header("Location: " .$_SESSION['returnTo']);
die();