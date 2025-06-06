<section>
    <ul>
        <?php if(isset($templateParams["results"])):
            foreach($templateParams["results"] as $result): ?>
                <li><a href="#">
                    <section>
                        <img src="<?php echo $result["link"]?>" alt="Immagine Prodotto"/><br/>
                        <p><?php echo $result["nome"] ?></p>
                        <?php if($result["offerta"] > 0) {
                            $sale = $result["prezzo"] - $result["prezzo"]*($result["offerta"]/100);
                            echo "<ins>".$sale."</ins> <del>".$result['prezzo']."</del>€";
                        } else {
                            echo "<p>".$result['prezzo']."€</p>";
                        }?>
                    </section>
                </a></li>
            <?php endforeach;
        endif; ?>
    </ul>
</section>