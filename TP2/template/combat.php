<fieldset>
    <legend>Qui frapper ?</legend>
    <p>
        <?php
        $persos = $manager->getList($perso->getNom());

        if (empty($persos)) {
            echo 'Personne à frapper !';
        } elseif ($perso->estEndormi()) {
            echo 'Vous etes endormi! reveil dans ' . $perso->reveil() . '.';
        } else {
            foreach ($persos as $unPerso) {
                if ($unPerso->estEndormi()) {
                    echo ' zZz ';
                } else {
                    echo ' \o/ ';
                }
                echo htmlspecialchars($unPerso->getNom()) . ', lvl-' . (int)$unPerso->getLvl() .
                    ' (dégâts : ' . $unPerso->getDegats() . ') ' .
                    ' (type : ' . $unPerso->getType() . ')';

                echo '<a href="?frapper=' . $unPerso->getId() . '"> Frapper </a>';

                if ($perso->getType() == 'magicien') {
                    echo '<a href="?ensorceler=' . $unPerso->getId() . '"> Endormir </a><br />';
                }
            }

        }
        ?>
    </p>
</fieldset>