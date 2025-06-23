<section>
    <form action="<?php echo PAGES_DIR ?>product.php" method="GET">
        <?php if(isset($templateParams["results"]) && count($templateParams["results"]) > 0):
            echo "<h2>".$templateParams['subtitle']."</h2>";
            foreach($templateParams["results"] as $result): ?>
                <button type="submit" name="search" value="<?php echo $result["idProdotto"] ?>">
                    <img src="<?php echo $result["link"]?>" alt="Immagine Prodotto"/><br/>
                    <?php echo $result["nome"] ?><br/>
                    <?php if($result["offerta"] > 0) {
                        $sale = $result["prezzo"] - $result["prezzo"]*($result["offerta"]/100);
                        echo "<ins>".$result["offerta"]."% ".$sale."</ins> <del>".$result['prezzo']."</del> €";
                    } else {
                        echo "<p>".$result['prezzo']." €</p>";
                    }?>
                </button>
            <?php endforeach;
        endif; ?>
    </form>
</section>