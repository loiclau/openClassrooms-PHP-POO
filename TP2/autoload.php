<?php

function chargerClasse($classe)
{
require './entity/' . $classe . '.class.php'; // On inclut la classe correspondante au paramètre passé.
}

spl_autoload_register('chargerClasse');
