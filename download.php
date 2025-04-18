<?php
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (($_POST['pwd'] ?? '') === '2025') {
    header('Content-Type: text/vcard');
    header('Content-Disposition: attachment; filename="contacts.vcf"');
    readfile(__DIR__ . '/contact.vcf');
    exit;
  } else {
    $error = 'Mot de passe incorrect.';
  }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Téléchargement – WhatsApp Views</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>Télécharger les contacts</h1>
    <form method="POST" class="form">
      <input type="password" name="pwd" placeholder="Entrez le code" required>
      <button type="submit">Télécharger</button>
    </form>
    <?php if ($error): ?>
      <div class="alert error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <a href="index.html" class="btn link-home">← Retour à l’accueil</a>
  </div>
</body>
</html>
