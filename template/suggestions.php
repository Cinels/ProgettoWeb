<section>
    <ul>
        <?php if(isset($templateParams["results"])):
            foreach($templateParams["results"] as $result): ?>
                <li><a src="#">
                    <img src="<?php echo $result["link"]?>" alt="Immagine Prodotto"/><br/>
                    <p><?php echo $result["nome"] ?></p>
                    <p><?php echo $result["prezzo"] ?>€</p> <!-- gestisci sconto -->
                </a></li>
            <?php endforeach;
        endif; ?>
    </ul>
</section>