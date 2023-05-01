<?php

/**
 * Fichier a déclencher periodiquement pour recuperer les calendriers à jour
 */
include 'icsparseclass/FileReader.php';

$reader = new FileReader();
$reader->updateAllCalendars();




