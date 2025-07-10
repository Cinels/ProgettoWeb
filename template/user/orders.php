<section>
    <!-- <?php //echo $templateParams['order_state'][$result["statoOrdine"]-1]?> !-->
    <h2>Ordini</h2>
    <ul>
        <?php if(isset($templateParams["results"]) && count($templateParams["results"]) > 0):
            foreach($templateParams["results"] as $result): 
                $templateParams['details'] = $dbh->getOrderDetails($result["idOrdine"]);?>
                <li>
                    <p>N° Ordine: <?php echo $result["idOrdine"] ?></p>
                    <p>Totale: <?php echo $result["costoTotale"].'€' ?></p>
                    <p>Data ordine: <?php echo strftime("%A %d %B", time()); ?></p>
                    <p>Stato ordine: 
                        <!-- Da qua !--> <form action="#" method="POST">
                            <input type="hidden" name="id" value="<?php echo $result["idOrdine"] ?>">
                            <select id="stato" name="stato" required>
                                <option value="1" <?php echo $result["statoOrdine"] == 1 ? "selected" : "" ?>><?php echo $templateParams['order_state'][0] ?></option>
                                <option value="2" <?php echo $result["statoOrdine"] == 2 ? "selected" : "" ?>><?php echo $templateParams['order_state'][1] ?></option>
                                <option value="3" <?php echo $result["statoOrdine"] == 3 ? "selected" : "" ?>><?php echo $templateParams['order_state'][2] ?></option>
                                <option value="4" <?php echo $result["statoOrdine"] == 4 ? "selected" : "" ?>><?php echo $templateParams['order_state'][3] ?></option>
                            </select>
                        </form> <!-- A qua !--> 
                    </p>

                    <p>Consegna: <?php echo strftime("%A %d %B", strtotime('+1 day', time())); ?></p>
                    <p>Venditore: <?php echo $result["idVenditore"] ?></p>

                    <ul>
                        <?php if(isset($templateParams["details"]) && count($templateParams["details"]) > 0):
                            foreach($templateParams["details"] as $detail): ?>
                                <li>
                                    <a href="<?php echo PAGES_DIR."product.php?search=".$detail["idProdotto"] ?>">
                                        <img src="<?php echo DB_RESOURCES_DIR.$detail['link']?>" alt="Immagine Prodotto"/><br/>
                                        <?php echo $detail["nome"] ?></a><br/>
                                        <?php if($detail["offerta"] > 0) {
                                            echo "<ins>".$detail["offerta"]."% ".$detail['prezzoScontato']."</ins> <del>".$detail['prezzo']."</del> €";
                                        } else {
                                            echo "<p>".$detail['prezzo']." €</p>";
                                        }?>
                                        <p><?php echo $detail['media_recensioni']."/5 (".$detail['num_recensioni'].")" ?></p>
                                        <p>Descrizione: <?php echo $detail["descrizione"] ?></p>
                                        <p>Quantità: <?php echo $detail["quantita"] ?></p>
                                </li>
                            <?php endforeach;
                        endif; ?>
                    </ul>
                </li>
            <?php endforeach;
        endif; ?>
    </ul>
</section>