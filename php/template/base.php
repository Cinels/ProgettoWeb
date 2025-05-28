<?php require("../utils/paths.php"); ?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <title><?php echo $templateParams["titolo"]; ?></title>
        <link rel="stylesheet" type="text/css" href="../../css/style.css" />
    </head>
    <body>
        <header>
            <a href="<?php echo PAGES_DIR ?>index.php"><img src="<?php echo RESOURCES_DIR ?>logo.png" alt="Pagina Principale"/></a>

            <label>
                <img src="<?php echo RESOURCES_DIR ?>search.png" alt="Search"/>
                <input type="text" name="search"/>
            </label>

            <?php if(false/* no login */): ?>
                <a href="<?php echo PAGES_DIR ?>login.php"><img src="<?php echo RESOURCES_DIR ?>favourite.png" alt="Lista Preferiti"/></a>
                <a href="<?php echo PAGES_DIR ?>login.php"><img src="<?php echo RESOURCES_DIR ?>cart.png" alt="Carrello"/></a>
                <a href="<?php echo PAGES_DIR ?>login.php"><img src="<?php echo RESOURCES_DIR ?>orders.png" alt="Ordini"/></a>
                <a href="<?php echo PAGES_DIR ?>login.php"><img src="<?php echo RESOURCES_DIR ?>profile.png" alt="Profilo"/></a>
            <?php else: ?>
                <?php if(true/* login cliente */): ?>
                    <a href="<?php echo PAGES_DIR ?>favourite.php"><img src="<?php echo RESOURCES_DIR ?>favourite.png" alt="Lista Preferiti"/></a>
                    <a href="<?php echo PAGES_DIR ?>cart.php"><img src="<?php echo RESOURCES_DIR ?>cart.png" alt="Carrello"/></a>
                <?php else: ?>
                    <a href="<?php echo PAGES_DIR ?>add_product.php"><img src="<?php echo RESOURCES_DIR ?>add.png" alt="Aggiungi Prodotto"/></a>
                <?php endif; ?>
                <a href="<?php echo PAGES_DIR ?>orders.php"><img src="<?php echo RESOURCES_DIR ?>orders.png" alt="Ordini"/></a>
                <a href="<?php echo PAGES_DIR ?>profile.php"><img src="<?php echo RESOURCES_DIR ?>profile.png" alt="Profilo"/></a>
            <?php endif; ?>
        </header>
        
        <footer>
            <p>Tecnologie Web - A.A. 2024/2025</p>
        </footer>

    </body>
</html>