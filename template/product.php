<section>
    <?php $result = $templateParams["results"][0] ?>
    <img src="<?php echo $result["link"]?>" alt="Immagine Prodotto"/><br/>
    <p><?php echo $result["nome"] ?></p>
    <a href="#Reviews"><?php echo $result["media_recensioni"] ?><img src="<?php echo RESOURCES_DIR ?>Marco_semplice_W.png" alt=""/></a>
    <?php if($result["sconto"] > 0) {
        $sale = $result["prezzo"] - $result["prezzo"]*$result["sconto"];
        echo "<ins>$sale</ins>€ <del>$result['prezzo']€</del>";
    } else {
        echo "<p>$result['prezzo']€</p>";
    }?>
    <!-- gestione della quantità -->
    <p>Consegna prevista per x</p>
    
    <?php if($dbh->isLogged() && $dhb->getUserType() == "client"): ?>
        <!-- gestisci inserimenti multipli -->
        <a href="<?php $dbh->addToCart($result["idProdotto"], 1) ?>">Aggiungi al Carrello<img src="<?php echo RESOURCES_DIR ?>carrello.png" alt="Aggiungi al Carrello"/></a>
    <?php else: ?>
        <a href="<?php echo PAGES_DIR ?>login.php">Aggiungi al Carrello<img src="<?php echo RESOURCES_DIR ?>carrello.png" alt="Aggiungi al Carrello"/></a>
    <?php endif; ?>
    <?php if($dbh->isLogged() && $dhb->getUserType() == "client"): 
        if($dbh->isProductFavourite($result["idProdotto"])): ?>
            <a href="<?php $dbh->addToFavourites($result["idProdotto"]) ?>">Aggiungi ai Preferiti<img src="<?php echo RESOURCES_DIR ?>cuore.png" alt="Aggiungi ai Preferiti"/></a>
        <?php else: ?>
            <a href="<?php $dbh->removeFromFavourites($result["idProdotto"]) ?>">Rimuovi dai Preferiti<img src="<?php echo RESOURCES_DIR ?>cuore_B.png" alt="Rimuovi dai Preferiti"/></a>
        <?php endif; ?>
    <?php else: ?>
        <a href="<?php echo PAGES_DIR ?>login.php"><img src="<?php echo RESOURCES_DIR ?>cuore.png" alt="Aggiungi ai Preferiti"/></a>
    <?php endif; ?>

    <p><?php echo $result["descrizione"] ?></p>
    <p><?php echo $result["proprieta"] ?></p>

    <p id="Reviews">Recensioni</p>
    
</section>