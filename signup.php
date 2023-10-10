<!DOCTYPE html>


<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Krejzik | Registrace</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <a href="index.html" class="nav-logo">
              <img src="img/silenyvlk.png" alt="Logo" class="logo">
              <img src="img/krejzik.png" alt="Logo" class="logotext">
            </a>
          </nav>
          <div class="navbar-bottom"></div>
    </header>
    <main>
        
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
                    echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
                    echo "Nastala chyba: <br>";
                    echo $result;
                    echo "</div>";
                }
                
                $username = $_POST['Přezdívka'];
                $gender = $_POST['Pohlaví'];
                $email = $_POST['Email'];
            }

        ?>

        <div class="login-box">
            <h2>Registrace</h2>
            
            <form method="post" action="">
                
                <div class="input-container">
                    <label for="email">Uživatelské jméno:</label>
                    <input value='<?php echo $username ?>' type="text" id="username" name="Přezdívka" placeholder="Zadejte jméno" >
                </div>

                <div class="input-container">
                    <label for="email">Email:</label>
                    <input value='<?php echo $email ?>' type="text" id="email" name="Email" placeholder="Zadejte email" >
                </div>

                <div class="input-container">
                    <label for="gender">Pohlaví:</label>
                    <select name="Pohlaví" id="gender">
                        <option><?php echo $gender ?></option>
                        <option>Muž</option>
                        <option>Žena</option>
                        <option>Jiné</option>
                    </select>
                </div>

                <div class="input-container">
                    <label for="heslo">Heslo:</label>
                    <input type="password" id="password" name="Heslo" placeholder="Zadejte heslo" >
                </div>

                <div class="input-container">
                    <label for="heslo">Heslo znovu:</label>
                    <input type="password" id="password-again" name="Heslo" placeholder="Zadejte znovu heslo" >
                </div>

                <input type="submit" id="button" value="Registrovat">
                
            </form>

            <a href="login.php" class="text-grad reg-text">Máte už účet? Přihlašte se!</a>
        </div>
    </main>
</body>
</html>
