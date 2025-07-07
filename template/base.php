<!DOCTYPE html>
<html lang="it">
    <head>
        <title><?php echo $templateParams["titolo"]; ?></title>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
    </head>
    <body>
        <header>
            <h1><a href="<?php echo PAGES_DIR ?>index.php"><img src="<?php echo RESOURCES_DIR ?>header/logo.png" alt="Il Puzzo"/></a></h1>

            <form action="<?php echo PAGES_DIR ?>results.php" method="GET">
                <label>
                    <img src="<?php echo RESOURCES_DIR ?>header/search.png" alt="Cerca"/>
                    <input type="search" name="search"/>
                </label>
            </form>
            <?php if($dbh->isLogged() && $dbh->getUserType() == "vendor"): ?>
                <a href="<?php echo PAGES_DIR ?>add_product.php"><img src="<?php echo RESOURCES_DIR ?>header/add_T.png" alt="Aggiungi Prodotto"/></a>
            <?php else: ?>
                <a href="<?php echo PAGES_DIR ?>favourite.php"><img src="<?php echo RESOURCES_DIR ?>header/cuore.png" alt="Lista Preferiti"/></a>
                <a href="<?php echo PAGES_DIR ?>cart.php"><img src="<?php echo RESOURCES_DIR ?>header/carrello.png" alt="Carrello"/></a>
            <?php endif; ?>
            <a href="<?php echo PAGES_DIR ?>orders.php"><img src="<?php echo RESOURCES_DIR ?>header/ciamioncino.png" alt="Ordini"/></a>
            <a href="<?php echo PAGES_DIR ?>profile.php"><img src="<?php echo $dbh->getProfileImage() ?? RESOURCES_DIR."header/utente.png"; ?>" alt="Profilo"/></a>
        </header>

        <main>
            <?php if(isset($templateParams["main_content"])) {
                foreach($templateParams["main_content"] as $content){
                    require($content);
                }
            } ?>
        </main>

        <aside>
            <?php if(isset($templateParams["side_content"])) {
                    require_once("suggestions.php");
            } ?>
        </aside>

        <?php if(isset($templateParams["js"])): 
            foreach($templateParams["js"] as $script): ?>
                <script type="module" src="<?php echo $script; ?>"></script>
            <?php endforeach;
        endif; ?>

        <footer>
            <p>Tecnologie Web - A.A. 2024/2025</p>
        </footer>
    </body>
</html>