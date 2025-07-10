<section>
    <h2>I tuoi prodotti</h2>
<ul>
<?php if(isset($templateParams["products"]) && count($templateParams["products"]) > 0):
    foreach($templateParams["products"] as $product): ?>
        <li>
            <a href="<?php echo PAGES_DIR."product.php?search=".$product["idProdotto"] ?>">
                <img src="<?php echo DB_RESOURCES_DIR.$product['link']?>" alt="Immagine Prodotto"/><br/>
                <?php echo $product["nome"] ?></a><br/>
                <?php if($product["offerta"] > 0) {
                    echo "<ins>".$product["offerta"]."% ".$product['prezzoScontato']."</ins> <del>".$product['prezzo']."</del> €";
                } else {
                    echo "<p>".$product['prezzo']." €</p>";
                }?>
                <p><?php echo $product['media_recensioni']."/5 (".$product['num_recensioni'].")" ?></p>
                <p>Descrizione: <?php echo $product["descrizione"] ?></p>
                <p>Quantità: <?php echo $product["quantitaDisponibile"] ?></p>
            <a href="manage_product.php?product=<?php echo $product['idProdotto'] ?>"><button type="button">Modifica<img src="<?php echo RESOURCES_DIR."matita.png"?>" alt="" name ="modify"/></button><a>
            <form action='#' method="POST">
                <input type="hidden" name="id" value="<?php echo $product['idProdotto'] ?>">
                <button type="submit">Elimina<img src="<?php echo RESOURCES_DIR."cestino_B.png"?>" alt="" name ="delete" /></button>
            </form>
        </li>
    <?php endforeach;
        endif; ?>
    </ul>
    </section>