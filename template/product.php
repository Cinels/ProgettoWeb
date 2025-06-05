<section>
    <?php $result = $templateParams["results"][0] ?>
    <img src="<?php echo $result["link"]?>" alt="Immagine Prodotto"/><br/>
    <p><?php echo $result["nome"] ?></p>
    <a href="#"><?php echo $result["media_recensioni"] ?><img src="<?php echo RESOURCES_DIR ?>cuore.png" alt=""/></a>
    
    
    <?php if($dbh->isLogged() && $dhb->getUserType() == "client"): 
        if(true/* prodotto non nei preferiti */): ?>
            <a href="#"><img src="<?php echo RESOURCES_DIR ?>cuore.png" alt="Aggiungi ai Preferiti"/></a>
        <?php else: ?>
            <a href="#"><img src="<?php echo RESOURCES_DIR ?>cuore_B.png" alt="Aggiungi ai Preferiti"/></a>
        <?php endif;
    endif; ?>
    <p><?php echo $result["prezzo"] ?>€</p> <!-- gestisci sconto -->
    <?php if($dbh->isLogged() && $dhb->getUserType() == "client"): ?>
        <a href="#"><img src="<?php echo RESOURCES_DIR ?>carrello.png" alt="Aggiungi al Carrello"/></a>
    <?php endif; ?>
</section>