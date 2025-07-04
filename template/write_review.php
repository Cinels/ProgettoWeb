<?php $product = $templateParams['product'][0] ?>
<h2>Recensisci <?php echo $product['nome'] ?></h2>
<img src="<?php echo DB_RESOURCES_DIR.$templateParams['img']['link'] ?>" />
<form action="#" method="POST">
    <input type="hidden" id="id" name="id" value=<?php echo $product['idProdotto'] ?>>
    <input type="radio" id="onestar" name="vote" value="1" required>
    <label for="onestar">1</label>
    <input type="radio" id="twostar" name="vote" value="2">
    <label for="twostar">2</label>
    <input type="radio" id="threestar" name="vote" value="3">
    <label for="threestar">3</label>
    <input type="radio" id="fourstar" name="vote" value="4">
    <label for="fourstar">4</label>
    <input type="radio" id="fivestar" name="vote" value="5">
    <label for="fivestar">5</label><br/>
    <textarea id="desc" name="descrizione" rows="6" cols="50"></textarea><br/>
    <input type="submit" name="Invia">
</form>