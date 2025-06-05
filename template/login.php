<section>
    <h2>Accedi</h2>
    <form action="#" method="POST">
        <?php if(isset($templateParams["errorelogin"])): ?>
            <p><?php echo $templateParams["errorelogin"]; ?></p>
        <?php endif; ?>
        <ul>
            <li>
                <label for="email">Email:</label><input type="email" id="email" name="email" />
            </li>
            <li>
                <label for="password">Password:</label><input type="password" id="password" name="password" />
            </li>
            <li>
                <input type="submit" name="submit" value="Accedi" />
            </li>
            <li>
                <p>o</p>
            </li>
            <li>
                <a href="<?php echo PAGES_DIR ?>sign_in.php"><input type="button" value="Registrati" /></a>
            </li>
        </ul>
    </form>
</section>