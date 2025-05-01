<?php
// Initialisation des variables
$nom = $prenom = $telephone = $email = "";
$erreurs = [];

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $email = trim($_POST['email'] ?? '');

    // Vérification des champs obligatoires
    if (!$nom || !$prenom || !$telephone) {
        $erreurs[] = "Nom, prénom et téléphone sont obligatoires.";
    }

    // Vérification du format du téléphone
    if (!preg_match('/^[0-9]{10}$/', $telephone)) {
        $erreurs[] = "Le numéro de téléphone doit contenir exactement 10 chiffres.";
    }

    // Vérification de l'email s'il est rempli
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "L'adresse email n'est pas valide.";
    }

    // Si tout est bon, on enregistre
    if (empty($erreurs)) {
        $ligne = "$nom;$prenom;$telephone;$email\n";
        file_put_contents('contacts.txt', $ligne, FILE_APPEND);
        header('Location: index.php?ajout=ok');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un contact</title>
</head>
<body>
    <h1>Ajouter un contact</h1>

    <?php if (!empty($erreurs)): ?>
        <ul style="color: red;">
            <?php foreach ($erreurs as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST">
        <label>Nom :</label><br>
        <input type="text" name="nom" value="<?= htmlspecialchars($nom) ?>" required><br><br>

        <label>Prénom :</label><br>
        <input type="text" name="prenom" value="<?= htmlspecialchars($prenom) ?>" required><br><br>

        <label>Téléphone :</label><br>
        <input type="text" name="telephone" value="<?= htmlspecialchars($telephone) ?>" required><br><br>

        <label>Email (facultatif) :</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($email) ?>"><br><br>

        <button type="submit">Ajouter</button>
    </form>

    <br>
    <a href="index.php">← Retour à la liste des contacts</a>
</body>
</html>