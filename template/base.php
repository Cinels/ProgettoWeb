<!DOCTYPE html>
<html lang="it">
    <head>
        <title><?php echo $templateParams["titolo"]; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
        <link rel="icon" type="image/x-icon" href="<?php echo RESOURCES_DIR.'header/logo.png' ?>">
        <?php if(isset($templateParams["css"])): 
            foreach($templateParams["css"] as $script): ?>
                <link rel="stylesheet" type="text/css" href="<?php echo $script; ?>" />
            <?php endforeach;
        endif; ?>
    </head>
    <body>
        <header>
            <h1><a href="<?php echo PAGES_DIR ?>index.php"><img src="<?php echo RESOURCES_DIR ?>header/logo.png" alt="Logo - Home Page"/></a></h1>
            <div>    
                <?php if($dbh->isLogged() && $dbh->getUserType() === "vendor"): ?>
                    <a href="<?php echo PAGES_DIR ?>manage_product.php"><img src="<?php echo RESOURCES_DIR ?>header/add_T.png" alt="Aggiungi Prodotto"/></a>
                <?php else: ?>
                    <a href="<?php echo PAGES_DIR ?>favourite.php"><img src="<?php echo RESOURCES_DIR ?>header/cuore.png" alt="Lista Preferiti"/></a>
                    <a href="<?php echo PAGES_DIR ?>cart.php"><img src="<?php echo RESOURCES_DIR ?>header/carrello.png" alt="Carrello"/></a>
                <?php endif; ?>
                <a href="<?php echo PAGES_DIR ?>orders.php"><img src="<?php echo RESOURCES_DIR ?>header/ciamioncino.png" alt="Ordini"/></a>
                <a href="<?php echo PAGES_DIR ?>profile.php"><img src="<?php echo ($dbh->getProfileImage() !== null ? DB_RESOURCES_DIR.$dbh->getProfileImage() : RESOURCES_DIR."header/utente.png")?>" alt="Profilo"/></a>
            </div>
            <form action="<?php echo PAGES_DIR ?>results.php" method="GET">
                <img src="<?php echo RESOURCES_DIR ?>header/search.png" alt="Cerca"/>
                <input id="product" type="search" name="search" placeholder='Cerca'/>
                <label for="product" hidden>Cerca</label>
            </form>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    </body>
</html>