<section>
    <?php $result = $templateParams["results"][0] ?>
    <img src="<?php echo $result["link"]?>" alt="Immagine Prodotto"/><br/>
    <p><?php echo $result["nome"] ?></p>
    <a href="#"><?php echo $result["media_recensioni"] ?><img src="<?php echo RESOURCES_DIR ?>cuore.png" alt=""/></a>
    
    
    <?php if($dbh->isLogged() && $dhb->getUserType() == "client"): 
        if($dbh->isProductFavourite($result["idProdotto"])): ?>
            <a href="<?php $dbh->addToFavourites($result["idProdotto"]) ?>"><img src="<?php echo RESOURCES_DIR ?>cuore.png" alt="Aggiungi ai Preferiti"/></a>
        <?php else: ?>
            <a href="<?php $dbh->removeFromFavourites($result["idProdotto"]) ?>"><img src="<?php echo RESOURCES_DIR ?>cuore_B.png" alt="Rimuovi dai Preferiti"/></a>
        <?php endif;
    endif; ?>
    <p><?php echo $result["prezzo"] ?>€</p> <!-- gestisci sconto -->
    <?php if($dbh->isLogged() && $dhb->getUserType() == "client"): 
        if($dbh->isProductInCart($result["idProdotto"])): ?>
            <a href="<?php $dbh->addToCart($result["idProdotto"], 1) ?>"><img src="<?php echo RESOURCES_DIR ?>carrello.png" alt="Aggiungi al Carrello"/></a>
        <?php else: ?>
            <a href="<?php $dbh->removeFromCart($result["idProdotto"]) ?>"><img src="<?php echo RESOURCES_DIR ?>carrello.png" alt="Rimuovi dal Carrello"/></a>
        <?php endif;
    php endif; ?>
</section>