<section>
    <h2>Pagamento</h2>
    <!-- Rifai vedere somma -->
    <p>Totale articoli:<?php echo $templateParams["tot"].'€' ?></p>
    <p>Costi di spedizione: 2</p>
    <strong>Totale da pagare:</strong>

    <p>Consegna prevista:</p>
    <p>Via Cesare Pavese, 50, 47521 Cesena FC</p>

    <form action="#" method="POST">

        <label for="n_card">Numero carta:</label>
        <input type="text" id="n_card" name="card_number" inputmode="numeric" pattern="\d{16}" minlength="16" maxlength="16" required/></br>
        <label for="exp_date">Data di scadenza:</label>
        <input type="month" id="exp_date" name="expire_date" min="<?php echo date("Y") ?>-<?php echo date("m")?>" max="<?php echo date("Y")+10?>-<?php echo date("m")?>" required/></br>
        <label for="ccv">CCV:</label>
        <input type="text" id="ccv" name="ccv" inputmode="numeric" pattern="\d{3}" maxlength="3" required/></br>
        <button type="submit" name="buy">Acquista ora<img src="<?php echo RESOURCES_DIR."pay.png"?>" alt="" name ="pay"/>
</button>
</form>
    <a href="cart.php"><button type="button">Annulla<img src="<?php echo RESOURCES_DIR."x.png"?>" alt="" name ="cancel"/></button><a>
</section>