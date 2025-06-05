<section>
    <ul>
        <?php if(isset($templateParams["results"])):
            foreach($templateParams["results"] as $result): ?>
                <li><a src="#">
                    <img src="<?php echo $result["link"]?>" alt="Immagine Prodotto"/><br/>
                    <p><?php echo $result["nome"] ?></p>
                    <?php if($result["sconto"] > 0) {
                    $sale = $result["prezzo"] - $result["prezzo"]*$result["sconto"];
                    echo "<ins>$sale</ins>€ <del>$result['prezzo']€</del>";
                } else {
                    echo "<p>$result['prezzo']€</p>";
                }?>
                </a></li>
            <?php endforeach;
        endif; ?>
    </ul>
</section>