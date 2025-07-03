<section>
    <ul>
        <?php if(isset($templateParams["reviews"]) && count($templateParams["reviews"]) > 0):
            for ($i = 0; $i < $templateParams['n_rev']; $i++): ?>
                <li>
                    <div class='flexbox'>
                    <span> <?php echo $templateParams['reviews'][$i]['nome'].' '.$templateParams['reviews'][$i]['cognome'] ?> </span>
                    <span> <?php echo $templateParams['reviews'][$i]['voto'].'/5' ?> <img src="<?php echo RESOURCES_DIR.$templateParams['reviews'][$i]['voto'].'_star.png'?>" /> </span>
            </div>
                    <p> <?php echo $templateParams['reviews'][$i]['descrizione'] ?> </p>
            </li>
            <?php endfor;
            if(count($templateParams["reviews"]) > 4 && !isset($_GET['morerev'])): ?>
            <a href = "<?php echo '?search='.$result['idProdotto'].'&morerev#Reviews' ?>">Visualizza altro</a>
                   <?php endif; endif; ?>
</ul>
</section>