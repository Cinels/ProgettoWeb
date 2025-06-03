<section>
    <form action="javascript:history.go(-2)" method="POST">
        <h2>Login</h2>
        <?php if(isset($templateParams["erroresignin"])): ?>
            <p><?php echo $templateParams["erroresignin"]; ?></p>
        <?php endif; ?>
        <ul>
            <li>
                <input type="image" src="<?php echo RESOURCES_DIR ?>add_T.png" alt="Submit" width="48" height="48">
            </li>
            <li>
                <label for="name">Nome:</label><input type="text" id="name" name="name" />
            </li>
            <li>
                <label for="surname">Cognome:</label><input type="text" id="surname" name="surname" />
            </li>
            <li>
                <label for="email">Email:</label><input type="email" id="email" name="email" />
            </li>
            <li>
                <label for="password">Password:</label><input type="password" id="password" name="password" />
            </li>
            <li>
                <label for="check_password">Conferma Password:</label><input type="password" id="check_password" name="check_password" />
            </li>
            <li>
                <input type="checkbox" id="terms" name="terms" value="terms" />
                <label for="terms">Accetto<a href=#>i termini e le condizioni</a></label>
            </li>
            <li>
                <input type="submit" name="submit" value="Registrati" />
            </li>
        </ul>
    </form>

</section>