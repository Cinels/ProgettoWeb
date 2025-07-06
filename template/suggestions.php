<section>
    <form action="<?php echo PAGES_DIR ?>product.php" method="GET">
        <?php foreach($templateParams["side_content"] as $content):
            $templateParams["subtitle"] = $templateParams["subtitles"][array_search($content, $templateParams["side_content"])];
            $templateParams["results"] = $content; ?>
        <?php if(isset($templateParams["results"]) && count($templateParams["results"]) > 0):
            echo "<h2>".$templateParams['subtitle']."</h2>";
            foreach($templateParams["results"] as $result): ?>
                <button type="submit" name="search" value="<?php echo $result["idProdotto"] ?>">
                    <img src="<?php echo DB_RESOURCES_DIR.$result["link"]?>" alt="Immagine Prodotto"/><br/>
                    <?php echo $result["nome"] ?><br/>
                    <?php if($result["offerta"] > 0) {
                        echo "<ins>".$result["offerta"]."% ".$result["prezzoScontato"]."</ins> <del>".$result['prezzo']."</del> €";
                    } else {
                        echo "<p>".$result['prezzo']." €</p>";
                    }?>
                </button>
            <?php endforeach;
        endif; 
    endforeach;?>
    </form>
</section>