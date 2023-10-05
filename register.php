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
        <div class="login-box">
            <h2>Registrace</h2>
            <form action="" method="POST">
                <div class="input-container">
                    <label for="email">Přezdívka:</label>
                    <input type="email" id="username" name="username" placeholder="Zadejte jméno" required>
                </div>
                <div class="input-container">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Zadejte email" required>
                </div>
                <div class="input-container">
                    <label for="gender">Pohlaví:</label>
                    <select name="gender" id="gender">
                        <option>Muž</option>
                        <option>Žena</option>
                        <option>Jiné</option>
                    </select>
                </div>
                <div class="input-container">
                    <label for="heslo">Heslo:</label>
                    <input type="password" id="password" name="password" placeholder="Zadejte heslo" required>
                </div>
                <div class="input-container">
                    <label for="heslo">Heslo znovu:</label>
                    <input type="password" id="password-again" name="password-agin" placeholder="Zadejte znovu heslo" required>
                </div>
                <button type="submit">Zaregistrovat</button>
            </form>
            <a href="login.php" class="text-grad reg-text">Máte už účet? Přihlašte se!</a>
        </div>
    </main>
</body>
</html>
