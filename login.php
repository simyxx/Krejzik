<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sociální síť">
    <title>Krejzik | Přihlášení</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" href="img/silenyvlk.png">
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
</html>
