<?php
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    if (file_exists('contacts.txt')) {
        $lignes = file('contacts.txt', FILE_IGNORE_NEW_LINES);

        if (isset($lignes[$id])) {
            // On retire la ligne avec unset()
            unset($lignes[$id]);

            // On réécrit tout le fichier sans la ligne supprimée
            file_put_contents('contacts.txt', implode("\n", $lignes));
        }
    }
}

header('Location: index.php');
exit;