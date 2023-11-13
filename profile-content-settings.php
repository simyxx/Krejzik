
    <!-- Stylovani pres class tohohle divu (idealne treba class photo-area ;3 [a pro kazdej profile-content soubor vlastni classu s takhle odlisnym nazvem ;3]) -->
<div class="posts-area">
<?php 



    if ($_GET['id'] != $_SESSION['krejzik_userid']){
        header("Location: profile.php");
    }

  $Settings = new Settings();
  $settings = $Settings->get_settings($_SESSION['krejzik_userid']);

  if (is_array($settings)){

 ?>

<form action="#" method="POST" enctype="multipart/form-data">
                
                <div class="input-container" style="margin-top:15px;">
                    <label for="email">Uživatelské jméno</label>
                    <input  type="text" id="username" name="username" value="<?php echo htmlspecialchars($settings['username']) ?>" placeholder="Zadejte jméno" autocomplete="off" required>
                </div>
                <div class="input-container">
                    <label for="email">Email</label>
                    <input  type="text" id="email" name="email" value="<?php echo htmlspecialchars($settings['email']) ?>" placeholder="Zadejte email" autocomplete="off" required>
                </div>

                <div class="input-container">
                    <label for="gender">Pohlaví</label>
                    <div class="select">
                        <select name="gender" id="gender" <?php echo htmlspecialchars($settings['gender']) ?>>
                          <option value="1">Muž</option>
                          <option value="2">Žena</option>
                          <option value="3">Šílený vlk</option>
                        </select>
                     </div>
                </div>

                <div class="input-container">
                    <label for="heslo">
                    Heslo 
                    <div class="tooltip">?
                        <span class="tooltiptext">Heslo musí obsahovat alespoň 8 znaků, velká a malá písmena a číslo.</span>
                    </div> 
                    </label>
                    <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($settings['password']) ?>" placeholder="Zadejte nové heslo" autocomplete="off" required>
                </div>
                <div class="input-container">
                    <label for="heslo">Heslo znovu</label>
                    <input type="password" id="password-again" name="password-again" value="<?php echo htmlspecialchars($settings['password']) ?>" placeholder="Zadejte znovu nové heslo" autocomplete="off" required>
                </div>

                <label for="about">O mně:</label>
                <textarea id="postText" name="about" placeholder="Co máte na mysli?" style="word-wrap: break-word;"
                        oninput="updateCharacterCount()"><?php echo htmlspecialchars($settings['about']) ?></textarea>
                    <div id="charCount" style="float:right;">0/300</div>

                <button style="margin-top:20px;margin-bottom:20px;" type="submit">ULOŽIT</button>
                
            </form>
<?php
        }
 ?> 

</div>
<script>
        function updateCharacterCount() {
            var text = document.getElementById('postText').value;
            var charCount = text.length;

            // Omezení délky textu na 300 znaků
            if (charCount > 300) {
                document.getElementById('postText').value = text.substring(0, 300);
                charCount = 300;
            }

            document.getElementById('charCount').innerText = charCount + '/300';
        }
        window.onload = function () {
                        updateCharacterCount();
                    };
    </script>