<?php

include('autoload.php');
include('PersonnagesManager.class.php');
//echo '<pre>';
session_start(); // On appelle session_start() APRÈS avoir enregistré l'autoload.

if (isset($_GET['deconnexion'])) {
    session_destroy();
    header('Location: .');
    exit();
}

if (isset($_SESSION['perso'])) // Si la session perso existe, on restaure l'objet.
{
    $perso = $_SESSION['perso'];
}

$db = new PDO('mysql:host=localhost;dbname=ocpoo', 'iamroot', 'iamroot');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une requête a échoué.

$manager = new PersonnagesManager($db);

if (isset($_POST['creer']) && isset($_POST['nom'])) // Si on a voulu créer un personnage.
{
    $class = ucfirst($_POST['type']);
    $perso = new $class(['nom' => $_POST['nom']]); // On crée un nouveau personnage.

    if (!$perso->nomValide()) {
        $message = 'Le nom choisi est invalide.';
        unset($perso);
    } elseif ($manager->exists($perso->getNom())) {
        $message = 'Le nom du personnage est déjà pris.';
        unset($perso);
    } else {
        $manager->add($perso);
    }
} elseif (isset($_POST['utiliser']) && isset($_POST['nom'])) // Si on a voulu utiliser un personnage.
{
    if ($manager->exists($_POST['nom'])) // Si celui-ci existe.
    {
        $perso = $manager->get($_POST['nom']);
    } else {
        $message = 'Ce personnage n\'existe pas !'; // S'il n'existe pas, on affichera ce message.
    }
} elseif (isset($_GET['frapper'])) // Si on a cliqué sur un personnage pour le frapper.
{
    if (!isset($perso)) {
        $message = 'Merci de créer un personnage ou de vous identifier.';
    } else {
        if (!$manager->exists((int)$_GET['frapper'])) {
            $message = 'Le personnage que vous voulez frapper n\'existe pas !';
        } else {
            $persoAFrapper = $manager->get((int)$_GET['frapper']);
            $retour = $perso->frapper($persoAFrapper); // On stocke dans $retour les éventuelles erreurs ou messages que renvoie la méthode frapper.
            switch ($retour) {
                case Personnage::CEST_MOI :
                    $message = 'Mais... pourquoi voulez-vous vous frapper ???';
                    break;
                case Personnage::ESQUIVE_REUSSI :
                    $message = 'Le personnage a esquivé !';
                    break;
                case Personnage::PERSONNAGE_FRAPPE :
                    $message = 'Le personnage a bien été frappé !';

                    if ($persoAFrapper->estEndormi() && rand(0, 75) > 50) {
                        $persoAFrapper->setTimeEndormi(time());
                        $message .= ' Le coup a reveillé le personnage.';
                    } elseif ($persoAFrapper->estEndormi()) {
                        $message .= 'Le personnage dors toujours.';
                    }

                    $manager->update($perso);
                    $manager->update($persoAFrapper);
                    break;
                case Personnage::PERSONNAGE_TUE :
                    $message = 'Vous avez tué ce personnage !';
                    $manager->update($perso);
                    $manager->delete($persoAFrapper);
                    break;
                case Personnage::PERSONNAGE_ENDORMI :
                    $message = 'Vous etes endormi !';
                    break;
            }


        }
    }
} elseif (isset($_GET['ensorceler'])) // Si on a cliqué sur un personnage pour l ensorceler.
{
    if (!isset($perso)) {
        $message = 'Merci de créer un personnage ou de vous identifier.';
    } else {
        if ($perso->getType() != 'magicien') {
            echo 'seuls les magiciens peuvent ensorceler';
        } elseif (!$manager->exists((int)$_GET['ensorceler'])) {
            $message = 'Le personnage que vous voulez ensorceler n\'existe pas !';
        } else {
            $persoAEnsorceler = $manager->get((int)$_GET['ensorceler']);
            $retour = $perso->ensorceler($persoAEnsorceler); // On stocke dans $retour les éventuelles erreurs ou messages que renvoie la méthode frapper.

            switch ($retour) {
                case Personnage::CEST_MOI :
                    $message = 'Mais... pourquoi voulez-vous vous ensorceler ???';
                    break;
                case Personnage::PERSONNAGE_ENSORCELE :
                    $message = 'Le personnage a bien été ensorcelé !';
                    $manager->update($perso);
                    $manager->update($persoAEnsorceler);
                    break;
                case Personnage::PAS_DE_MAGIE :
                    $message = 'Vous n\'avez pas de magie !';
                    break;
                case Personnage::PERSONNAGE_ENDORMI :
                    $message = 'Vous etes endormi !';
                    break;
            }
        }
    }
}
?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>TP : Mini jeu de combat</title>
        <meta charset="utf-8"/>
    </head>
    <body>
    <p>Nombre de personnages créés : <?= $manager->count() ?></p>
    <?php
    if (isset($message)) // On a un message à afficher ?
    {
        echo '<p>', $message, '</p>'; // Si oui, on l'affiche.
    }

    if (isset($perso)) // Si on utilise un personnage (nouveau ou pas).
    {
        ?>
        <p><a href="?deconnexion=1">Déconnexion</a></p>
        <?php
        include './template/information.php';
        include './template/combat.php';
    } else {
        include './template/creationPage.php';
    }
    ?>
    <script>
        function useIt(perso) {
            document.getElementById('name').value = perso;
        }
    </script>
    </body>
    </html>

<?php
if (isset($perso)) // Si on a créé un personnage, on le stocke dans une variable session afin d'économiser une requête SQL.
{
    $_SESSION['perso'] = $perso;
}
