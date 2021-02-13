<?php

if ((int)$manager->count() > 0) {
    $actualName = '';
    if (isset($perso)) {
        $actualName = $perso->getNom();
    }
    $basePerso = $manager->getList($actualName);
    echo '<ul>';
    foreach ($basePerso as $oldPerso) {
        echo '<li onclick="useIt(\'' . $oldPerso->getNom() . '\')" >' . $oldPerso->getNom() . '</li>';
    }
    echo '</ul>';
}
?>
<form action="" method="post">
    <p>
        Nom : <input id="name" type="text" name="nom" maxlength="50"/>
        <input type="submit" value="Utiliser ce personnage" name="utiliser"/></br>
        Type : <select name="type">
            <option value="magicien">Magicien</option>
            <option value="guerrier">Guerrier</option>
        </select>
        <input type="submit" value="Créer ce personnage" name="creer"/>
    </p>
</form>
