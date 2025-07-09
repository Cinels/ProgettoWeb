<section>
    <h2><?php echo $templateParams["h2"] ?></h2>
<form action="#" method="POST" enctype="multipart/form-data">
    <?php if (isset($templateParams['id'])):
    echo "<input type=\"hidden\" name=\"update\" value=".$templateParams['id'].">";
    endif;
    ?>

  <label for="image1">Immagine 1:<img src="<?php echo (isset($templateParams['id'])) ? DB_RESOURCES_DIR.$templateParams['images'][0]['link'] : ""?>" /></label><br>
  <input type="file" name="image1" id="image1" accept="image/*" <?php echo (!isset($templateParams['id']) ? "required" : "") ?>/><br><br>

  <label for="image2">Immagine 2:<img src="<?php echo (isset($templateParams['id'])) ? DB_RESOURCES_DIR.$templateParams['images'][1]['link'] : ""?>" /></label><br>
  <input type="file" name="image2" id="image2" accept="image/*"/><br><br>

  <label for="nome">Nome:</label><br>
  <input type="text" id="nome" name="nome" maxlength="50" value ="<?php echo $templateParams["product"]["nome"] ?? "" ?>" required><br><br>

  <label for="prezzo">Prezzo (€):</label><br>
  <input type="number" id="prezzo" name="prezzo" step="0.01" min="0" max="9999.99" value ="<?php echo $templateParams["product"]["prezzo"] ?? "" ?>" required><br><br>

  <label for="quantita">Quantità Disponibile:</label><br>
  <input type="number" id="quantita" name="quantitaDisponibile" min="0" value ="<?php echo $templateParams["product"]["quantitaDisponibile"] ?? "" ?>" required><br><br>

  <label for="descrizione">Descrizione:</label><br>
  <textarea id="descrizione" name="descrizione" maxlength="500" rows="10" cols="50" required><?php echo $templateParams["product"]["descrizione"] ?? "" ?></textarea><br><br>

  <label for="proprieta">Proprietà:</label><br>
  <textarea id="proprieta" name="proprieta" maxlength="300" rows="5" cols="25"><?php echo $templateParams["product"]["proprieta"] ?? "" ?></textarea><br><br>

  <label for="offerta">Offerta (%):</label><br>
  <input type="number" id="offerta" name="offerta" min="0" max="99" value ="<?php echo $templateParams["product"]["offerta"] ?? "" ?>" required><br><br>

  <label for="tipo">Tipo :</label><br>
  <select id="tipo" name="tipo" required>
    <option value="">-- Seleziona un tipo --</option>
    <option value="1" <?php echo $templateParams["product"]["tipo"] == 1 ? "selected" : "" ?>>Console</option>
    <option value="2" <?php echo $templateParams["product"]["tipo"] == 2 ? "selected" : "" ?>>Controller</option>
    <option value="3" <?php echo $templateParams["product"]["tipo"] == 3 ? "selected" : "" ?>>Videogioco</option>
  </select><br><br>

  <label for="piattaforma">Piattaforma :</label><br>
  <select id="piattaforma" name="piattaforma" required>
    <option value="">-- Seleziona un piattaforma --</option>
    <option value="1" <?php echo $templateParams["product"]["idPiattaforma"] == 1 ? "selected" : "" ?>>Nintendo</option>
    <option value="2" <?php echo $templateParams["product"]["idPiattaforma"] == 2 ? "selected" : "" ?>>Sony</option>
    <option value="3" <?php echo $templateParams["product"]["idPiattaforma"] == 3 ? "selected" : "" ?>>Microsoft</option>
  </select><br><br>

  <button type="submit"><?php echo $templateParams["h2"] ?><img src="<?php echo RESOURCES_DIR."Marco_semplice_W.png"?>" alt="" name ="update" /></button>
</form>
<?php if(isset($templateParams['id'])): ?>
 <a href="product.php?search=<?php echo $templateParams['id'] ?>"><button type="button">Annulla<img src="<?php echo RESOURCES_DIR."x.png"?>" alt="" name ="cancel"/></button><a>
<?php endif; ?>

</section>