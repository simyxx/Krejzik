<?php
session_start();

include("classes/connect.php");
include("classes/login.class.php");
include("classes/user.class.php");
include("classes/post.class.php");
include("classes/image.class.php");

$login = new Login();
$userData = $login->checkLogin($_SESSION['krejzik_userid']);

// Získaní username
$user = new User();
$userData = $user->getData($_SESSION['krejzik_userid']);

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
        if ($userData['profile_image'] && file_exists($userData['profile_image'])) {
            // Smazat stávající profilovou fotografii
            unlink($userData['profile_image']);
        }
        if ($_FILES['file']['type'] == "image/jpeg" || $_FILES['file']['type'] == "image/png" || $_FILES['file']['type'] == "image/gif") {
            $allowedSize = (1024 * 1024) * 5;
            if ($_FILES['file']['size'] < $allowedSize) {

                // Tvoření bezpečného názvu souboru
                $userId = $userData['userid'];
                $uploadedFile = $_FILES['file']['name'];
                $timestamp = time();
                $fileExtension = pathinfo($uploadedFile, PATHINFO_EXTENSION);
                $newFilename = $userId . '-' . $timestamp . '.' . $fileExtension;
                $filename = "uploads/" . $newFilename;
                move_uploaded_file($_FILES['file']['tmp_name'], $filename);

                $image = new Image();
                $image->cropImage($filename, $filename, 800, 800);

                if (file_exists($filename)) {
                    $userId = $userData['userid'];
                    $query = "UPDATE users SET profile_image = '$filename' WHERE userid = '$userId' limit 1";
                    $DB = new Database();
                    $DB->save($query);
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

                    <div class="new-feed">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="file" name="file">
                            <button type="submit" name="submit">Změnit</button>
                        </form>
                    </div>



                </div>
            </div>

        </div>
    </main>
</body>

</html>