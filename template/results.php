<section>
    <ul>
        <?php if(isset($templateParams["results"])):
            foreach($templateParams["results"] as $result): ?>
                <li>
                    <img src="<?php echo $result["link"]?>" alt="Immagine Prodotto"/><br/>
                    <p><?php echo $result["nome"] ?></p>
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
                </li>
            <?php endforeach;
        endif; ?>
    </ul>
</section>