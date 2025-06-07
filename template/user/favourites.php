<section>
    <h2>Preferiti</h2>
    <form action="" method="GET">
        <?php if(isset($templateParams["results"]) && count($templateParams["results"]) > 0):
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
                    <!-- <p><?php echo $result['media_recenisoni']." ".$result['num_recensioni'] ?></p> -->
                    <p>Venditore: <?php echo $result['idVenditore'] ?></p>
                    <p>Consegna prevista: <?php echo date('d-m-y h:m') ?></p>
                    <a href="">Rimuovi<img src="<?php echo RESOURCES_DIR?>cestino_B.png" alt=""></a>
                    <a href="">Sposta nel Carrello<img src="<?php echo RESOURCES_DIR?>carrello_B.png" alt=""></a>
                </button>
            <?php endforeach;
        endif; ?>
    </form>
</section>