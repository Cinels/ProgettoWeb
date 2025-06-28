<!-- quando loggato restituisce solo 1 risultato -->

<section>
    <ul>
        <?php if(isset($templateParams["results"])):
            foreach($templateParams["results"] as $result): ?>
                <li>
                    <a href="<?php echo PAGES_DIR ?>product.php?search=<?php echo $result["idProdotto"]?>"><img src="<?php echo $result["link"]?>" alt="Immagine Prodotto"/><br/>
                    <?php echo $result["nome"] ?></a>

                    <?php if($dbh->isLogged() && $dbh->getUserType() == "client"): 
                        if($dbh->isProductFavourite($result["idProdotto"])): ?>
                            <a href="<?php $dbh->addToFavourites($result["idProdotto"]) ?>"><img src="<?php echo RESOURCES_DIR ?>cuore.png" alt="Aggiungi ai Preferiti"/></a>
                        <?php else: ?>
                            <a href="<?php $dbh->removeFromFavourites($result["idProdotto"]) ?>"><img src="<?php echo RESOURCES_DIR ?>cuore_B.png" alt="Rimuovi dai Preferiti"/></a>
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
                            <a href="<?php $dbh->addToCart($result["idProdotto"], 1) ?>"><img src="<?php echo RESOURCES_DIR ?>carrello.png" alt="Aggiungi al Carrello"/></a>
                        <?php else: ?>
                            <a href="<?php $dbh->removeFromCart($result["idProdotto"]) ?>"><img src="<?php echo RESOURCES_DIR ?>carrello.png" alt="Rimuovi dal Carrello"/></a>
                        <?php endif;
                    endif; ?>
                </li>
            <?php endforeach;
        endif; ?>
    </ul>
</section>