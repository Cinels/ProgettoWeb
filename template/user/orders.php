<section>
    <h2>Ordini</h2>
    <ul>
        <?php if(isset($templateParams["results"]) && count($templateParams["results"]) > 0):
            foreach($templateParams["results"] as $result): 
                $templateParams['details'] = $dbh->getOrderDetails($result["idOrdine"]);?>
                <li>
                    <p>N° Ordine: <?php echo $result["idOrdine"] ?></p>
                    <p>Totale: <?php echo $result["costoTotale"] ?></p>
                    <p>Data ordine: <p><?php echo strftime("%A %d %B", time()); ?></p></p>
                    <p>Stato ordine: <?php echo $result["statoOrdine"] ?></p>
                    <p>Consegna: <?php echo strftime("%A %d %B", strtotime('+1 day', time())); ?></p>
                    <p>Venditore: <?php echo $result["idVenditore"] ?></p>

                    <ul>
                        <?php if(isset($templateParams["details"]) && count($templateParams["details"]) > 0):
                            foreach($templateParams["details"] as $detail): ?>
                                <li>
                                    <a href="<?php echo PAGES_DIR."product.php".$detail["idProdotto"] ?>">
                                        <img src="<?php echo DB_RESOURCES_DIR.$detail['link']?>" alt="Immagine Prodotto"/><br/>
                                        <?php echo $detail["nome"] ?><br/>
                                        <?php if($detail["offerta"] > 0) {
                                            $sale = $detail["prezzo"] - $detail["prezzo"]*($detail["offerta"]/100);
                                            echo "<ins>".$detail["offerta"]."% ".$sale."</ins> <del>".$detail['prezzo']."</del> €";
                                        } else {
                                            echo "<p>".$detail['prezzo']." €</p>";
                                        }?>
                                        <p><?php echo $detail['media_recensioni']." ".$detail['num_recensioni'] ?></p>
                                        <p>Descrizione: <?php $detail["descrizione"] ?></p>
                                        <p>Quantità: <?php echo $detail["quantita"] ?></p>
                                    </a>
                                </li>
                            <?php endforeach;
                        endif; ?>
                    </ul>
                </li>
            <?php endforeach;
        endif; ?>
    </ul>
</section>