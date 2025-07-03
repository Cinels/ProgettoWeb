<section>
    <?php $result = $templateParams["results"][0] ?>
    <!-- gestisci foto -->
    <img src="<?php echo DB_RESOURCES_DIR.$templateParams["images"][0]['link']?>" alt="Immagine Prodotto"/><br/>

    <h2><?php echo $result["nome"] ?></h2>
    <a href="#Reviews"><?php echo $result['media_recensioni']."/5 (".$result['num_recensioni'].")" ?><img src="<?php echo RESOURCES_DIR ?>Marco_semplice_W.png" alt=""/></a><br/>
    <?php if($result["offerta"] > 0) {
        $sale = $result["prezzo"] - $result["prezzo"]*($result["offerta"]/100);
        echo "<ins>".$result["offerta"]."% ".$sale."</ins> <del>".$result['prezzo']." €</del>";
    } else {
        echo "<p>".$result['prezzo']." €</p>";
    }?>

    <!-- gestione della quantità -->
    <div>
        <form action="#" method="POST">
        <label for="quantity">Quantità: </label>
        <input type="number" id="quantity" name="cart" min="0" value="1">
        <button type="submit"> Aggiungi al Carrello <img src="<?php echo RESOURCES_DIR ?>carrello_B.png" alt=""/>
</form>
    </div>

    <?php echo "<p>Consegna prevista per ".strftime("%A %d %B", strtotime('+1 day', time()))."</p>"; ?>
    
    <!-- gestisci inserimenti multipli -->
                    
    <?php if($dbh->isProductFavourite($result["idProdotto"])): ?>
        <a href="?search=<?php echo $result["idProdotto"]; ?>&favourites=remove">Rimuovi dai Preferiti<img src="<?php echo RESOURCES_DIR ?>cuore_R.png" alt=""/></a>
    <?php else: ?>
        <a href="?search=<?php echo $result["idProdotto"]; ?>&favourites=add">Aggiungi ai Preferiti<img src="<?php echo RESOURCES_DIR ?>cuore_B.png" alt=""/></a>
    <?php endif; ?>

    <p><?php echo $result["descrizione"] ?></p>
    <p><?php echo $result["proprieta"] ?></p>

    <p id="Reviews">
    <h3>Recensioni</h3>
    <?php echo $result['media_recensioni']."/5 (".$result['num_recensioni'].")" ?><br/>
    <?php if($templateParams["hasBuyed"] && !$templateParams['hasReviewed']): ?>
    <a href="write_review.php?id=<?php echo $result["idProdotto"] ?>">Lascia una recensione</a>
    <?php endif; ?>
    <?php require_once("reviews.php"); ?>
</p>
    
</section>