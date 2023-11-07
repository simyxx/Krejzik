<!DOCTYPE html>
<html lang="cs">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>
<body>
    <header>
        <nav class="navbar">
            <a href="index.php" class="nav-logo">
              <img src="img/silenyvlk.png" alt="Logo" class="logo">
              <img src="img/krejzik.png" alt="Logo" class="logotext">
            </a>
          </nav>
          <div class="navbar-bottom"></div>
    </header>
    <div class="error-message-container">
    <?php 
        session_start();

        include("classes/connect.php");
        include("classes/login.class.php");

        $email = "";
        $password = "";

        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {   
            $login = new Login();
            $result = $login->evaluate($_POST);
            
            if ($result != "")
            {
                echo "<div  style='text-align:center;font-size:18px;color:white;background-color:#F16529;'>";
                echo $result;
                echo "</div>";
            }
            else
            {
                header("Location: profile.php");
                die();
            }
            
            $password = $_POST['password'];
            $email = $_POST['email'];
        }
    ?>
    </div>
    <main>
        <div class="login-box">
            <h2>Přihlášení</h2>
            <form action="" method="POST">
                <div class="input-container">
                    <label for="email">Email:</label>
                    <input value="<?php echo $email ?>" type="text" id="email" name="email" placeholder="Email" autocomplete="off">
                </div>
                <div class="input-container">
                    <label for="heslo">Heslo:</label>
                    <input value="<?php echo $password ?>" type="password" id="heslo" name="password" placeholder="Heslo" autocomplete="off">
                </div>
                <button type="submit">Přihlásit se</button>
            </form>
            <a href="signup.php" class="text-grad reg-text">Zaregistrovat se</a>
        </div>
    </main>
</body>
<footer style="background-color: white; padding: 10px;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <a href="mailto:krejzik.help@gmail.com" class="text-grad" style="flex: 0.5; width:50px;">krejzik.help@gmail.com</a>
        <a href="https://www.instagram.com/krejzik.dev/" target="_blank" style="flex: 0.5; text-align: right;width:50px;">
            <i class="fa-brands fa-instagram" style="color: #ff8000;"></i>
        </a>
    </div>
</footer>

</html>
