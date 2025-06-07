<section>
    <form action="#" method="POST">
        <h2>Registrati</h2>
        <?php if(isset($templateParams["erroresignin"])): ?>
            <p><?php echo $templateParams["erroresignin"]; ?></p>
        <?php endif; ?>
        <ul>
            <li>
                <label for="image">URL Immagine:</label><input type="url" id="image" name="image" value="<?php if(isset($_POST["image"])) { echo $_POST["image"]; } ?>"/>
            </li><li>
                <label for="name">Nome:</label><input type="text" id="name" name="name" value="<?php if(isset($_POST["name"])) { echo $_POST["name"]; } ?>" required/>
            </li><li>
                <label for="surname">Cognome:</label><input type="text" id="surname" name="surname" value="<?php if(isset($_POST["surname"])) { echo $_POST["surname"]; } ?>" required/>
            </li><li>
                <label for="email">Email:</label><input type="email" id="email" name="email" value="<?php if(isset($_POST["email"])) { echo $_POST["email"]; } ?>" required/>
            </li><li>
                <label for="password">Password:</label><input type="password" id="password" name="password" value="<?php if(isset($_POST["password"])) { echo $_POST["password"]; } ?>" required/>
            </li><li>
                <label for="check_password">Conferma Password:</label><input type="password" id="check_password" name="check_password" value="<?php if(isset($_POST["check_password"])) { echo $_POST["check_password"]; } ?>" required/>
            </li><li>
                <input type="checkbox" id="terms" name="terms" value="accept" required <?php if(isset($_POST["terms"])) { echo "checked"; } ?>/>
                <label for="terms">Accetto <a href=#>i termini e le condizioni</a></label>
            </li><li>
                <input type="submit" name="submit" value="Registrati" />
            </li><li>
                <p>o</p>
            </li><li>
                <a href="<?php echo PAGES_DIR ?>login.php"><input type="button" value="Accedi" /></a>
            </li>
        </ul>
    </form>

</section>