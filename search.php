<?php

include("classes/autoloader.php");

// Je přihlášen?
if (!isset($_SESSION['krejzik_userid'])) {
    // Pokud uživatel není přihlášen, provedete přesměrování na jinou stránku
    header("Location: login.php");
    exit;
}

if (isset($_GET['find'])) {

    $find = addslashes($_GET['find']);
    $sql = "SELECT * FROM users WHERE username LIKE '%$find%' LIMIT 30";
    $DB = new Database();
    $results = $DB->read($sql);

}
else {

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Krejzik | Hledání</title>
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
           
        <h3>Výsledky hledání:</h3>

                <?php

                $User = new User();

                    if (is_array($results)){
                        ?>
 
                        <!-- Stylování jednoho zobrazenýho uživatele v tomhle divu  -->
                        <div>
                        <?php
                        foreach ($results as $row) {   
                            $ROW = $User->getUser($row['userid']); 
                            include("user.php");
                        }
                    }   
                    else 
                    {
                        echo "Nebyli nalezeni žádní uživatele.";
                    }             
                ?>
                        </div>

        </div>
    </main>
</body>

</html>