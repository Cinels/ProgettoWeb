<section>
    <ul>
        <?php if(isset($templateParams["results"])):
            foreach($templateParams["results"] as $result): ?>
                <li>
                    <a href="<?php echo PAGES_DIR ?>product.php?search=<?php echo $result["idProdotto"]?>"><img src="<?php echo DB_RESOURCES_DIR.$result["link"]?>" alt="Immagine Prodotto"/><br/>
                    <?php echo $result["nome"] ?></a>

                    <?php if($dbh->isLogged() && $dbh->getUserType() == "client"): 
                        if($dbh->isProductFavourite($result["idProdotto"])): ?>
                            <a href="?search=<?php echo $_GET["search"] ?>&id=<?php echo $result["idProdotto"]; ?>&favourites=remove <?php /*$dbh->removeFromFavourites($result["idProdotto"])*/ ?>"><img src="<?php echo RESOURCES_DIR?>cuore_R.png" alt="Rimuovi dai Preferiti"/></a>
                        <?php else: ?>
                            <a href="?search=<?php echo $_GET["search"] ?>&id=<?php echo $result["idProdotto"]; ?>&favourites=add <?php /*$dbh->addToFavourites($result["idProdotto"])*/ ?>"><img src="<?php echo RESOURCES_DIR?>cuore_B.png" alt="Aggiungi ai Preferiti"/></a>
                        <?php endif;
                    endif; ?>
                    <?php if($result["offerta"] > 0) {
                        $sale = $result["prezzo"] - $result["prezzo"]*($result["offerta"]/100);
                        echo "<ins>".$result["offerta"]."% ".$sale."</ins> <del>".$result['prezzo']." €</del>";
                    } else {
                        echo "<p>".$result['prezzo']." €</p>";
                    }?>
                    <?php if($dbh->isLogged() && $dbh->getUserType() == "client"): 
                        if($dbh->isProductInCart($result["idProdotto"])): ?>
                            <a href="?search=<?php echo $_GET["search"] ?>&id=<?php echo $result["idProdotto"]; ?>&cart=remove"><img src="<?php echo RESOURCES_DIR?>carrello_B.png" alt="Rimuovi dal Carrello"/></a>
                        <?php else: ?>
                            <a href="?search=<?php echo $_GET["search"] ?>&id=<?php echo $result["idProdotto"]; ?>&cart=add"><img src="<?php echo RESOURCES_DIR?>carrello_B.png" alt="Aggiungi al Carrello"/></a>
                        <?php endif;
                    endif; ?>
                </li>
            <?php endforeach;
        endif; ?>
    </ul>
</section>