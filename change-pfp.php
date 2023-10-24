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

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
        
        if ($_FILES['file']['type'] == "image/jpeg" || $_FILES['file']['type'] == "image/png" || $_FILES['file']['type'] == "image/gif") {
            $allowedSize = (1024 * 1024) * 5;
            if ($_FILES['file']['size'] < $allowedSize) {
                $image = new Image();

                // Tvoření složky
                $folder = "uploads/" . $userData['userid'] . "/";

                // Tvoření bezpečného názvu souboru
                $userId = $userData['userid'];
                $uploadedFile = $_FILES['file']['name'];
                $timestamp = time();
                $fileExtension = pathinfo($uploadedFile, PATHINFO_EXTENSION);
                $newFilename = $userId . '-' . $timestamp . '.' . $fileExtension;

                // Zajištění, že název souboru bude jedinečný
                $i = 1;
                while (file_exists($folder . $newFilename)) {
                    $newFilename = $userId . '-' . $timestamp . '_' . $i . '.' . $fileExtension;
                    $i++;
                }

                // Tvorba složky
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }
                $filename = $folder . $newFilename;
                move_uploaded_file($_FILES['file']['tmp_name'], $filename);
                $change = "profile";
                // Zjištění, jestli je v url $_GET cover nebo profile
                if (isset($_GET['change'])) {
                    $change = $_GET['change'];
                }
                if ($change == "cover") {
                    if (file_exists($userData['cover_image'] && $userData['cover_image'] != "img/placeholder.png")) {
                        unlink($userData['cover_image']);
                    }
                    $image->cropImage($filename, $filename, 1366, 488);
                } else {
                    if (file_exists($userData['profile_image'] && $userData['profile_image'] != "img/profilepic.png")) {
                        unlink($userData['profile_image']);
                    }
                    $image->cropImage($filename, $filename, 800, 800);
                }


                if (file_exists($filename)) {
                    $userId = $userData['userid'];

                    if ($change == "cover") {
                        $query = "UPDATE users SET cover_image = '$filename' WHERE userid = '$userId' limit 1";
                        $_POST['is_cover_image'] = 1;
                    } else {
                        $query = "UPDATE users SET profile_image = '$filename' WHERE userid = '$userId' limit 1";
                        $_POST['is_profile_image'] = 1;
                    }
                    $DB = new Database();
                    $DB->save($query);
                    
                    // Vytvořit post o změně pfp
                    $post = new Post();
                    
                    $result = $post->create_post($userId, $_POST, $filename);

                    header("Location: profile.php");
                    die();
                }
            } else {
                echo "<div  style='text-align:center;font-size:18px;color:white;background-color:#F16529;'>";
                echo "Pouze obrázky o velikosti 5MB nebo méně!";
                echo "</div>";
            }
        } else {
            echo "<div  style='text-align:center;font-size:18px;color:white;background-color:#F16529;'>";
            echo "Povolené jsou formáty jpeg, jpg, png a gif!";
            echo "</div>";
        }

    } else {
        echo "<div  style='text-align:center;font-size:18px;color:white;background-color:#F16529;'>";
        echo "Prosím zadejte správný obrázek!";
        echo "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Krejzik | Změna obrázku</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" type="image/png" href="img/silenyvlk.png">
</head>

<body>
    <?php
    include("header.php");
    ?>

    <main>
        <div id="content">

            <div id="below-cover">


                <div id="posts-area">

                    <div class="new-feed change-pfp-part">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="file" name="file" class="change-pfp-part">
                            <button type="submit" name="submit">Změnit</button>
                            <br> <br>
                            <div>
                                <?php


                                // Zjištění, jestli je v url $_GET cover nebo profile
                                if (isset($_GET['change']) && $_GET['change'] == "cover") {
                                    $change = "cover";
                                    echo "<img src='$userData[cover_image]' style='max-width: 500px;'>";
                                } else {
                                    echo "<img src='$userData[profile_image]' style='max-width: 500px;'>";
                                }

                                ?>
                                </>
                        </form>
                    </div>



                </div>
            </div>

        </div>
    </main>
</body>

</html>