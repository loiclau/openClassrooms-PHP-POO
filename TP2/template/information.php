<fieldset>
    <legend>Mes informations</legend>
    <p>
        Nom : <?= htmlspecialchars($perso->getNom()) ?><br/>
        Type : <?= $perso->getType() ?><br/>
        Force : <?= $perso->getForce() ?><br/>
        Dégâts : <?= $perso->getDegats() ?><br/>
        Lvl : <?= $perso->getLvl() ?><br/>
        Exp : <?= $perso->getExp() ?><br/>
        <?php
        switch ($perso->getType()) {
            case 'magicien':
                echo 'Magie : ';
                break;
            case 'guerrier':
                echo 'Esquive : ';
                break;
        }
        echo $perso->getAtout() ?>
    </p>
</fieldset>