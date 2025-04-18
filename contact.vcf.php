<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (($_POST['pwd'] ?? '') === '2025') {
    header('Content-Type: text/vcard');
    header('Content-Disposition: attachment; filename="contacts.vcf"');
    readfile(__DIR__ . '/contact.vcf');
    exit;
  } else {
    $err = "Mot de passe incorrect.";
  }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Téléchargement sécurisé</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>Téléchargement sécurisé</h1>
    <form method="POST">
      <input type="password" name="pwd" placeholder="Entrez le code" required>
      <button type="submit">Valider</button>
    </form>
    <?php if (!empty($err)): ?>
      <p class="error"><?= htmlspecialchars($err) ?></p>
    <?php endif; ?>
    <a href="index.html" class="btn">Retour à l'accueil</a>
  </div>
</body>
</html>
