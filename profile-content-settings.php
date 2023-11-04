
    <!-- Stylovani pres class tohohle divu (idealne treba class photo-area ;3 [a pro kazdej profile-content soubor vlastni classu s takhle odlisnym nazvem ;3]) -->
<div class="posts-area">
<?php 

  $Settings = new Settings();
  $settings = $Settings->get_settings($_SESSION['krejzik_userid']);

  if (is_array($settings)){

 ?>

<form action="#" method="POST" enctype="multipart/form-data">
                
                <div class="input-container">
                    <label for="email">Uživatelské jméno</label>
                    <input  type="text" id="username" name="username" value="<?php echo htmlspecialchars($settings['username']) ?>" placeholder="Zadejte jméno" autocomplete="off">
                </div>
                <div class="input-container">
                    <label for="email">Email</label>
                    <input  type="text" id="email" name="email" value="<?php echo htmlspecialchars($settings['email']) ?>" placeholder="Zadejte email" autocomplete="off">
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
                    <input type="password" id="password" name="password" placeholder="Zadejte nové heslo" value="<?php echo htmlspecialchars("heslo123X") ?>" autocomplete="off">
                </div>
                <div class="input-container">
                    <label for="heslo">Heslo znovu <span class="hvezda"> *</span></label>
                    <input type="password" id="password-again" name="password-again" value="<?php echo htmlspecialchars("heslo123X") ?>" placeholder="Zadejte znovu nové heslo" autocomplete="off">
                </div>

                <label for="about">O mně:</label>
                <textarea name="about" style="word-wrap: break-word;"><?php echo htmlspecialchars($settings['about']) ?></textarea>

                <button style="margin-top:20px;" type="submit">PŘIDAT</button>
                
            </form>
<?php
        }
 ?> 

</div>