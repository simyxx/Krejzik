<?php 
session_start();

include("classes/connect.php");
include("classes/login.class.php");
include("classes/user.class.php");
include("classes/post.class.php");


// Je přihlášen?
if (!isset($_SESSION['krejzik_userid'])) {
    // Pokud uživatel není přihlášen, provedete přesměrování na jinou stránku
    header("Location: login.php"); 
    exit; 
}

// Získaní username
$user = new User();
$userData = $user->getData($_SESSION['krejzik_userid']);
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
                    
                    <img src="img/selfie.jpg" id="cover-pfp" alt="pfp">
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
                    <div class="post">
                        <div>
                            <img class="post-img" src="img/user1.jpg" alt="pfp">
                        </div>
                        <div>
                            <div class="text-grad post-owner">First guy</div>
                            Lorem Ipsum is simply dummy text of the printing and typesettings industry.  Lorem Ipsum is simply dummy text of the printing and typesettings industry.  
                            Lorem Ipsum is simply dummy text of the printing and typesettings industry.  Lorem Ipsum is simply dummy text of the printing and typesettings industry.
                            <br><br>
                            <a href="">Like</a> . <a href="">Comment</a> . <span style="color:#999;">5. října 2023</span>
                        </div>
                    </div>

                    <div class="post">
                        <div>
                            <img class="post-img" src="img/user2.jpg" alt="pfp">
                        </div>
                        <div>
                            <div class="text-grad post-owner">Second guy</div>
                            Lorem Ipsum is simply dummy text of the printing and typesettings industry.  Lorem Ipsum is simply dummy text of the printing and typesettings industry.  
                            Lorem Ipsum is simply dummy text of the printing and typesettings industry.  Lorem Ipsum is simply dummy text of the printing and typesettings industry.
                            <br><br>
                            <a href="">Like</a> . <a href="">Comment</a> . <span style="color:#999;">5. října 2023</span>
                        </div>
                    </div>

                    <div class="post">
                        <div>
                            <img class="post-img" src="img/user3.jpg" alt="pfp">
                        </div>
                        <div>
                            <div class="text-grad post-owner">Third guy</div>
                            Lorem Ipsum is simply dummy text of the printing and typesettings industry.  Lorem Ipsum is simply dummy text of the printing and typesettings industry.  
                            Lorem Ipsum is simply dummy text of the printing and typesettings industry.  Lorem Ipsum is simply dummy text of the printing and typesettings industry.
                            <br><br>
                            <a href="">Like</a> . <a href="">Comment</a> . <span style="color:#999;">5. října 2023</span>
                        </div>
                    </div>

                    <div class="post">
                        <div>
                            <img class="post-img" src="img/user4.jpg" alt="pfp">
                        </div>
                        <div>
                            <div class="text-grad post-owner">First guy</div>
                            Lorem Ipsum is simply dummy text of the printing and typesettings industry.  Lorem Ipsum is simply dummy text of the printing and typesettings industry.  
                            Lorem Ipsum is simply dummy text of the printing and typesettings industry.  Lorem Ipsum is simply dummy text of the printing and typesettings industry.
                            <br><br>
                            <a href="">Like</a> . <a href="">Comment</a> . <span style="color:#999;">5. října 2023</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    </main>
</body>
</html>