<?php if($sessions['total'] > 0):
    $mount = 0;
    $first = true;
    foreach ($sessions["items"] as $session):
        if ((new \Datetime($session["dateBegin"]))->format("F") !== $mount):
            $mount = (new \Datetime($session["dateBegin"]))->format("F");
            if (!$first): ?>
                </ul></div>
            <?php endif; ?>
            <div>
                <h2><?php setlocale (LC_TIME, 'fr_FR.utf-8','fra'); echo ucfirst(utf8_encode(strftime("%B %Y", (new \Datetime($session["dateBegin"]))->getTimestamp())));?></h2>
                <ul class="sygefor-stages-list">
            <?php $first = false; ?>
        <?php endif; ?>
        <li>
            <a href="<?php echo get_page_link(get_option("sygefor3_training_page"));?>?stage=<?php echo $session['training']['id'];?>&theme=<?php echo $_GET['theme'];?>&search=<?php echo $_GET['search'];?>">
                <?php echo $session['training']['name'];?>
            </a><br />
            <em style="font-size:15px;margin-left:10px;display:block">
                <?php if (!$session["dateEnd"] || $session["dateBegin"] === $session["dateEnd"]) :?>
                Le <?php echo (new \Datetime($session["dateBegin"]))->format("d/m/Y");?><br />
                <?php else: ?>
                Du <?php echo (new \Datetime($session["dateBegin"]))->format("d/m/Y");?> au <?php echo (new \Datetime($session["dateEnd"]))->format("d/m/Y");?><br />
                <?php endif; ?>
                Thème : <?php echo $session["training"]['theme'];?><br />
                <?php if(count($session["training"]["publicTypes"]) > 0): ?>
                    Public<?php if(count($session["training"]["publicTypes"]) > 1) { echo "s"; }?> :
                    <?php
                    $count = -1;
                    foreach ($session["training"]["publicTypes"] as $publicType) {
                        if (++$count > 0) {
                            echo ", ";
                        }
                        echo $publicType;
                    } ?>
                <?php else: ?>
                    Publics : Tous publics URFIST
                <?php endif; ?>
            </em>
        </li>
    <?php endforeach; ?>
    </ul>
</div>
<?php else: ?>
    <h2>Aucune session trouvée</h2>
<?php endif; ?>