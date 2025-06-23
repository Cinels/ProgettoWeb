<section>
    <img src="<?php echo $templateParams["user"]["fotoProfilo"] ?? RESOURCES_DIR."header/utente.png"; ?>" alt="Foto Profilo"/>
    <p><?php echo $templateParams["user"]["nome"]." ".$templateParams["user"]["cognome"] ?></p>
    <!-- modifica nome -->
    <p><?php echo $templateParams["user"]["email"] ?></p>
    <!-- modifica password -->
     <p>Tipo profilo:<?php echo $templateParams["user_type"] ?></p>
    
    <form action="" method="GET">
        <button type="submit" name="logout" value="Esci">Esci<img src="<?php echo RESOURCES_DIR ?>exit.png" alt=""/></button>
    </form>
</section>