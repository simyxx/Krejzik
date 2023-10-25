<!DOCTYPE html>        
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Krejzik | Registrace</title>
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
                include("classes/connect.php");
                include("classes/signup.class.php");
                $username = "";
                $gender = "";
                $email = "";
                if ($_SERVER['REQUEST_METHOD'] == 'POST')
                {   
                    $signup = new Signup();
                    $result = $signup->evaluate($_POST);

                    if ($result != "")
                    {
                        echo "<div  style='text-align:center;font-size:18px;color:white;background-color:#F16529;'>";
                        echo $result;
                        echo "</div>";
                    }
                    else
                    {
                        header("Location: login.php");
                        die();
                    }

                    $username = $_POST['username'];
                    $gender = $_POST['gender'];
                    $email = $_POST['email'];
                }
            ?>
    </div>
    <main>  

        <div class="login-box">
            <h2>Registrace</h2>
            
            <form method="post" action="">
                
                <div class="input-container">
                    <label for="email">Uživatelské jméno <span class="hvezda"> *</span></label>
                    <input value='<?php echo $username ?>' type="text" id="username" name="username" placeholder="Zadejte jméno" autocomplete="off">
                </div>
                <div class="input-container">
                    <label for="email">Email <span class="hvezda"> *</span></label>
                    <input value='<?php echo $email ?>' type="text" id="email" name="email" placeholder="Zadejte email" autocomplete="off">
                </div>

                <div class="input-container">
                    <label for="gender">Pohlaví <span class="hvezda"> *</span></label>
                    <div class="select">
                        <select name="gender" id="gender">
                          <option value="1">Muž</option>
                          <option value="2">Žena</option>
                          <option value="3">Šílený vlk</option>
                        </select>
                     </div>
                </div>

                <div class="input-container">
                    <label for="heslo">Heslo <span class="hvezda"> *</span><span class="tooltip" data-tooltip="Heslo musí obsahovat alespoň 8 znaků, velká a malá písmena a číslo.">?</span></label>
                    <input type="password" id="password" name="password" placeholder="Zadejte heslo" autocomplete="off">
                </div>

                <div class="input-container">
                    <label for="heslo">Heslo znovu <span class="hvezda"> *</span></label>
                    <input type="password" id="password-again" name="password-again" placeholder="Zadejte znovu heslo" autocomplete="off">
                </div>

                <input type="submit" class="button" value="Registrovat" name="submit">
                
            </form>

            <a href="login.php" class="text-grad reg-text">Máte už účet? Přihlašte se!</a>
        </div>
    </main>
</body>
</html>
