<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Krejzik | Přihlášení</title>
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
            <h2>Přihlášení</h2>
            <form action="" method="POST">
                <div class="input-container">
                    <label for="email">Email:</label>
                    <input type="text" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-container">
                    <label for="heslo">Heslo:</label>
                    <input type="password" id="heslo" name="heslo" placeholder="Heslo" required>
                </div>
                <button type="submit">Přihlásit se</button>
            </form>
            <a href="register.php" class="text-grad reg-text">Zaregistrovat se</a>
        </div>
    </main>
</body>
</html>
