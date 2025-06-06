<section>
    <img src="" alt="Foto Profilo"/>
    <p><?php echo $templateParams["user"]["nome"]." ".$templateParams["user"]["cognome"] ?></p>
    <!-- modifica nome -->
    <p><?php echo $templateParams["user"]["email"] ?></p>
    <!-- modifica password -->
     <p>Tipo profilo:<?php echo $templateParams["user_type"] ?></p>
    
    <form action="" method="GET"><input type="submit" name="logout" value="Esci" /></form>
</section>