<section>
    <?php $result = $templateParams["results"][0] ?>
    <!-- gestisci foto -->
    <img src="<?php echo $templateParams["images"][0]?>" alt="Immagine Prodotto"/><br/>

    <p><?php echo $result["nome"] ?></p>
    <a href="#Reviews"><?php echo $result['media_recensioni']." ".$result['num_recensioni'] ?><img src="<?php echo RESOURCES_DIR ?>Marco_semplice_W.png" alt=""/></a><br/>
    <?php if($result["offerta"] > 0) {
        $sale = $result["prezzo"] - $result["prezzo"]*($result["offerta"]/100);
        echo "<ins>".$result["offerta"]."% ".$sale."</ins> <del>".$result['prezzo']." €</del>";
    } else {
        echo "<p>".$result['prezzo']." €</p>";
    }?>

    <!-- gestione della quantità -->
    <div>
        <label for="quantity">Quantità: </label>
        <input type="number" id="quantity" name="quantity" min="0" value="1">
    </div>

    <?php echo "<p>Consegna prevista per ".strftime("%A %d %B", strtotime('+1 day', time()))."</p>"; ?>
    
    <?php if($dbh->isLogged() && $dbh->getUserType() == "client"): ?>
        <!-- gestisci inserimenti multipli -->
        <a href="?search=<?php echo $result["idProdotto"]; ?>&cart=1">Aggiungi al Carrello<img src="<?php echo RESOURCES_DIR ?>carrello_B.png" alt=""/></a>
    <?php else: ?>
        <a href="<?php echo PAGES_DIR ?>login.php">Aggiungi al Carrello<img src="<?php echo RESOURCES_DIR ?>carrello_B.png" alt=""/></a>
    <?php endif; ?>
    <?php if($dbh->isLogged() && $dbh->getUserType() == "client"): 
        if($dbh->isProductFavourite($result["idProdotto"])): ?>
            <a href="?search=<?php echo $result["idProdotto"]; ?>&favourites=remove">Rimuovi dai Preferiti<img src="<?php echo RESOURCES_DIR ?>cuore_B.png" alt=""/></a>
        <?php else: ?>
            <a href="?search=<?php echo $result["idProdotto"]; ?>&favourites=add">Aggiungi ai Preferiti<img src="<?php echo RESOURCES_DIR ?>cuore_B.png" alt=""/></a>
        <?php endif; ?>
    <?php else: ?>
        <a href="<?php echo PAGES_DIR ?>login.php"><img src="<?php echo RESOURCES_DIR ?>cuore_B.png" alt=""/></a>
    <?php endif; ?>

    <p><?php echo $result["descrizione"] ?></p>
    <p><?php echo $result["proprieta"] ?></p>

    <p id="Reviews">Recensioni</p>
    
</section>