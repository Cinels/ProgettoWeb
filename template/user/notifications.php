<section>
    <img src="<?php RESOURCES_DIR ?>campanella.png" alt=""/>
    <h2>Notifiche</h2>
    <ul>
        <?php if(isset($templateParams["notifications"]) && count($templateParams["notifications"]) > 0):
            foreach($templateParams["notifications"] as $notification): ?>
                <li>
                    <h3><?php echo $notification["tipo"]/*." ".$notification["data"] */; ?></h3>
                    <p><?php echo $notification["testo"]; ?></p>
                    <?php if($notification["letta"]): ?>
                        <a href="?id=<?php echo $notification["idNotifica"]; ?>&notification=unread"><img src="" alt="Segna come da leggere"/></a>
                    <?php else: ?>
                        <a href="?id=<?php echo $notification["idNotifica"]; ?>&notification=read"><img src="" alt="Segna come gia letta"/></a>
                    <?php endif; ?>
                    <a href="?id=<?php echo $notification["idNotifica"]; ?>&notification=delete"><img src="" alt="Elimina"/></a>
                </li>
            <?php endforeach;
        endif; ?>
    </ul>
</section>