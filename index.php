<?php
// Lire le fichier contacts.txt
$contacts = [];

if (file_exists('contacts.txt')) {
    $fichier = fopen('contacts.txt', 'r');

    while (($ligne = fgets($fichier)) !== false) {
        $donnees = explode(';', trim($ligne)); // Nom;Prenom;Tel;Email
        if (count($donnees) === 4) {
            $contacts[] = $donnees;
        }
    }

    fclose($fichier);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Carnet de Contacts</title>
</head>
<body>
    <h1>Liste des contacts</h1>

    <?php if (isset($_GET['ajout']) && $_GET['ajout'] === 'ok'): ?>
        <p style="color: green;">Contact ajouté avec succès !</p>
    <?php endif; ?>

    <a href="ajouter.php">➕ Ajouter un contact</a><br><br>

    <?php if (empty($contacts)): ?>
        <p>Aucun contact enregistré.</p>
    <?php else: ?>
        <table border="1" cellpadding="8">
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Téléphone</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <?php foreach ($contacts as $index => $contact): ?>
                <tr>
                    <td><?= htmlspecialchars($contact[0]) ?></td>
                    <td><?= htmlspecialchars($contact[1]) ?></td>
                    <td><?= htmlspecialchars($contact[2]) ?></td>
                    <td><?= htmlspecialchars($contact[3]) ?></td>
                    <td>
                        <a href="supprimer.php?id=<?= $index ?>" onclick="return confirm('Supprimer ce contact ?');">
                            ❌ Supprimer
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>